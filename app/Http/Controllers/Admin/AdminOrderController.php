<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with('menus')->paginate(25);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::all(); // Ambil semua menu
        return view('admin.orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        // Ambil cust_uid dari cookie
        if (!$request->hasCookie('cust_uid')) {
            $cust_uid = (string) Str::uuid(); // Atau cara lain untuk menghasilkan UID unik
            // Atur cookie dengan masa berlaku yang lebih panjang, misalnya 1 tahun (60 * 24 * 365 menit)
            Cookie::queue('cust_uid', $cust_uid, 60 * 24 * 365);
        } else {
            $cust_uid = $request->cookie('cust_uid');
        }

        // dd($request);

        $validated = $request->validate([
            'customer_name'   => 'required|string|max:255',
            'email'           => 'required|email',
            'phone'           => 'required|string',
            'menu_select'     => 'required|integer|exists:menus,id', // Changed from menu_id
            'amount'          => 'required|integer|min:1',
            'total_price'     => 'required|numeric',
            'payment_status'  => 'required|in:pending,completed,failed',
            'qris_screenshot' => 'nullable|image|max:2048',
        ]);

        $validated['cust_uid'] = $cust_uid;

        // Get menu details
        $menu = \App\Models\Menu::findOrFail($validated['menu_select']);

        $calculatedTotal = $menu->price * $validated['amount'];
        $validated['total_price'] = $calculatedTotal;
        $validated['menu_id'] = $validated['menu_select'];
        $validated['quantity'] = $validated['amount'];
        $validated['table_id'] = 0; // di 0 kan dari admin soalnya

        // Simpan detail items di kolom `menu_items` (text/json)
        $validated['menu_items'] = json_encode([
            'menu_id'  => $menu->id,
            'name'     => $menu->name,
            'price'    => $menu->price,
            'quantity' => $validated['amount'],
        ]);

        // dd($validated);

        // Upload screenshot
        if ($request->hasFile('qris_screenshot')) {
            $file = $request->file('qris_screenshot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/qris_screenshots', $filename);
            $validated['qris_screenshot'] = $filename;
        }

        // Remove fields that don't exist in database
        unset($validated['menu_select']);
        unset($validated['amount']);

        // Simpan ke DB
        Order::create($validated);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order created successfully!');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'table_id' => 'required|exists:tables,id',
            'total_price' => 'required|numeric',
            'payment_status' => 'required|in:pending,completed,failed', // Validasi payment_status
            'qris_screenshot' => 'nullable|image|max:2048', // Maksimal 2MB, opsional
        ]);

        $data = $request->all();

        // Upload screenshot baru jika ada
        if ($request->hasFile('qris_screenshot')) {
            $file = $request->file('qris_screenshot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/qris_screenshots', $filename);
            $data['qris_screenshot'] = $filename;
        }

        // Update order di database
        $order->update($data);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    // Menampilkan form untuk mengedit pesanan
    public function edit(Order $order)
    {
        $menus = Menu::all();
        return view('admin.orders.index', compact('order', 'menus'));
    }

    // Menghapus pesanan
    public function destroy(Order $order)
    {
        $order->delete();  // Hapus pesanan dari database

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
