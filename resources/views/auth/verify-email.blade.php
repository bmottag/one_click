<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Email - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Styles Keen -->
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
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">Verify Your Email</h1>
                <div class="d-none d-lg-block text-white fs-base text-center">
                    Please verify your email to continue using {{ config('app.name') }}.
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 bg-white">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">

                    <!-- Mensaje principal -->
                    <div class="text-center mb-10">
                        <h1 class="text-dark fw-bolder mb-3">Verify Your Email Address</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Thanks for signing up! Before getting started, please verify your email by clicking the link we just emailed to you.
                            If you didn't receive the email, we can send you another.
                        </div>
                    </div>

                    <!-- Estado de envío -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-5">
                            A new verification link has been sent to your email address.
                        </div>
                    @endif

                    <div class="d-flex flex-column gap-5">

                        <!-- Reenviar email -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
                        </form>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light w-100">Log Out</button>
                        </form>

                    </div>

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

</body>
</html>