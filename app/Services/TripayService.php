<?php

namespace App\Services;

use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Models\Order;
use Exception;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tripay.api_key');
        $this->privateKey = config('services.tripay.private_key');
        $this->merchantCode = config('services.tripay.merchant_code');
        $this->baseUrl = 'https://tripay.co.id/api-sandbox';
    }

    public function getPaymentChannels()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/merchant/payment-channel');

        return $response->successful() ? $response->json() : null;
    }

    public function createTransaction(array $payload)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($this->baseUrl . '/transaction/create', $payload);

        Log::info('Tripay transaction response', ['response' => $response->json()]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Tripay transaction failed', ['body' => $response->body()]);
        throw new Exception('Gagal membuat transaksi pembayaran: ' . $response->body());
    }

    public function getTransactionDetail($reference)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/transaction/detail', [
            'reference' => $reference
        ]);

        return $response->successful() ? $response->json() : null;
    }

    public function checkTransactionStatus($reference)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/transaction/check', [
            'reference' => $reference
        ]);

        return $response->successful() ? $response->json() : null;
    }

    public function handleOrder(array $basePayload, array $menuItemsPayload, Order $order)
    {
        Log::info('Memulai handleOrder di TripayService', [
            'order_id' => $order->id,
            'basePayload' => $basePayload,
        ]);

        $merchantRef = 'ORDER-' . $order->id . '-' . time();
        Log::info('Generated merchant_ref', ['merchant_ref' => $merchantRef]);

        $amount = array_reduce($menuItemsPayload, function ($carry, $item) {
            return $carry + ((float) $item['price'] * (int) $item['quantity']);
        }, 0);

        $amount = (int) $amount;
        $signature = $this->makeSignature($merchantRef, $amount);
        Log::info('Generated signature', ['signature' => $signature]);

        $tripayPayload = [
            'method'         => $basePayload['payment_channel'],
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $basePayload['name'],
            'customer_email' => $basePayload['email'],
            'customer_phone' => $basePayload['phone'],
            'order_items'    => $menuItemsPayload,
            'callback_url'   => config('app.url') . '/tripay/callback',
            'return_url'     => config('app.url') . '/thankyou/' . $order->id,
            'signature'      => $signature,
        ];

        Log::info('Payload ke Tripay', ['payload' => $tripayPayload]);

        $tripayResponse = $this->createTransaction($tripayPayload);

        if (!isset($tripayResponse['success']) || !$tripayResponse['success']) {
            Log::error('Gagal membuat transaksi Tripay', ['response' => $tripayResponse]);
            throw new Exception('Gagal membuat transaksi Tripay: ' . json_encode($tripayResponse));
        }

        $data = $tripayResponse['data'];

        PaymentTransaction::create([
            'order_id'         => $order->id,
            'merchant_ref'     => $data['merchant_ref'],
            'payment_channel'  => $data['payment_method'],
            'amount'           => $data['amount'],
            'fee_customer'     => $data['fee_customer'],
            'fee_merchant'     => $data['fee_merchant'],
            'total_fee'        => $data['total_fee'],
            'customer_name'  => $basePayload['name'],
            'customer_email' => $basePayload['email'],
            'customer_phone' => $basePayload['phone'],
            'order_items' => json_encode($menuItemsPayload),
            'amount_received'  => $data['amount_received'],
            'checkout_url'     => $data['checkout_url'],
            'status'           => $data['status'],
            'expired_time' => $data['expired_time'],
            'signature' => $this->makeSignature($data['merchant_ref'], $amount),
            'payment_response' => $tripayResponse,
        ]);

        Log::info('Transaksi Tripay disimpan', ['reference' => $data['reference']]);
        return $tripayResponse;
    }

    public function calculateFee($amount, $code)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new \InvalidArgumentException('Amount must be a positive number.');
        }
        if (empty($code)) {
            throw new \InvalidArgumentException('Code cannot be empty.');
        }

        Log::info('Menghitung fee Tripay', ['amount' => $amount, 'code' => $code]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . '/merchant/fee-calculator', [
            'amount' => $amount,
            'code'   => $code,
        ]);

        if (!$response->successful()) {
            Log::error('Gagal hitung fee', ['response' => $response->body()]);
            throw new Exception('Failed to calculate fee: ' . $response->body());
        }

        $data = $response->json()['data'][0]['total_fee']['merchant'] ?? null;

        if (!is_numeric($data)) {
            throw new Exception('Invalid fee total received from Tripay API.');
        }

        Log::info('Fee merchant berhasil dihitung', ['fee' => $data]);
        return $amount + $data;
    }

    public function calculateTotalWithFee($amount, $code)
    {
        return $this->calculateFee($amount, $code);
    }

    public function makeSignature($merchant_ref, $amount)
    {
        return hash_hmac('sha256', $this->merchantCode . $merchant_ref . $amount, $this->privateKey);
    }
}
