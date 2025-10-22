<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Mail\ReservePaymentConfirmedMail;
use App\Mail\ReserveAdminPaymentNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Customer;


class ReserveController extends Controller
{
    /**
     * Display the reserve view.
     */
    public function create(): View
    {
        return view('reserve.layout');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'contact_number' => ['required', 'string', 'max:20'],
                'reserve_date' => ['nullable', 'date'],
                'service' => ['required', 'string'],
                'no_rue_depart' => ['required', 'string', 'max:255'],
                'ville_depart' => ['required', 'string', 'max:255'],
                'code_postal_depart' => ['required', 'string', 'max:20'],
                'etage_depart' => ['nullable', 'string', 'max:50'],
                'pieces_depart' => ['nullable', 'string', 'max:50'],
                'no_rue_destination' => ['nullable', 'string', 'max:255'],
                'ville_destination' => ['nullable', 'string', 'max:255'],
                'code_postal_destination' => ['nullable', 'string', 'max:20'],
                'etage_destination' => ['nullable', 'string', 'max:50'],
                'installation_type' => ['nullable', 'string'],
                'equipe' => ['nullable', 'string'],
                'event_description' => ['nullable', 'string'],
            ]);

            $reserve = Reserve::create(array_merge($validated, [
                'status' => 'pending',
            ]));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Votre réservation a été enregistrée avec succès!',
                    'reservation_id' => $reserve->id,
                ]);
            }

            return redirect()->back()->with('success', 'Votre réservation a été enregistrée avec succès!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 💥 Si hay errores, devolvemos JSON con los mensajes
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }

            throw $e; // comportamiento normal si no es AJAX
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur interne du serveur: ' . $e->getMessage(),
                ], 500);
            }

            throw $e;
        }
    }

    /**
     * Create a Stripe Checkout session
     */
    public function createSession(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripereserve.secret'));

            $reserve = Reserve::find($request->reservation_id);
            if (!$reserve) {
                return response()->json(['error' => 'Réservation introuvable.'], 404);
            }

            $customer = Customer::create([
                'email' => $reserve->email,
                'name'  => $reserve->name,
                'phone' => $reserve->contact_number,
            ]);

            $priceId = config('services.stripereserve.price');
            $session = Session::create([
                'ui_mode' => 'embedded',
                'customer' => $customer->id,
                'line_items' => [[
                    'price' => $priceId,
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'reservation_id' => $reserve->id,
                ],
                'return_url' => route('reserve.return') . '?session_id={CHECKOUT_SESSION_ID}',
            ]);
            return response()->json(['clientSecret' => $session->client_secret]);
        } catch (\Exception $e) {
            \Log::error('Stripe session error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors de la création de la session Stripe: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle return from Stripe Checkout
     */
    public function return(Request $request)
    {
        Stripe::setApiKey(config('services.stripereserve.secret'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()
                ->route('reserve')
                ->with('error', 'Session ID manquant.');
        }

        try {
            // Recuperar la sesión de pago desde Stripe (expandimos payment_intent y line_items)
            $session = Session::retrieve([
                'id' => $sessionId,
                'expand' => ['payment_intent', 'line_items'],
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('reserve')
                ->with('error', 'Impossible de récupérer la session Stripe: ' . $e->getMessage());
        }

        // Verificar el estado del pago
        if ($session->payment_status === 'paid') {

            // Buscar la reserva asociada (por metadata)
            $reserve = Reserve::where('id', $session->metadata->reservation_id ?? null)->first();

            if ($reserve) {
                // Procesar el objeto o array payment_intent
                $paymentIntent = $session->payment_intent;
                $paymentIntentId = null;
                $amountPaid = 0;
                $currency = 'CAD';

                if (is_array($paymentIntent)) {
                    $paymentIntentId = $paymentIntent['id'] ?? null;
                    $amountPaid = ($paymentIntent['amount_received'] ?? $session->amount_total ?? 0) / 100;
                    $currency = strtoupper($paymentIntent['currency'] ?? $session->currency ?? 'CAD');
                } elseif (is_object($paymentIntent)) {
                    $paymentIntentId = $paymentIntent->id ?? null;
                    $amountPaid = ($paymentIntent->amount_received ?? $session->amount_total ?? 0) / 100;
                    $currency = strtoupper($paymentIntent->currency ?? $session->currency ?? 'CAD');
                }

                // Actualizar la reserva
                $reserve->update([
                    'status' => 'paid',
                    'stripe_session_id' => $session->id,
                    'stripe_payment_intent' => $paymentIntentId,
                    'amount_paid' => $amountPaid,
                    'currency' => $currency,
                ]);

                // 👉 Enviar correo de confirmación
                try {
                    Mail::to($reserve->email)->queue(new ReservePaymentConfirmedMail($reserve));
                    Mail::to(config('mail.admin_address'))->queue(new ReserveAdminPaymentNotificationMail($reserve));
                } catch (\Exception $e) {
                    \Log::error('Error al enviar correos de confirmación de pago: ' . $e->getMessage());
                }
            }

            return redirect()
                ->route('reserve')
                ->with('success', 'Votre paiement a été confirmé avec succès!')
                ->with('reservation', $reserve);
                
        }

        // Si el pago no se completó
        return redirect()
            ->route('reserve')
            ->with('error', 'Le paiement n\'a pas été complété. Veuillez réessayer.');
    }





}
