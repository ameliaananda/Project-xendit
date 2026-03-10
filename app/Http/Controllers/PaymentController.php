<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// [REFACTOR] Menggunakan PaymentRequestApi dari Xendit SDK v7
use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;

use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Proses pembayaran via Xendit PaymentRequestApi.
     *
     * Menerima order_id dan payment_method dari form checkout,
     * lalu membuat Payment Request ke Xendit (QRIS / Virtual Account).
     * Hasil (QR string / VA number) ditampilkan di halaman payment/show.
     */
    public function process(Request $request)
    {
        // [REFACTOR] Validasi: terima order_id (bukan product_id)
        $request->validate([
            'payment_method' => 'required|string',
            'order_id'       => 'required|exists:orders,id',
        ]);

        $user   = Auth::user();
        $method = $request->payment_method;

        // [FIX] Gunakan config() bukan env() langsung — lebih aman & mendukung cache
        Configuration::setXenditKey(config('services.xendit.secret_key'));

        // [REFACTOR] Ambil order yang sudah dibuat sebelumnya oleh CheckoutController / OrderController
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $amount = (int) $order->total_amount;

        try {
            $apiInstance = new PaymentRequestApi();

            /*
            |--------------------------------------------------------------------------
            | QRIS — Scan menggunakan semua e-wallet / mobile banking
            |--------------------------------------------------------------------------
            */
            if ($method === 'qris') {

                $params = [
                    'reference_id' => $order->external_id,
                    'currency'     => 'IDR',
                    'amount'       => $amount,
                    'payment_method' => [
                        'type'    => 'QR_CODE',
                        'reusability' => 'ONE_TIME_USE',
                        'qr_code' => [
                            'channel_code' => 'QRIS',
                        ],
                    ],
                ];

                // [FIX] Parameter params harus di argument ke-4 (setelah idempotency_key, for_user_id, with_split_rule)
                $payment = $apiInstance->createPaymentRequest(null, null, null, $params);

                // [REFACTOR] Simpan data payment ke order untuk referensi
                $order->xendit_invoice_id  = $payment['id'];
                $order->payment_method     = 'QRIS';
                $order->payment_channel_id = $payment['payment_method']['qr_code']['channel_properties']['qr_string'] ?? null;
                $order->save();

                return view('payment.show', [
                    'type'      => 'qris',
                    'qr_string' => $order->payment_channel_id,
                    'amount'    => $amount,
                    'order'     => $order,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Virtual Account — BCA, BNI, BRI, Mandiri
            |--------------------------------------------------------------------------
            */
            if (str_starts_with($method, 'va_')) {

                // [REFACTOR] Ekstrak kode bank dari payment_method (contoh: va_bca → BCA)
                $bank = strtoupper(str_replace('va_', '', $method));

                $params = [
                    'reference_id' => $order->external_id,
                    'currency'     => 'IDR',
                    'amount'       => $amount,
                    'payment_method' => [
                        'type'        => 'VIRTUAL_ACCOUNT',
                        'reusability' => 'ONE_TIME_USE',
                        'virtual_account' => [
                            'channel_code'       => $bank,
                            'channel_properties'  => [
                                'customer_name' => $user->name,
                            ],
                        ],
                    ],
                ];

                // [FIX] Parameter params harus di argument ke-4
                $payment = $apiInstance->createPaymentRequest(null, null, null, $params);

                // [REFACTOR] Simpan VA number dan bank ke order
                $vaNumber = $payment['payment_method']['virtual_account']['channel_properties']['virtual_account_number'] ?? null;

                $order->xendit_invoice_id  = $payment['id'];
                $order->payment_method     = 'VA_' . $bank;
                $order->payment_channel_id = $vaNumber;
                $order->va_number          = $vaNumber;
                $order->bank               = $bank;
                $order->save();

                return view('payment.show', [
                    'type'      => 'va',
                    'va_number' => $vaNumber,
                    'bank'      => $bank,
                    'amount'    => $amount,
                    'order'     => $order,
                ]);
            }

            return back()->withErrors([
                'payment_method' => 'Metode pembayaran tidak dikenali.',
            ]);
        } catch (\Exception $e) {

            // [REFACTOR] Log error detail untuk debugging
            Log::error('Xendit PaymentRequest Error', [
                'order_id' => $order->id,
                'method'   => $method,
                'message'  => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'payment' => 'Gagal memproses pembayaran: ' . $e->getMessage(),
            ]);
        }
    }
}
