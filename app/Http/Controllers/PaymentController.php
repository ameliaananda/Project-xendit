<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;

use App\Models\Order;

class PaymentController extends Controller
{

  public function process(Request $request)
{
    $request->validate([
        'payment_method' => 'required|string',
        'product_id' => 'required'
    ]);

    $user = Auth::user();
    $method = $request->payment_method;

    Configuration::setXenditKey(config('services.xendit.secret_key'));

    $external_id = "ORDER-" . time();

    // ambil product dari database
    $product = \App\Models\Product::findOrFail($request->product_id);

    $amount = $product->price;

    try {

        $order = Order::create([
            'external_id' => $external_id,
            'user_id' => $user->id,
            'total_amount' => $amount,
            'status' => 'pending',
            'payment_method' => $method,
        ]);

        $apiInstance = new PaymentRequestApi();

        /*
        |--------------------------------------------------------------------------
        | QRIS
        |--------------------------------------------------------------------------
        */

        if ($method === 'qris') {

            $params = [
                "reference_id" => $external_id,
                "currency" => "IDR",
                "amount" => $amount,
                "payment_method" => [
                    "type" => "QR_CODE"
                ]
            ];

            $payment = $apiInstance->createPaymentRequest($params);

            $order->xendit_invoice_id = $payment['id'];
            $order->save();

            return view('payment.show', [
                'type' => 'qris',
                'qr_string' => $payment['payment_method']['qr_code']['channel_properties']['qr_string'],
                'amount' => $amount,
                'order' => $order,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Virtual Account
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($method, 'va_')) {

            $bank = strtoupper(str_replace('va_', '', $method));

            $params = [
                "reference_id" => $external_id,
                "currency" => "IDR",
                "amount" => $amount,
                "payment_method" => [
                    "type" => "VIRTUAL_ACCOUNT",
                    "reusability" => "ONE_TIME_USE",
                    "virtual_account" => [
                        "channel_code" => $bank,
                        "channel_properties" => [
                            "customer_name" => $user->name
                        ]
                    ]
                ]
            ];

            $payment = $apiInstance->createPaymentRequest($params);

            $order->xendit_invoice_id = $payment['id'];
            $order->save();

            return view('payment.show', [
                'type' => 'va',
                'va_number' => $payment['payment_method']['virtual_account']['channel_properties']['virtual_account_number'],
                'bank' => $bank,
                'amount' => $amount,
                'order' => $order,
            ]);
        }

        return back()->withErrors([
            'payment_method' => 'Metode pembayaran tidak dikenali.'
        ]);

    } catch (\Exception $e) {

        Log::error('Xendit Error', [
            'message' => $e->getMessage()
        ]);

        return back()->withErrors([
            'payment' => 'Gagal memproses pembayaran.'
        ]);
    }
}
}