<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Fonts -->
    <link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" />
</head>
<body id="kt_body" class="app-blank app-blank">
    <script>
        var defaultThemeMode = "light"; var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!-- Aside -->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-image: url('{{ asset('template/assets/media/misc/auth-bg.png') }}')">
                <div class="d-flex flex-column flex-center p-6 p-lg-10 w-100">
                    <a href="{{ url('/') }}" class="mb-0 mb-lg-20">
                        <img alt="Logo" src="{{ asset('template/assets/media/logos/one_click.png') }}" class="h-150px h-lg-200px" />
                    </a>
                    <img class="d-none d-lg-block mx-auto w-300px w-lg-75 w-xl-500px mb-10 mb-lg-20" src="{{ asset('template/assets/media/misc/one_click.png') }}" alt="" />
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">One click to find services, jobs and opportunities</h1>
                    <div class="d-none d-lg-block text-white fs-base text-center">
                        Your life in Canada, one click away.
                    </div>
                </div>
            </div>
            <!-- Body -->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 bg-white">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <form method="POST" action="{{ route('password.email') }}" class="form w-100" id="kt_password_reset_form" novalidate>
                            @csrf
                            <div class="text-center mb-10">
                                <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div>
                            </div>

                            <div class="fv-row mb-8">
                                <input type="email" name="email" autocomplete="off" placeholder="Email"
                                    class="form-control bg-transparent @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success mt-4">{{ session('status') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="d-flex flex-center flex-wrap px-5 mt-10">
                    <div class="d-flex fw-semibold text-primary fs-base">
                        <a href="https://keenthemes.com" class="px-5" target="_blank">Terms</a>
                        <a href="https://devs.keenthemes.com" class="px-5" target="_blank">Plans</a>
                        <a href="https://themes.getbootstrap.com/product/keen-the-ultimate-bootstrap-admin-theme/" class="px-5" target="_blank">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>var hostUrl = "{{ asset('template/assets') }}/";</script>
    <script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/custom/authentication/reset-password/reset-password.js') }}"></script>

</body>
</html>
