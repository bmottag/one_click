<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/" />
    <title>Reset Password | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('template/assets/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!-- Aside with background image -->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-image: url({{ asset('template/assets/media/misc/auth-bg.png') }})">
                <div class="d-flex flex-column flex-center p-6 p-lg-10 w-100">
                    <a href="#" class="mb-0 mb-lg-20">
                        <img alt="Logo" src="{{ asset('template/assets/media/logos/default-white.svg') }}" class="h-40px h-lg-50px" />
                    </a>
                    <img class="d-none d-lg-block mx-auto w-300px w-lg-75 w-xl-500px mb-10 mb-lg-20" src="{{ asset('template/assets/media/misc/auth-screens.png') }}" alt="" />
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
                    <div class="d-none d-lg-block text-white fs-base text-center">Secure your access and reset your password easily.</div>
                </div>
            </div>

            <!-- Reset Password Form -->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <form class="form w-100" method="POST" action="{{ route('password.store') }}" novalidate id="kt_new_password_form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="text-center mb-10">
                                <h1 class="text-dark fw-bolder mb-3">Set up New Password</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Already reset?
                                    <a href="{{ route('login') }}" class="link-primary fw-bold">Sign in</a>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="fv-row mb-8">
                                <input class="form-control bg-transparent" type="email" placeholder="Email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
                                @error('email')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="new-password" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
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
                                <div class="text-muted">Use 8+ characters with letters, numbers & symbols.</div>
                                @error('password')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="fv-row mb-8">
                                <input type="password" placeholder="Repeat Password" name="password_confirmation" required autocomplete="new-password" class="form-control bg-transparent" />
                                @error('password_confirmation')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_new_password_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Footer -->
                <div class="d-flex flex-center flex-wrap px-5">
                    <div class="d-flex fw-semibold text-primary fs-base">
                        <a href="#" class="px-5">Terms</a>
                        <a href="#" class="px-5">Plans</a>
                        <a href="#" class="px-5">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Assets -->
    <script>var hostUrl = "{{ asset('template/assets') }}/";</script>
    <script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('template/assets/js/custom/authentication/reset-password/new-password.js') }}"></script>
</body>
</html>