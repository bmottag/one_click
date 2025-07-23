<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
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
                        <img alt="Logo" src="{{ asset('template/assets/media/logos/one_click.png') }}" class="h-150px h-lg-200px" />
                    </a>
                    <img class="d-none d-lg-block mx-auto w-300px w-lg-75 w-xl-500px mb-10 mb-lg-20"
                        src="{{ asset('template/assets/media/misc/one_click.png') }}" alt="" />
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">One click to find services, jobs and opportunities</h1>
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        Your life in Canada, one click away.
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <!-- Mensajes de sesión -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Formulario de Login -->
                        <form method="POST" id="kt_sign_in_form" action="{{ route('login') }}" class="form w-100" novalidate>
                            @csrf

                            <!-- Encabezado -->
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Welcome back</div>
                            </div>

                            <!-- Email -->
                            <div class="fv-row mb-8">
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="form-control bg-transparent @error('email') is-invalid @enderror"
                                    placeholder="Email" />
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="fv-row mb-3">
                                <input type="password" name="password" required
                                    class="form-control bg-transparent @error('password') is-invalid @enderror"
                                    placeholder="Password" />
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Recordarme y enlace -->
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-primary">Forgot Password?</a>
                                @endif
                            </div>

                            <!-- Botón de login -->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Sign In</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                            <!-- Registro -->
                            @if (Route::has('register'))
                                <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                                    <a href="{{ route('register') }}" class="link-primary">Sign up</a>
                                </div>
                            @endif
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
    <script src="{{ asset('template/assets/js/custom/authentication/sign-in/general.js') }}"></script>
</body>
</html>