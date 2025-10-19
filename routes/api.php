<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;

// Stripe Webhook Route
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

