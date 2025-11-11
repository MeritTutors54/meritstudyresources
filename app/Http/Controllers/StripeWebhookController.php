<?php

namespace App\Http\Controllers;

use App\Enums\EmailType;
use App\Events\SubscribeEvent;
use App\Jobs\SendSubscriptionEmailJob;
use App\Support\StripeEmailObjectSupport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Stripe\Invoice;
use Stripe\Stripe;

class StripeWebhookController extends CashierController
{

    public function handleInvoicePaymentSucceeded($payload): Response
    {
        Log::info('Invoice payment succeeded', $payload);

        // Get invoice details from Stripe
        $invoiceId = $payload['data']['object']['id'];
        $customerId = $payload['data']['object']['customer'];

        // Handle recurring payment succeeded (second month payment)
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (!$user) {
            Log::warning("No user found for Stripe customer: {$customerId}");

            return response('User not found', 404);
        }

        Stripe::setApiKey(config('cashier.secret'));
        $invoice = Invoice::retrieve($invoiceId);

        $invoicePdf = $invoice->invoice_pdf;

        SendSubscriptionEmailJob::dispatch($user, $invoicePdf, EmailType::RENEW_SUBSCRIBER->value);

        $mailData = (new StripeEmailObjectSupport())->organize($user);

        SubscribeEvent::dispatch($user->email ?? '', EmailType::RENEW_SUBSCRIBER->value, $mailData);

        Log::info("Renewal invoice sent to {$user->email}");

        return response('Webhook Handled', 200);
    }

    public function handleCustomerSubscriptionCreated($payload): Response
    {
        Log::info('Customer subscription created', $payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        $invoiceId = $payload['data']['object']['latest_invoice'] ?? null;

        if ($invoiceId) {
            Stripe::setApiKey(config('cashier.secret'));

            $invoice = Invoice::retrieve($invoiceId);

            // Invoice PDF link
            $invoicePdf = $invoice->invoice_pdf;

            // Send invoice email
            SendSubscriptionEmailJob::dispatch($user, $invoicePdf, EmailType::NEW_SUBSCRIPTION->value);
        }

        $mailData = (new StripeEmailObjectSupport())->organize($user);
        SubscribeEvent::dispatch($user->email ?? '', EmailType::NEW_SUBSCRIPTION->value, $mailData);

        // Handle new subscription
        return response('Webhook Handled', 200);
    }

    public function handleCustomerSubscriptionDeleted($payload): Response
    {
        Log::info('Customer subscription deleted or canceled', $payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        $mailData = (new StripeEmailObjectSupport())->organize($user);

        SubscribeEvent::dispatch($user->email ?? '', EmailType::CANCEL_SUBSCRIBER->value, $mailData);

        return response('Webhook Handled', 200);
    }
}
