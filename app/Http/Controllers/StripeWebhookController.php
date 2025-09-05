<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use Stripe\Webhook;
use Stripe\Stripe;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $user = User::where('stripe_id', $session->customer)->first();

                if ($user) {
                    Subscription::updateOrCreate(
                        ['stripe_session_id' => $session->id],
                        [
                            'user_id' => $user->id,
                            'stripe_subscription_id' => $session->subscription,
                            'stripe_price_id' => $session->metadata->price_id ?? '',
                            'plan_id' => $session->metadata->price_id ?? '',
                            'interval' => $session->metadata->interval ?? '',
                            'amount' => $session->amount_total ?? 0,
                            'payment_status' => $session->payment_status,
                        ]
                    );

                    // Opcional: marcar al usuario como activo
                   // $user->update(['is_subscribed' => true]);
                }
                break;

            case 'invoice.payment_failed':
                $invoice = $event->data->object;

                $subscription = Subscription::where('stripe_subscription_id', $invoice->subscription)->first();
                if ($subscription) {
                    $subscription->update(['payment_status' => 'failed']);
                    $subscription->user->update(['is_subscribed' => false]);
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }
}

