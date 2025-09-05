<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Display pricing page
     */
    public function pricing()
    {
        return view('subscription.pricing');
    }

    /**
     * Create a Stripe Checkout session
     */
    public function createSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = auth()->user();

        // Si el usuario aún no tiene un customer en Stripe
        if (!$user->stripe_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);

            // Guardar el ID en la base de datos
            $user->update([
                'stripe_id' => $customer->id,
            ]);
        }
        $priceId = $request->input('price_id');

        $priceId = $request->input('price_id');
        $period = $request->input('period'); // "month" o "annual"
        $plan = $request->input('plan'); // "pro" o "full"

        $session = Session::create([
            'ui_mode' => 'embedded',
            'customer' => $user->stripe_id,
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'return_url' => route('subscription.return') . '?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                'interval' => $period,
                'plan' => $plan,
            ]
        ]);

        return response()->json([
            'clientSecret' => $session->client_secret,
        ]);
    }


    public function return(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return view('checkout.failed', ['message' => 'No session_id received.']);
        }

        try {
            $session = Session::retrieve($sessionId);
        } catch (\Exception $e) {
            return view('checkout.failed', ['message' => 'No se pudo consultar la sesión: ' . $e->getMessage()]);
        }

        $user = auth()->user();

        // Obtener la suscripción de Stripe para conocer fecha de finalización
        $subscription = StripeSubscription::retrieve($session->subscription);

        // Guardar en la base de datos
        Subscription::updateOrCreate(
            ['stripe_session_id' => $session->id],
            [
                'user_id' => $user->id,
                'stripe_subscription_id' => $session->subscription,
                'stripe_price_id' => $session->line_items->data[0]->price->id ?? '',
                'plan_id' => $session->metadata->plan ?? '',
                'interval' => $session->metadata->interval ?? '',
                'amount' => $session->amount_total ?? 0,
                'payment_status' => $session->payment_status,
                'ends_at' => isset($subscription->current_period_end)
                    ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)
                    : null,
            ]
        );

        if ($session->payment_status === 'paid') {
            $user->update(['is_subscribed' => true]);

            return view('checkout.success', ['session' => $session]);
        } else {
            return view('checkout.failed', ['session' => $session, 'message' => 'El pago aún no se completó.']);
        }

    }


}
