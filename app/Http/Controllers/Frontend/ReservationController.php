<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\DataRekomendasi;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\TripayPaymentService;
use App\Services\TripayService;

use function PHPUnit\Framework\isEmpty;

class ReservationController extends Controller
{
    public function stepOne(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $min_date = Carbon::today();
        $max_date = Carbon::now()->addWeek();
        return view('reservations.step-one', compact('reservation', 'min_date', 'max_date'));
    }

    // storeStepOne - Pengalihan ke step-two
    public function storeStepOne(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'res_date' => ['required', 'date', new DateBetween, new TimeBetween],
            'tel_number' => ['required', 'regex:/^08[0-9]{8,13}$/'],
            'guest_number' => ['required'],
        ], [
            'tel_number.regex' => 'Nomor handphone harus dimulai dengan 08 dan terdiri dari 10-14 digit angka.',
        ]);

        $reservation = $request->session()->get('reservation', new Reservation());
        $reservation->fill($validated);
        $request->session()->put('reservation', $reservation);

        return to_route('reservations.step-two');
    }

    // Step 2: Memilih Meja & Opsi Memesan Menu
    public function stepTwo(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        if (!$reservation) {
            return redirect()->route('reservations.step-one')->with('error', 'Please complete the reservation form first.');
        }
        $res_table_ids = Reservation::where('res_date', $reservation->res_date)
            ->where('status', '!=', 'cancelled')
            ->pluck('table_id');
        $tables = Table::where('status', 'available')
            ->where('guest_number', '>=', $reservation->guest_number)
            ->whereNotIn('id', $res_table_ids)
            ->get();
        $menus = Menu::all();
        return view('reservations.step-two', compact('tables', 'reservation', 'menus'));
    }

    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate([
            'table_id' => ['required'],
            'order_menu' => ['nullable', 'boolean'],
        ]);
        $reservation = $request->session()->get('reservation');
        $reservation->table_id = $validated['table_id'];
        $reservation->order_menu = $request->has('order_menu') ? 1 : 0;
        $request->session()->put('reservation', $reservation);
        if ($reservation->order_menu) {
            return to_route('reservations.step-three');
        }
        return to_route('reservations.step-four');
    }

    // Step 3: Memilih Menu
    public function stepThree(Request $request)
    {
        // ngambil cust_uid dari cookie
        $cust_uid = $request->cookie("cust_uid");
        // dd($cust_uid);

        $menuId = DataRekomendasi::where("cust_uid", $cust_uid)
            ->value("menu_id");
        // dd($menuId);

        if ($menuId) {
            $ids = collect(explode(",", $menuId))
                ->map(fn($v) => trim($v))
                ->filter()
                ->map(fn($v) => (int) $v)
                ->all();

            $namaMenuRekomendasi = Menu::whereIn('id', $ids)
                ->pluck('name');

            // dd($namaMenuRekomendasi);
        } else {
            $namaMenuRekomendasi = collect();
            // dd($namaMenuRekomendasi);
        }

        $reservation = $request->session()->get('reservation');
        if (!$reservation) {
            return redirect()->route('reservations.step-one')
                ->with('error', 'Please complete the reservation form first.');
        }

        $categories = Category::all();
        $menusQuery = Menu::query();
        if ($request->filled('search')) {
            $menusQuery->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category')) {
            $menusQuery->whereIn('category_id', $request->category);
        }
        $menus = $menusQuery->get();

        return view(
            'reservations.step-three',
            compact('menus', 'reservation', 'categories', 'namaMenuRekomendasi')
        );
    }

    public function storeStepThree(Request $request)
    {
        //$categories = Category::with('menus')->get();

        $validated = $request->validate([
            'menu_items' => ['required', 'array'],
            'menu_items.*' => ['exists:menus,id'],
            'quantities' => ['required', 'array'],
            'quantities.*' => ['integer', 'min:1'],
        ]);

        $reservation = $request->session()->get('reservation');

        // $menuItems = $validated['menu_items'];
        // $quantities = $validated['quantities'];

        $menuItemsWithQuantity = [];

        foreach ($validated['menu_items'] as $menuId) {
            $qty = $validated['quantities'][$menuId] ?? 1;
            $menuItemsWithQuantity[] = [
                'menu_id' => (int)$menuId,
                'quantity' => (int)$qty,
            ];
        }

        $reservation->menu_items = json_encode($menuItemsWithQuantity);
        $request->session()->put('reservation', $reservation);

        return to_route('reservations.step-four');
    }


    // Step 4: Pembayaran
    public function stepFour(Request $request)
    {
        $reservation = $request->session()->get('reservation');

        if (!$reservation) {
            return redirect()->route('reservations.step-one')->with('error', 'Please complete the reservation form first.');
        }

        $overPeopleFee = 0;
        $overPeopleCount = 0;
        $overPeopleFeePerPerson = 10000;
        if ($reservation->guest_number > 10) {
            $overPeopleCount = $reservation->guest_number - 10;
            $overPeopleFee = $overPeopleCount * $overPeopleFeePerPerson;
        }

        $totalCost = 0;
        if (!empty($reservation->menu_items)) {
            $menuItems = json_decode($reservation->menu_items, true);

            foreach ($menuItems as $item) {
                $menu = Menu::find($item['menu_id']);
                if ($menu) {
                    $totalCost += $menu->price * $item['quantity'];
                }
            }
        } else {
            $totalCost = $reservation->guest_number * 50000;
        }

        $channelsPayment = app(TripayService::class)->getPaymentChannels();

        return view('reservations.step-four', compact(
            'totalCost',
            'reservation',
            'channelsPayment',
            'overPeopleFee',
            'overPeopleCount',
            'overPeopleFeePerPerson'
        ));
    }

    public function storeStepFour(Request $request)
    {
        Log::info('Mulai proses storeStepFour reservasi', ['input' => $request->all()]);
        $reservation = $request->session()->get('reservation');

        if (!$reservation) {
            return redirect()->route('reservations.step-one')->with('error', 'Please complete the reservation form first.');
        }

        $reservationModel = new Reservation();
        $reservationModel->first_name = $reservation->first_name ?? 'John';
        $reservationModel->last_name = $reservation->last_name ?? 'Doe';
        $reservationModel->email = $reservation->email ?? 'default@example.com';
        $reservationModel->tel_number = $reservation->tel_number ?? '-';
        $reservationModel->table_id = $reservation->table_id;
        $reservationModel->guest_number = $reservation->guest_number;
        $reservationModel->res_date = $reservation->res_date;

        $reservationModel->status = 'pending';
        $reservationModel->save();

        Log::info('Reservasi berhasil disimpan', ['reservation_id' => $reservationModel->id]);

        $order = null;
        $paymentTransaction = null;
        $checkoutUrl = null;
        $paymentInstructions = null;
        $menuNames = [];

        $overPeopleFee = 0;
        $overPeopleCount = 0;
        $overPeopleFeePerPerson = 10000;
        if ($reservation->guest_number > 10) {
            $overPeopleCount = $reservation->guest_number - 10;
            $overPeopleFee = $overPeopleCount * $overPeopleFeePerPerson;
        }

        $menuItemsPayload = [];
        $menuItemsArr = [];

        if (!empty($reservation->menu_items)) {
            $menuItemsArr = json_decode($reservation->menu_items, true);
            $menuIds = array_column($menuItemsArr, 'menu_id');
            $menus = \App\Models\Menu::whereIn('id', $menuIds)->get();

            foreach ($menuItemsArr as $item) {
                $menu = $menus->where('id', $item['menu_id'])->first();
                if ($menu) {
                    $menuItemsPayload[] = [
                        'menu_id' => $menu->id,
                        'sku' => $menu->sku,
                        'name' => $menu->name,
                        'price' => $menu->price,
                        'quantity' => $item['quantity'],
                    ];
                }
            }

            if ($overPeopleFee > 0) {
                $menuItemsPayload[] = [
                    'sku' => 'OVERPEOPLE',
                    'name' => 'Biaya Tambahan Orang (' . $overPeopleCount . ' x Rp' . number_format($overPeopleFeePerPerson, 0, ',', '.') . ')',
                    'price' => $overPeopleFeePerPerson,
                    'quantity' => $overPeopleCount,
                ];
            }

            // Hitung total harga dari item
            $baseAmount = $this->calculateAmountFromItems($menuItemsPayload);
            $taxAmount = $this->calculateTax($baseAmount);
            $amount = round($baseAmount + $taxAmount);

            // dd($amount);

            Log::info('Perhitungan total berdasarkan item', [
                'baseAmount' => $baseAmount,
                'taxAmount' => $taxAmount,
                'finalAmount' => $amount,
            ]);

            $order = new Order();
            $order->reservation_id = $reservationModel->id;
            $order->menu_items = $reservation->menu_items;
            $order->total_price = $baseAmount;
            $order->amount = $amount;
            $order->customer_name = $reservation->first_name . ' ' . $reservation->last_name;
            $order->phone = $reservation->tel_number;
            $order->email = $reservation->email;
            $order->table_id = $reservation->table_id;
            $order->note = null;
            $order->tax = $taxAmount;
            $order->payment_status = 'pending';
            $order->qris_screenshot = null;
            $order->save();

            Log::info('Order berhasil dibuat', ['order_id' => $order->id]);

            $tripayService = new TripayService();

            $payload = [
                'name' => $order->customer_name,
                'email' => $order->email,
                'phone' => $order->phone,
                'table_id' => $order->table_id,
                'payment_channel' => $request->input('payment_channel', 'BRIVA'),
                'fee_flat' => 0,
                'fee_percent' => 0,
                'note' => $order->note,
                'amount' => (int) $amount,
                'from_reservation' => true,
            ];

            // dd($payload);

            Log::info('Payload Tripay yang dikirim', $payload);

            $result = $tripayService->handleOrder(
                $payload,
                collect($menuItemsPayload)->keyBy('sku')->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'sku' => $item['sku'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ];
                })->toArray(),
                $order
            );

            Log::info('Response Tripay', ['result' => $result]);

            if (isset($result['transaction']['data']['checkout_url'])) {
                $checkoutUrl = $result['transaction']['data']['checkout_url'];
            }

            if (isset($order->id)) {
                $paymentTransaction = \App\Models\PaymentTransaction::where('order_id', $order->id)->orderByDesc('created_at')->first();
            }

            if (isset($result['transaction']['data']['instructions'])) {
                $paymentInstructions = $result['transaction']['data']['instructions'];
            } elseif ($paymentTransaction && isset($paymentTransaction->payment_response['data']['instructions'])) {
                $paymentInstructions = $paymentTransaction->payment_response['data']['instructions'];
            }

            $menuNames = $menus->pluck('name')->toArray();
        }

        if (empty($menuNames) && !empty($reservation->menu_items)) {
            $menuItemsArr = json_decode($reservation->menu_items, true);
            $menuIds = array_column($menuItemsArr, 'menu_id');
            $menuNames = \App\Models\Menu::whereIn('id', $menuIds)->pluck('name')->toArray();
        }

        Log::info('Final paymentTransaction status', ['paymentTransaction' => $paymentTransaction]);

        $request->session()->forget('reservation');

        return redirect()->route('thankyou', ['order' => $order->id]);
    }


    private function calculateAmountFromItems(array $items): int
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return round($total);
    }

    public function thankyou($orderId)
    {
        $order = \App\Models\Order::with('orderItems')->findOrFail($orderId);
        $reservation = $order->reservation ?? null;
        $payment = PaymentTransaction::where('order_id', $order->id)->latest()->first();
        $menu_names = method_exists($order, 'menus') ? $order->menus->pluck('name')->toArray() : [];
        if (!$reservation && method_exists($order, 'reservation')) {
            $reservation = $order->reservation;
        }
        $reservationArr = $reservation ? [
            'first_name' => $reservation->first_name ?? '',
            'last_name' => $reservation->last_name ?? '',
            'email' => $reservation->email ?? '',
            'tel_number' => $reservation->tel_number ?? '',
            'res_date' => $reservation->res_date ?? '',
            'guest_number' => $reservation->guest_number ?? '',
            'table_name' => optional($reservation->table)->name ?? optional($order->table)->name ?? '-',
            'menu_names' => $menu_names,
        ] : null;
        $payment_instructions = null;
        $checkout_url = null;
        if ($payment) {
            $trx = $payment->payment_response;
            if (is_string($trx)) {
                $trx = json_decode($trx, true);
            }
            if (is_array($trx)) {
                if (isset($trx['data']['instructions'])) {
                    $payment_instructions = $trx['data']['instructions'];
                }
                if (isset($trx['data']['checkout_url'])) {
                    $checkout_url = $trx['data']['checkout_url'];
                }
            }
        }
        Log::info($payment);
        return view('thankyou', [
            'reservation' => $reservationArr,
            'order' => $order,
            'payment' => $payment,
            'payment_instructions' => $payment_instructions,
            'checkout_url' => $checkout_url,
        ]);
    }

    protected function calculateTotalPrice($menuItems)
    {
        $menus = Menu::whereIn('id', $menuItems)->get();
        return $menus->sum('price');
    }

    protected function calculateTax($amount)
    {
        return round($amount * 0.1, 2);
    }

    protected function calculateTotalPriceWithTax($menuItems)
    {
        $total = $this->calculateTotalPrice($menuItems);
        $tax = $this->calculateTax($total);
        return $total + $tax;
    }
}
