<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    <!-- CSS de Keen -->
    <link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <!-- Imagen lateral -->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center"
                style="background-image: url('{{ asset('template/assets/media/misc/auth-bg.png') }}')">
                <div class="d-flex flex-column flex-center p-6 p-lg-10 w-100">
                    <a href="#" class="mb-0 mb-lg-20">
                        <img alt="Logo" src="{{ asset('template/assets/media/logos/default-white.svg') }}" class="h-40px h-lg-50px" />
                    </a>
                    <img class="d-none d-lg-block mx-auto w-300px w-lg-75 w-xl-500px mb-10 mb-lg-20"
                        src="{{ asset('template/assets/media/misc/auth-screens.png') }}" alt="" />
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        Register and start building amazing apps today.
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <!-- Registro -->
                        <form method="POST" id="kt_sign_up_form" action="{{ route('register') }}" class="form w-100">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Create your account</div>
                            </div>

                            <!-- Nombre -->
                            <div class="fv-row mb-8">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                                    class="form-control bg-transparent @error('name') is-invalid @enderror" required autofocus />
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="fv-row mb-8">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                    class="form-control bg-transparent @error('email') is-invalid @enderror" required />
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contenedor Alpine -->
                            <div x-data="locationData()" x-init="init()" class="row">

                                <!-- Province -->
                                <div class="col-md-6 fv-row mb-8">
                                    <label for="state" class="required fs-6 fw-semibold mb-2">Province</label>
                                    <select id="state"
                                            name="state_id"
                                            x-model="selectedState"
                                            @change="fetchCities();"
                                            class="form-select form-select-solid @error('state_id') is-invalid @enderror"
                                            data-placeholder="Select a Province"
                                            required>
                                        <option></option>
                                        <template x-for="state in states" :key="state.id">
                                            <option :value="state.id" x-text="state.name"></option>
                                        </template>
                                    </select>
                                    @error('state_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div class="col-md-6 fv-row mb-8">
                                    <label for="city" class="required fs-6 fw-semibold mb-2">City</label>
                                    <select id="city"
                                            name="city_id"
                                            x-model="selectedCity"
                                            class="form-select form-select-solid @error('city_id') is-invalid @enderror"
                                            data-placeholder="Selec a City"
                                            required>
                                        <option></option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                    @error('city_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input type="password" name="password" placeholder="Password"
                                            class="form-control bg-transparent @error('password') is-invalid @enderror" required autocomplete="new-password" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                </div>
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="fv-row mb-8">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    class="form-control bg-transparent" required />
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Términos -->
                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="terms" required />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                        I Accept the <a href="#" class="ms-1 link-primary">Terms</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Botón enviar -->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                    <span class="indicator-label">Sign Up</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                            <!-- Link login -->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                                <a href="{{ route('login') }}" class="link-primary fw-semibold">Sign in</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS de Keen -->
    <script>var hostUrl = "{{ asset('template/assets') }}/";</script>
    <script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/custom/authentication/sign-up/general.js') }}"></script>
		<!--To use Alpine.js-->
		<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function locationData() {
            return {
                states: [],
                cities: [],
                selectedState: null,
                selectedCity: null,
                countryId: 39,

                init() {
                    this.fetchStates().then(() => {
                        if (this.selectedState) {
                            this.fetchCities().then(() => {
                                this.selectedCity = '{{ old('city_id') }}';
                            });
                        }
                    });
                },

                fetchStates() {
                    return fetch(`/api/states/${this.countryId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.states = data;
                            this.selectedState = '{{ old('state_id') }}';
                        });
                },

                fetchCities() {
                    this.cities = [];
                    this.selectedCity = null;
                    if (!this.selectedState) return Promise.resolve();

                    return fetch(`/api/cities/${this.selectedState}`)
                        .then(res => res.json())
                        .then(data => {
                            this.cities = data;
                        });
                }
            }
        }
    </script>

</body>
</html>