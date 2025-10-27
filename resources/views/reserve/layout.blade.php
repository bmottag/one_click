<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Réserver | LogistiquePro</title>
    <link rel="icon" type="image/x-icon" href="./images/logo.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" />

    <!-- Keen CSS -->
    <link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* --- Animación fade-in (igual que en React) --- */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(1rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        /* --- Animación float (para iconos decorativos) --- */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-6px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Modal visibility fixes */
        .modal {
            z-index: 2000 !important;
        }
        .modal-backdrop {
            z-index: 1900 !important;
        }
        #checkout {
            position: relative;
            z-index: 2100 !important;
        }
    </style>

</head>

<body class="bg-[#f5f6f7] text-gray-900 flex flex-col min-h-screen">

    <!-- ===================================== -->
    <!-- HEADER -->
    <!-- ===================================== -->
    <header class="sticky top-0 w-full bg-[#002319] z-40 shadow-lg py-4 md:py-6 lg:py-8">
        <div class="flex items-center justify-between md:justify-start px-6 sm:px-10 md:px-14 lg:px-20 xl:px-28 py-8 md:py-10 w-full relative max-w-[1600px] mx-auto">
            
            <!-- LOGO -->
            <a href="{{ url('https://logistiquepro.ca/') }}" class="flex items-center justify-center w-full md:w-auto">
                <img
                    class="w-[220px] sm:w-[240px] md:w-[260px] lg:w-[280px] h-auto"
                    alt="LogistiquePro Logo"
                    src="{{ asset('images/logo.png') }}"
                />
            </a>

            <!-- BOTÓN MENÚ MÓVIL -->
            <button
                onclick="toggleMobileMenu()"
                class="md:hidden flex flex-col gap-1 p-2 absolute right-6 top-1/2 -translate-y-1/2"
                aria-label="Menu mobile"
            >
                <span class="w-7 h-0.5 bg-white"></span>
                <span class="w-7 h-0.5 bg-white"></span>
                <span class="w-7 h-0.5 bg-white"></span>
            </button>

            <!-- NAV DESKTOP -->
            <nav class="hidden md:flex items-center gap-12 lg:gap-20 xl:gap-24 ml-20 lg:ml-28">
                <a href="https://logistiquepro.ca/#hero" class="text-white text-lg lg:text-xl hover:text-[#00da5b] transition-colors font-medium">
                    Accueil
                </a>
                <a href="https://logistiquepro.ca/#services" class="text-white text-lg lg:text-xl hover:text-[#00da5b] transition-colors font-medium">
                    Services
                </a>
                <a href="https://logistiquepro.ca/#about" class="text-white text-lg lg:text-xl hover:text-[#00da5b] transition-colors font-medium">
                    À propos
                </a>
                <a href="https://logistiquepro.ca/#conseils" class="text-white text-lg lg:text-xl hover:text-[#00da5b] transition-colors font-medium">
                    Conseils
                </a>
            </nav>

        </div>

        <!-- OVERLAY -->
        <div id="menuOverlay"
            class="hidden fixed inset-0 bg-black/50 z-30 transition-opacity duration-300"
            onclick="toggleMobileMenu()">
        </div>

        <!-- MENÚ MÓVIL -->
        <div id="mobileMenu"
            class="md:hidden fixed top-0 right-0 w-3/4 max-w-[280px] h-full bg-[#002319] z-40 transform translate-x-full transition-transform duration-300 ease-in-out border-l border-white/10 shadow-xl">
            <nav class="flex flex-col px-6 py-10 gap-4">
                <a href="https://logistiquepro.ca/#hero" class="text-white text-lg py-2 hover:text-[#00da5b]" onclick="toggleMobileMenu()">Accueil</a>
                <a href="https://logistiquepro.ca/#services" class="text-white text-lg py-2 hover:text-[#00da5b]" onclick="toggleMobileMenu()">Services</a>
                <a href="https://logistiquepro.ca/#about" class="text-white text-lg py-2 hover:text-[#00da5b]" onclick="toggleMobileMenu()">À propos</a>
                <a href="https://logistiquepro.ca/#conseils" class="text-white text-lg py-2 hover:text-[#00da5b]" onclick="toggleMobileMenu()">Conseils</a>
            </nav>

        </div>
    </header>

    <!-- ===================================== -->
    <!-- FORMULAIRE DE RÉSERVATION -->
    <!-- ===================================== -->
    <main class="flex-grow py-16 px-4 md:px-8 lg:px-16 animate-fade-in">
        <div class="max-w-[900px] mx-auto bg-gray-50 dark:bg-gray-200 rounded-2xl shadow-lg border border-gray-300 p-8 md:p-12 transition-all duration-300 hover:shadow-xl">
            @if(!session('success'))
                <h1 class="text-3xl md:text-4xl font-semibold text-[#002319] mb-8 text-center">
                    Réserver votre déménagement
                </h1>
                <p class="text-gray-600 text-lg md:text-xl text-center mb-1">
                    Remplissez les informations ci-dessous et notre équipe vous contactera pour confirmer les détails.
                    <br>
                    Pour finaliser votre réservation, <b>un acompte de 200 $ est requis</b>.
                </p>

                <!-- Formulaire -->
                @include('reserve.reserve-form')
            @endif

            @if(session('success'))
                <div class="text-center space-y-10 py-12 animate-fade-in">

                    <!-- ✅ Ícono de confirmación -->
                    <div class="flex justify-center">
                        <div class="bg-[#00da5b]/10 p-6 rounded-full animate-float">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-[#00da5b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- 🎉 Título y mensaje -->
                    <h1 class="text-4xl font-semibold text-[#002319]">Paiement confirmé!</h1>
                    <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                        Merci pour votre confiance. Votre réservation a été enregistrée avec succès.  
                        Vous recevrez un courriel de confirmation dans quelques instants.
                    </p>

                    <!-- 🔁 Bouton nouvelle réservation -->
                    <div>
                        <a href="{{ route('reserve') }}"
                            class="inline-block bg-[#00da5b] hover:bg-[#00c14d] text-white font-semibold py-3 px-8 rounded-xl text-lg transition-all duration-300 shadow-md hover:shadow-lg">
                            Faire une nouvelle réservation
                        </a>
                    </div>

                    <!-- 💬 Résumé de la réservation -->
                    @if(session('reservation'))
                        @php $reservation = session('reservation'); @endphp

                        <div class="max-w-3xl mx-auto mt-12 text-left bg-white rounded-2xl shadow-lg border border-gray-200 p-8 space-y-5">
                            <h2 class="text-2xl font-semibold text-[#002319] mb-4 border-b pb-3">Résumé de votre réservation</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-8 text-gray-800">
                                <p><strong>Date:</strong>
                                    {{ $reservation->reserve_date ? \Carbon\Carbon::parse($reservation->reserve_date)->format('d/m/Y H:i') : 'Non spécifiée' }}
                                </p>
                                <p><strong>Service:</strong>
                                    @switch($reservation->service)
                                        @case('residential') Déménagement résidentiel @break
                                        @case('residential_pack') Déménagement résidentiel avec emballage @break
                                        @case('commercial') Déménagement commercial @break
                                        @case('longue_distance') Transport longue distance @break
                                        @case('installations') Installations spéciales @break
                                        @default Service inconnu
                                    @endswitch
                                </p>

                                <p class="md:col-span-2">
                                    <strong>Adresse de départ:</strong>
                                    {{ $reservation->no_rue_depart }},
                                    {{ $reservation->ville_depart }},
                                    {{ $reservation->code_postal_depart }}
                                </p>

                                @if($reservation->no_rue_destination || $reservation->ville_destination)
                                    <p class="md:col-span-2">
                                        <strong>Adresse de destination:</strong>
                                        {{ $reservation->no_rue_destination ?? '' }},
                                        {{ $reservation->ville_destination ?? '' }},
                                        {{ $reservation->code_postal_destination ?? '' }}
                                    </p>
                                @endif

                                @if($reservation->equipe)
                                    <p class="md:col-span-2">
                                        <strong>Équipe assignée:</strong>
                                        @switch($reservation->equipe)
                                            @case('equipe_1') Service conducteur seulement @break
                                            @case('equipe_2') Équipe de 2 personnes @break
                                            @case('equipe_3') Équipe de 3 personnes @break
                                            @case('equipe_4') 2 Équipes de 3 personnes @break
                                            @default Non assignée
                                        @endswitch
                                    </p>
                                @endif

                                @if($reservation->event_description)
                                    <p class="md:col-span-2">
                                        <strong>Détails supplémentaires:</strong> {{ $reservation->event_description }}
                                    </p>
                                @endif

                                <p class="text-lg font-medium text-[#00da5b] md:col-span-2">
                                    <strong>Montant payé :</strong>
                                    {{ number_format($reservation->amount_paid, 2, ',', ' ') }} {{ strtoupper($reservation->currency) }}
                                </p>
                            </div>

                            <div class="mt-6 text-gray-600 text-sm">
                                Un courriel de confirmation a été envoyé à <strong>{{ $reservation->email }}</strong>.  
                                Si vous avez des questions, n’hésitez pas à nous contacter.
                            </div>
                        </div>
                    @endif
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger text-center mb-10">
                    <strong>Erreur:</strong> {{ session('error') }}
                </div>
            @endif
        </div>
    </main>

    <!-- ===================================== -->
    <!-- FOOTER PROFESSIONNEL -->
    <!-- ===================================== -->
    <footer class="bg-[#04161c] text-white py-16 px-6 md:px-12 lg:px-24 mt-12 animate-fade-in">
        <div class="max-w-[1200px] mx-auto flex flex-col lg:flex-row justify-between gap-12 lg:gap-20">

            <!-- Logo + Texto -->
            <div class="flex-1 max-w-md">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/lp_logo.svg') }}" alt="LogistiquePro" class="w-[43px] h-[26px]">
                    <h2 class="text-2xl md:text-3xl font-semibold text-white tracking-tight">LogistiquePro</h2>
                </div>

                <p class="text-white text-base md:text-lg leading-relaxed mb-8">
                    Des déménagements faits avec cœur, âme et précision.
                    Votre partenaire de confiance pour un service fiable et humain.
                </p>

                <!-- Contact -->
                <div class="space-y-3 text-white text-base md:text-lg">
                    <p class="flex items-center gap-3">
                        <img src="{{ asset('images/phone.svg') }}" class="w-[20px] h-[20px]" alt="Téléphone">
                        (438) 833-2492
                    </p>
                    <p class="flex items-center gap-3">
                        <img src="{{ asset('images/envelope.svg') }}" class="w-[22px] h-[17px]" alt="Courriel">
                        info@logistiquepro.ca
                    </p>
                </div>
            </div>

            <!-- Liens -->
            <div class="grid grid-cols-2 gap-10 md:gap-20 flex-1">
                <!--
                <div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#00da5b]">Services</h3>
                    <ul class="space-y-3 text-[#829e8e] text-base md:text-lg">
                        <li><a href="#" class="hover:text-white transition-colors">Déménagement résidentiel</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Commercial</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Emballage & déballage</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Transport longue distance</a></li>
                    </ul>
                </div>
                -->
                <div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#00da5b]">Entreprise</h3>
                    <ul class="space-y-3 text-[#829e8e] text-base md:text-lg">
                        <li><a href="https://logistiquepro.ca/#hero" class="hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="https://logistiquepro.ca/#services" class="hover:text-white transition-colors">Services</a></li>
                        <li><a href="https://logistiquepro.ca/#about" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="https://logistiquepro.ca/#conseils" class="hover:text-white transition-colors">Conseils</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#00da5b]">More</h3>
                    <ul class="space-y-3 text-[#829e8e] text-base md:text-lg">
                        <li><a href="https://logistiquepro.ca/#contact" class="hover:text-white transition-colors">Nous joindre</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-white/10 mt-16 pt-6">
            <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
                
                <!-- Copyright -->
                <div class="text-white text-sm md:text-base order-2 md:order-1 text-center md:text-left">
                    © {{ date('Y') }} LogistiquePro. Tous droits réservés.
                </div>

                <!-- Réseaux sociaux -->
                <div class="flex justify-center md:justify-end gap-8 order-1 md:order-2">
                    <a href="https://www.facebook.com/logistiquepro.ca" target="_blank" rel="noopener noreferrer" class="hover:opacity-90 transition">
                        <img src="{{ asset('images/facebook.svg') }}" alt="Facebook" class="w-[22px] h-[22px]">
                    </a>
                    <a href="https://www.instagram.com/logistiquepro.ca" target="_blank" rel="noopener noreferrer" class="hover:opacity-90 transition">
                        <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" class="w-[24px] h-[24px]">
                    </a>
                    <a href="https://www.tiktok.com/@logistiquepro.ca" target="_blank" rel="noopener noreferrer" class="hover:opacity-90 transition">
                        <img src="{{ asset('images/tiktok.svg') }}" alt="TikTok" class="w-[23px] h-[23px]">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!--begin::Modals-->
    <!--begin::Modal - New Card-->
    <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h1 class="text-3xl md:text-4xl font-semibold">Continue to Payment</h1>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <div id="checkout"></div>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Card-->
    <!--end::Modals-->

    <!-- JS de Keen -->
    <script>var hostUrl = "{{ asset('template/assets') }}/";</script>
    <script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('js/validations/reserve/general.js') }}"></script>

    <script src="https://js.stripe.com/basil/stripe.js"></script>

    <script>
        // -----------------------------
        // Stripe Checkout en el modal
        // -----------------------------
        let checkout = null;
        const stripe = Stripe("{{ config('services.stripereserve.key') }}");
        const modalEl = document.getElementById('kt_modal_new_card');

        modalEl.addEventListener('shown.bs.modal', async () => {
            const reservationId = document.getElementById('checkout').dataset.reservationId;
            if (!reservationId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Reservation ID manquant.'
                });
                return;
            }

            const fetchClientSecret = async () => {
                const response = await fetch("/reserve/create-checkout-session", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        reservation_id: reservationId
                    })
                });

                const { clientSecret } = await response.json();
                return clientSecret;
            };

            try {
                document.getElementById('checkout').innerHTML = '';
                checkout = await stripe.initEmbeddedCheckout({ fetchClientSecret });
                checkout.mount('#checkout');
            } catch(err) {
                console.error("Stripe Checkout error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur Stripe',
                    text: 'Impossible de charger la page de paiement. ' + err.message,
                });
            }
        });

        // al cerrar el modal → recarga la página
        modalEl.addEventListener('hidden.bs.modal', function () {
            location.reload();
        });

    </script>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('menuOverlay');
            const isOpen = !menu.classList.contains('translate-x-full');

            if (isOpen) {
                // Cerrar menú
                menu.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                // Abrir menú
                menu.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }
    </script>

</body>
</html>
