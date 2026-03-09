<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class XenditWebhookController extends Controller
{
    /**
     * Handle incoming webhook dari Xendit.
     *
     * Xendit mengirim notifikasi ke endpoint ini setiap kali
     * ada perubahan status pembayaran (SUCCEEDED, FAILED, dll).
     *
     * [REFACTOR] Disesuaikan dengan format webhook Payment Request API.
     */
    public function handle(Request $request)
    {
        // [FIX] Config key diperbaiki: sebelumnya 'callback_token', sekarang 'webhook_token'
        // sesuai dengan key di config/services.php
        $callbackToken = $request->header('x-callback-token');

        if ($callbackToken !== config('services.xendit.webhook_token')) {
            Log::warning('Xendit Webhook: Invalid callback token', [
                'received_token' => $callbackToken,
            ]);
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        $payload = $request->all();

        // [REFACTOR] Log payload untuk debugging
        Log::info('Xendit Webhook Received', ['payload' => $payload]);

        // [REFACTOR] Ambil reference_id dan status dari payload
        // Format Payment Request webhook: data ada di dalam key 'data'
        $data        = $payload['data'] ?? $payload;
        $referenceId = $data['reference_id'] ?? null;
        $status      = $data['status'] ?? null;

        // [REFACTOR] Cari order berdasarkan external_id (= reference_id di Xendit)
        $order = Order::where('external_id', $referenceId)->first();

        if (!$order) {
            Log::warning('Xendit Webhook: Order not found', [
                'reference_id' => $referenceId,
            ]);
            return response()->json([
                'message'      => 'Order not found',
                'reference_id' => $referenceId,
            ], 404);
        }

        // [REFACTOR] Handle berbagai status dari Xendit
        if (in_array($status, ['SUCCEEDED', 'PAID'])) {
            // Pembayaran berhasil
            $order->status  = 'paid';
            $order->paid_at = now();
            $order->save();

            Log::info('Xendit Webhook: Order paid', ['order_id' => $order->id]);
        } elseif (in_array($status, ['FAILED', 'VOIDED'])) {
            // Pembayaran gagal
            $order->status = 'failed';
            $order->save();

            Log::info('Xendit Webhook: Order failed', ['order_id' => $order->id]);
        } elseif ($status === 'EXPIRED') {
            // Pembayaran expired (VA / QR expired)
            $order->status = 'expired';
            $order->save();

            Log::info('Xendit Webhook: Order expired', ['order_id' => $order->id]);
        }

        return response()->json([
            'message' => 'Webhook processed',
        ]);
    }
}
