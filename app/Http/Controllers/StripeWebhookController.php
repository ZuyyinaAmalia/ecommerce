<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $event = json_decode($payload, true);

        Log::info('Stripe Webhook Received', $event);

        if (isset($event['type'])) {
            switch ($event['type']) {
                case 'checkout.session.completed':
                    Log::info('✅ Checkout session completed', $event['data']['object']);
                    break;

                case 'payment_intent.succeeded':
                    Log::info('💰 Payment succeeded', $event['data']['object']);
                    break;

                default:
                    Log::info('ℹ️ Unhandled event type: ' . $event['type']);
            }
        }

        return response('Webhook received', 200);
    }
}



