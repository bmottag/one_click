<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        <!-- Formulario -->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">

                    @if(session('success'))
                        <div class="alert alert-success text-center mb-10">
                            <h3 class="fw-bold mb-2">Paiement confirmé!</h3>
                            <div class="fs-6 text-gray-700 mb-3" style="display:none;">{{ session('success') }}</div>
                            <a href="{{ route('reserve') }}" class="btn btn-primary mt-3">Faire une nouvelle réservation</a>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger text-center mb-10">
                            <strong>Erreur:</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if(!session('success'))
                        <!-- Registro -->
                        <form method="POST" id="kt_sign_up_form" action="{{ route('reserve') }}" class="form w-100">
                            @csrf
                            
                            <!-- Nombre -->
                            <div class="fv-row mb-8">
                                <label for="email" class="required fs-6 fw-semibold mb-2">Prénom et nom</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Prénom et nom"
                                    class="form-control form-control-solid @error('name') is-invalid @enderror" 
                                    required autofocus />
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="row">
                                <div class="col-md-6 fv-row mb-8">
                                    <label for="email" class="required fs-6 fw-semibold mb-2">Courriel</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Courriel"
                                        class="form-control form-control-solid @error('email') is-invalid @enderror" required />
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="col-md-6 fv-row mb-8">
                                    <label for="city" class="required fs-6 fw-semibold mb-2">Téléphone</label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="Téléphone"
                                        class="form-control form-control-solid @error('contact_number') is-invalid @enderror" required />
                                    @error('contact_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-8">
                                <label class="required fs-6 fw-semibold mb-2">Quelle est la date et l'heure de votre réservation?</label>
                                <!--begin::Input-->
                                <div class="position-relative d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                    <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                            <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
                                            <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Datepicker-->
                                    <input class="form-control form-control-solid ps-12" placeholder="Select a date" name="reserve_date" />
                                    <!--end::Datepicker-->
                                </div>
                            </div>

                            <div class="fv-row mb-8">
                                <label for="service" class="required fs-6 fw-semibold mb-2">De quel service avez-vous besoin?</label>
                                <select id="service"
                                        name="service"
                                        class="form-select fw-semibold @error('service') is-invalid @enderror"
                                        data-placeholder="Veuillez choisir une option"
                                        required>
                                    <option value=""></option>
                                    <option value="residential" {{ old('service') == 'residential' ? 'selected' : '' }}>Déménagement résidentiel</option>
                                    <option value="residential_pack" {{ old('service') == 'residential_pack' ? 'selected' : '' }}>Déménagement résidentiel avec emballage et déballage</option>
                                    <option value="commercial" {{ old('service') == 'commercial' ? 'selected' : '' }}>Déménagement commercial</option>
                                    <option value="longue_distance" {{ old('service') == 'longue_distance' ? 'selected' : '' }}>Transport longue distance</option>
                                    <option value="installations" {{ old('service') == 'installations' ? 'selected' : '' }}>Installations spéciales</option>
                                </select>
                                @error('service')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Adresse de départ -->
                            <div id="adresse_depart_group">
                                <div class="fv-row mb-8">
                                    <label id="adresse_depart_label" class="required fs-6 fw-semibold mb-2">Adresse de départ</label>
                                    <input type="text" name="no_rue_depart" value="{{ old('no_rue_depart') }}" placeholder="No civique et rue"
                                        class="form-control form-control-solid @error('no_rue') is-invalid @enderror" required />
                                    @error('no_rue_depart')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="email" name="ville_depart" value="{{ old('ville_depart') }}" placeholder="Ville"
                                            class="form-control form-control-solid @error('email') is-invalid @enderror" required />
                                        @error('ville_depart')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Téléphone -->
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="text" name="code_postal_depart" value="{{ old('code_postal_depart') }}" placeholder="Code postal"
                                            class="form-control form-control-solid @error('code_postal_depart') is-invalid @enderror" required />
                                        @error('code_postal_depart')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="text" name="etage_depart" value="{{ old('etage_depart') }}" placeholder="Étage"
                                            class="form-control form-control-solid @error('email') is-invalid @enderror" required />
                                        @error('etage_depart')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Nombre de pièces -->
                                    <div class="col-md-6 fv-row mb-8">
                                        <select id="pieces_depart"
                                                name="pieces_depart"
                                                class="form-select fw-semibold @error('pieces_depart') is-invalid @enderror"
                                                data-placeholder="Nombre de pièces"
                                                required>
                                            <option value="">Nombre de pièces</option>
                                            <option value="2" {{ old('pieces_depart') == '2' ? 'selected' : '' }}>2 1/2</option>
                                            <option value="3" {{ old('pieces_depart') == '3' ? 'selected' : '' }}>3 1/2</option>
                                            <option value="4" {{ old('pieces_depart') == '4' ? 'selected' : '' }}>4 1/2</option>
                                            <option value="5" {{ old('pieces_depart') == '5' ? 'selected' : '' }}>5 1/2</option>
                                            <option value="6" {{ old('pieces_depart') == '6' ? 'selected' : '' }}>6 1/2</option>
                                            <option value="7" {{ old('pieces_depart') == '7' ? 'selected' : '' }}>7 1/2</option>
                                            <option value="8" {{ old('pieces_depart') == '8' ? 'selected' : '' }}>8 1/2 et plus</option>
                                            <option value="9" {{ old('pieces_depart') == '9' ? 'selected' : '' }}>Maison</option>
                                            <option value="10" {{ old('pieces_depart') == '10' ? 'selected' : '' }}>Maison avec étage</option>
                                            <option value="11" {{ old('pieces_depart') == '11' ? 'selected' : '' }}>Maison avec garage</option>
                                        </select>
                                        @error('pieces_depart')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Adresse de destination -->        
                            <div id="adresse_destination_group">
                                <div class="fv-row mb-8">
                                    <label for="service" class="required fs-6 fw-semibold mb-2">Adresse de destination</label>
                                    <input type="text" name="no_rue_destination" value="{{ old('no_rue_destination') }}" placeholder="No civique et rue"
                                        class="form-control form-control-solid @error('no_rue_destination') is-invalid @enderror" required />
                                    @error('no_rue_destination')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="text" name="ville_destination" value="{{ old('ville_destination') }}" placeholder="Ville"
                                            class="form-control form-control-solid @error('ville_destination') is-invalid @enderror" required />
                                        @error('ville_destination')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Téléphone -->
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="text" name="code_postal_destination" value="{{ old('code_postal_destination') }}" placeholder="Code postal"
                                            class="form-control form-control-solid @error('code_postal_destination') is-invalid @enderror" required />
                                        @error('code_postal_destination')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 fv-row mb-8">
                                        <input type="text" name="etage_destination" value="{{ old('etage_destination') }}" placeholder="Étage"
                                            class="form-control form-control-solid @error('etage_destination') is-invalid @enderror" required />
                                        @error('etage_destination')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <!-- Type d'installation -->
                            <div class="col-md-6 fv-row mb-8" id="installation_type_group" style="display:none;">
                                <label for="installation_type" class="required fs-6 fw-semibold mb-2">Type d'installation</label>
                                <select id="installation_type"
                                        name="installation_type"
                                        class="form-select fw-semibold @error('installation_type') is-invalid @enderror"
                                        data-placeholder="Veuillez choisir une option">
                                    <option value=""></option>
                                    <option value="residentiel">Résidentiel</option>
                                    <option value="commercial">Commercial</option>
                                </select>
                                @error('installation_type')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Équipe -->
                            <div id="div_equipe" class="fv-row mb-8">
                                <label for="equipe" class="required fs-6 fw-semibold mb-2">Équipe</label>
                                <select id="equipe"
                                        name="equipe"
                                        class="form-select fw-semibold @error('equipe') is-invalid @enderror"
                                        data-placeholder="Veuillez choisir une option"
                                        required>
                                    <option value=""></option>
                                    <option value="equipe_1" {{ old('equipe') == 'residential' ? 'selected' : '' }}>Service conducteur seulement</option>
                                    <option value="equipe_2" {{ old('equipe') == 'residential_pack' ? 'selected' : '' }}>Équipe de 2 personnes</option>
                                    <option value="equipe_3" {{ old('equipe') == 'commercial' ? 'selected' : '' }}>Équipe de 3 personnes</option>
                                </select>
                                @error('equipe')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Description -->
                            <div id="description_group" class="fv-row mb-8" style="display:none;">
                                <label for="event_description" class="required fs-6 fw-semibold mb-2">Détails supplémentaires</label>
                                <label id="description_label_sub" for="event_description" class="fs-6 mb-2">
                                    <small>
                                        Dites-nous tout ce qui peut faciliter votre déménagement: articles lourds ou particuliers, accès disponibles, horaires d'entrée et de sortie.
                                        <br>Chaque détail compte, plus vous partagez d'informations, plus nous pourrons préparer un service adapté, simple et sans stress.
                                    </small>
                                </label>
                                <textarea class="form-control form-control-solid" rows="4" name="event_description" placeholder="Détails supplémentaires"></textarea>
                            </div>
                            <!-- Note -->
                            <div id="div_note" class="notice bg-light-danger rounded border-danger border p-6" style="display:none;">
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">À noter!</h4>

                                        <div id="note_residential" class="fs-6 text-gray-700 mb-3" style="display:none;">
                                            Pour les trajets de plus de 20 km, un supplément carburant de 0,70$ / km s'applique.                                         
                                        </div>
                                    
                                        <div id="note_long_distance" class="fs-6 text-gray-700 mb-3" style="display:none;">
                                            Un supplément carburant de 0,70$ / km s'applique.

                                            <br><br>

                                            Les frais de séjour de l’équipe ne sont pas compris. Ils ne s’appliquent que si notre équipe ne peut pas rentrer à nos bureaux le jour même du déménagement.

                                        </div>

                                        <div id="note_installations" class="fs-6 text-gray-700 mb-3" style="display:none;">
                                            Veuillez noter que nos services n'incluent pas les installations électriques ni de plomberie.
                                        </div>

                                        <div id="note_residential_and_long_distance" class="fs-6 text-gray-700 mb-3" style="display:none;">
                                            Pour vous simplifier la vie, nous fournissons des couvertures de protection, du ruban adhésif et tout le matériel nécessaire afin que vos biens voyagent en toute sécurité.
                                        </div>

                                        <div id="note_residential_pack" class="fs-6 text-gray-700 mb-3" style="display:none;">
                                            Ce tarif n'inclut pas le coût des matériaux d'emballage.
                                            Pour en savoir plus sur les prix des matériaux, n'hésitez pas à consulter la section Emballage. 
                                            <br>Vous y trouverez tous les détails utiles pour bien préparer votre déménagement.
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- Price -->
                            <div id="div_price" class="notice bg-light-warning rounded border-warning border p-6" style="display:none;">
                                <div class="d-flex flex-column">
                                    <h4 class="text-gray-900 fw-bold">Tarif estimé</h4>
                                    <div id="price_message" class="fs-6 text-gray-700 mt-2">
                                        <!-- Message will be inserted here dynamically -->
                                    </div>
                                </div>
                            </div>

                            <br>
                            <!-- Botón enviar -->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_up_submit" class="bg-[#00da5b] hover:bg-[#00c14d] text-white font-semibold py-3 px-6 rounded-xl transition duration-300 text-lg md:text-xl">
                                    <span class="indicator-label">Envoyer</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                            
                        </form>
                    @endif

                    @if(session('reservation'))
                        @php
                            $reservation = session('reservation');
                        @endphp
                        <div class="p-10 text-center">
                            <h2 class="text-dark fw-bold mb-5">Merci, {{ $reservation->name }}!</h2>
                            <p class="fs-5 text-gray-700 mb-5">
                                Votre réservation a été enregistrée avec succès. Voici un résumé :
                            </p>
                            <div class="card shadow-sm p-5 bg-light text-start">
                                <p><strong>Date :</strong> {{ $reservation->reserve_date ? \Carbon\Carbon::parse($reservation->reserve_date)->format('d/m/Y H:i') : 'Non spécifiée' }}</p>

                                <p><strong>Service :</strong>
                                    @switch($reservation->service)
                                        @case('residential')
                                            Déménagement résidentiel
                                            @break
                                        @case('residential_pack')
                                            Déménagement résidentiel avec emballage et déballage
                                            @break
                                        @case('commercial')
                                            Déménagement commercial
                                            @break
                                        @case('longue_distance')
                                            Transport longue distance
                                            @break
                                        @case('installations')
                                            Installations spéciales
                                            @break
                                        @default
                                            Service inconnu
                                    @endswitch
                                </p>

                                <p>
                                    <strong>Adresse de départ :</strong>
                                    {{ $reservation->no_rue_depart }},
                                    {{ $reservation->ville_depart }},
                                    {{ $reservation->code_postal_depart }}
                                </p>

                                @if($reservation->no_rue_destination || $reservation->ville_destination || $reservation->code_postal_destination)
                                    <p>
                                        <strong>Adresse de destination :</strong>
                                        {{ $reservation->no_rue_destination ?? '' }},
                                        {{ $reservation->ville_destination ?? '' }},
                                        {{ $reservation->code_postal_destination ?? '' }}
                                    </p>
                                @endif

                                @if($reservation->equipe)
                                    <p><strong>Équipe :</strong>
                                        @switch($reservation->equipe)
                                            @case('equipe_1')
                                                Service conducteur seulement
                                                @break
                                            @case('equipe_2')
                                                Équipe de 2 personnes
                                                @break
                                            @case('equipe_3')
                                                Équipe de 3 personnes
                                                @break
                                            @case('equipe_4')
                                                2 Équipes de 3 personnes
                                                @break
                                            @default
                                                Non assignée
                                        @endswitch
                                    </p>
                                @endif

                                <p><strong>Montant payé :</strong>
                                    {{ number_format($reservation->amount_paid, 2, ',', ' ') }} {{ strtoupper($reservation->currency) }}
                                </p>
                            </div>
                            <p class="fs-6 text-gray-600 mt-5">
                                Un email de confirmation a été envoyé à <strong>{{ $reservation->email }}</strong>.
                                <br>Si vous avez des questions, n'hésitez pas à nous contacter.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

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
                <h2>Continue to Payment</h2>
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
