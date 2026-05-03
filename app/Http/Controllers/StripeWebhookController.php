<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;

            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                $this->handlePaymentSucceeded($invoice);
                break;

            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->handleSubscriptionDeleted($subscription);
                break;
        }

        return response('Webhook handled', 200);
    }

    private function handleCheckoutSessionCompleted($session)
    {
        if ($session->mode !== 'subscription') {
            return;
        }

        $userEmail = $session->customer_email ?? null;
        if (! $userEmail) {
            return;
        }

        $user = User::where('email', $userEmail)->first();
        if ($user) {
            $user->update([
                'stripe_customer_id' => $session->customer,
                'stripe_subscription_id' => $session->subscription,
                'subscription_status' => 'active',
                'plan' => $session->metadata->plan ?? 'professional',
            ]);
        }
    }

    private function handlePaymentSucceeded($invoice)
    {
        $customerId = $invoice->customer;
        $user = User::where('stripe_customer_id', $customerId)->first();
        if ($user) {
            $user->update(['subscription_status' => 'active']);
        }
    }

    private function handleSubscriptionDeleted($subscription)
    {
        $customerId = $subscription->customer;
        $user = User::where('stripe_customer_id', $customerId)->first();
        if ($user) {
            $user->update([
                'subscription_status' => 'canceled',
                'plan' => 'basic',
            ]);
        }
    }
}
