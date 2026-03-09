<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {

        // validasi token webhook
        $callbackToken = $request->header('x-callback-token');

        if ($callbackToken !== config('services.xendit.callback_token')) {
            return response()->json(['message' => 'Invalid callback token'], 403);
        }

        $payload = $request->all();

        $referenceId = $payload['data']['reference_id'] ?? null;
        $status = $payload['data']['status'] ?? null;

        $order = Order::where('external_id', $referenceId)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
                'reference_id' => $referenceId
            ], 404);
        }

        if ($status === 'SUCCEEDED' || $status === 'PAID') {

            $order->status = 'paid';
            $order->paid_at = now();
            $order->save();

        }

        return response()->json([
            'message' => 'Webhook processed'
        ]);
    }
}