<?php

namespace App\Services;

use App\Http\Controllers\Rekomendasigenerator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentTransaction;
use App\Services\TripayService;
use App\http\Controllers\Frontend\MenuController;
use App\Models\Menu;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripayPaymentService
{
  /**
   * Handle Tripay payment for an order. If $order is provided, use it. Otherwise, create a new order.
   * @param array $validated
   * @param array $cart
   * @param Order|null $order
   * @return array
   */

   //code lama
// TripayPaymentService.php
public function handleOrder(array $validated, array $cart, $cust_uid, Order $order = null)
    {
        $tripay     = new TripayService();
        $subtotal   = 0;
        $orderItems = [];

        // 1) Bangun baris order_items dari cart
        foreach ($cart as $menuId => $item) {
            $menu = Menu::find($menuId);
            if (! $menu) {
                Log::error("Menu ID $menuId tidak ditemukan");
                continue;
            }

            $orderItems[] = [
                'menu_id'=> $menu->id,
                'sku'      => $menu->sku,
                'name'     => $menu->name,
                'price'    => $menu->price,
                'quantity' => $item['quantity'],
                // 'menu_id'=> $menu->id, // opsional jika model OrderItem punya kolom menu_id
            ];

            $subtotal += $menu->price * $item['quantity'];
        }

        // 2) Hitung pajak & total
        $tax    = round($subtotal * 0.10, 0);   // Tripay hanya menerima integer
        $amount = $subtotal + $tax;

        // 3) Tambahkan baris pajak ke order_items
        $orderItems[] = [
            'sku'      => 'TAX10',
            'name'     => 'Pajak 10%',
            'price'    => $tax,
            'quantity' => 1,
        ];

        // 4) Validasi: ∑(item.price * qty) === amount
        $sumItems = array_reduce($orderItems, function($carry, $i) {
            return $carry + ($i['price'] * $i['quantity']);
        }, 0);

        if ($sumItems !== $amount) {
            Log::error("Mismatch: items sum {$sumItems} != amount {$amount}");
            throw new \Exception("Amount mismatch: items sum ({$sumItems}) != amount ({$amount})");
        }

        // 5) Simpan ke DB + kirim ke Tripay
        DB::beginTransaction();
        try {
            // a) create/update Order
            if (! $order) {
                $order = Order::create([
                    'cust_uid'  => $cust_uid,
                    'customer_name'  => $validated['name'],
                    'phone'          => $validated['phone'],
                    'email'          => $validated['email'],
                    'table_id'       => $validated['table_id'],
                    'amount'         => $amount,
                    'tax'            => $tax,
                    'note'           => $validated['note'] ?? null,
                    'payment_status' => 'pending',
                ]);
            }

            // b) insert OrderItem
            $order->orderItems()->delete(); // jika update
            foreach ($orderItems as $i) {
                $order->orderItems()->create($i);
            }
            $buatrekomendasi = new Rekomendasigenerator();
            $buatrekomendasi->index($cust_uid);
            // c) prepare payload Tripay
            $merchantRef = 'order-' . $order->id;
            $signature   = $tripay->makeSignature($merchantRef, $amount);

            $payload = [
                'method'         => $validated['payment_channel'],
                'merchant_ref'   => $merchantRef,
                'amount'         => $amount,
                'customer_name'  => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],
                'order_items'    => $orderItems,
                'expired_time'   => now()->addMinutes(30)->timestamp,
                'signature'      => $signature,
                'callback_url'   => url('/callback/tripay'),
            ];

            // d) call Tripay
            $transaction = $tripay->createTransaction($payload);
            if (! isset($transaction['data'])) {
                throw new \Exception('Gagal membuat transaksi pembayaran.');
            }

            // e) simpan PaymentTransaction
            PaymentTransaction::create([
                'order_id'         => $order->id,
                'merchant_ref'     => $transaction['data']['merchant_ref'],
                'payment_channel'  => $validated['payment_channel'],
                'customer_name'    => $validated['name'],
                'customer_email'   => $validated['email'],
                'customer_phone'   => $validated['phone'],
                'order_items'      => json_encode($orderItems),
                'signature'        => $signature,
                'amount'           => $transaction['data']['amount'],
                'amount_received'  => $transaction['data']['amount_received'] ?? 0,
                'fee_merchant'     => $transaction['data']['fee_merchant'] ?? 0,
                'fee_customer'     => $transaction['data']['fee_customer'] ?? 0,
                'total_fee'        => ($transaction['data']['fee_merchant'] ?? 0) + ($transaction['data']['fee_customer'] ?? 0),
                'payment_response' => json_encode($transaction),
                'expired_time'     => $transaction['data']['expired_time'],
                'checkout_url'     => $transaction['data']['checkout_url'],
                'qris_url'         => $transaction['data']['qris_url'] ?? null,
                'status'           => $transaction['data']['status'],
            ]);

            // f) generate & simpan QR code (jika perlu)
            $qrCode    = new QrCode($transaction['data']['checkout_url']);
            $writer    = new \Endroid\QrCode\Writer\PngWriter();
            $result    = $writer->write($qrCode);
            $path      = public_path("qrcodes/{$order->id}.png");
            $result->saveToFile($path);

            $order->update([
                'qris_screenshot' => "qrcodes/{$order->id}.png",
            ]);

            DB::commit();

            return [
                'order'       => $order,
                'transaction' => $transaction,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Place order failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }


  public function handleCallback($data)
  {
    $merchantRef = $data->merchant_ref;
    $status = strtoupper((string) $data->status);
    $payment = PaymentTransaction::where('merchant_ref', $merchantRef)->first();
    if (!$payment) {
      Log::error('Tripay Callback: Payment transaction not found', ['merchant_ref' => $merchantRef]);
      return false;
    }
    $order = Order::find($payment->order_id);
    if (!$order) {
      Log::error('Tripay Callback: Order not found', ['order_id' => $payment->order_id]);
      return false;
    }
    switch ($status) {
      case 'PAID':
        $payment->update(['status' => 'PAID']);
        $order->update(['payment_status' => 'completed']);
        break;
      case 'EXPIRED':
        $payment->update(['status' => 'EXPIRED']);
        $order->update(['payment_status' => 'pending']);
        break;
      case 'FAILED':
        $payment->update(['status' => 'FAILED']);
        $order->update(['payment_status' => 'failed']);
        break;
      default:
        Log::warning('Tripay Callback: Unrecognized payment status', ['status' => $status]);
        return false;
    }
    Log::info('Tripay Callback: Callback sukses', ['order_id' => $order->id, 'status' => $status]);
    return true;
  }
}
