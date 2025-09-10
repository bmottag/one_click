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
            return redirect()
                ->route('profile.billing')
                ->with('error', 'No session_id received.');
        }

        try {
            $session = Session::retrieve([
                'id' => $sessionId,
                'expand' => ['line_items', 'subscription'],
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('profile.billing')
                ->with('error', 'No se pudo consultar la sesión: ' . $e->getMessage());
        }

        $user = auth()->user();
        $subscription = $session->subscription; // ya expandido

        $endsAt = null;

        // 1️⃣ Si Stripe nos da current_period_end, usamos eso
        if (isset($subscription->current_period_end)) {
            $endsAt = \Carbon\Carbon::createFromTimestamp($subscription->current_period_end);

        // 2️⃣ Si está en periodo de prueba
        } elseif (isset($subscription->trial_end)) {
            $endsAt = \Carbon\Carbon::createFromTimestamp($subscription->trial_end);

        // 3️⃣ Si no hay ninguno, calculamos según start_date + interval
        } elseif (isset($subscription->start_date) && isset($session->metadata->interval)) {
            $start = \Carbon\Carbon::createFromTimestamp($subscription->start_date);
            $interval = $session->metadata->interval; // "month" o "annual"

            if ($interval === 'month') {
                $endsAt = $start->copy()->addMonth();
            } elseif ($interval === 'annual') {
                $endsAt = $start->copy()->addYear();
            }
        }


        // Guardar en la base de datos
        Subscription::updateOrCreate(
            ['stripe_subscription_id' => $subscription->id],
            [
                'user_id' => $user->id,
                'stripe_session_id' => $session->id,
                'stripe_price_id' => $session->line_items->data[0]->price->id ?? '',
                'plan_id' => $session->metadata->plan ?? '',
                'interval' => $session->metadata->interval ?? '',
                'amount' => $session->line_items->data[0]->amount_total ?? 0,
                'payment_status' => $session->payment_status,
                'ends_at' => $endsAt,
            ]
        );

        if ($session->payment_status === 'paid') {
            $user->update(['is_subscribed' => true]);

            return redirect()
                ->route('profile.billing')
                ->with('success', '¡Tu suscripción se activó con éxito!');
        } else {
            return redirect()
                ->route('profile.billing')
                ->with('error', 'El pago aún no se completó.');
        }
    }


}
