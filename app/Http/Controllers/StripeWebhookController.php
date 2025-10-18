<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // ambil dari dashboard Stripe

        try {
            // Verifikasi signature dari Stripe
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe signature verification failed: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Hanya tangani event pembayaran sukses
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Ambil order berdasarkan ID (pastikan kamu simpan order_id di metadata)
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order) {
                    $order->status = 'completed';
                    $order->save();

                    Log::info("✅ Order #{$order->id} marked as completed.");
                }
            }
        }

        return response('Webhook handled', 200);
    }
}


