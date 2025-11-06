{{-- resources/views/services/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Services', 'url' => route('services.show_all')],
        ]"
    />
@endsection

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">

				<!--begin::Navbar-->
                <div class="card card-flush mb-9" id="kt_user_profile_panel">
                    <!--begin::Hero nav-->
                    <x-hero-carousel 
                        :images="[
                            'images/slides/buy-houses-and-apartments-canada.png',
                            'images/slides/corporate-electronic-events-canada.png',
                            'images/slides/culinary-experience-calgary.png'
                        ]"
                        height="400"
                    />
                    <div class="card-body mt-n19">
                        <!--begin::Details-->
                        <div class="m-0">
                            <div class="d-flex flex-stack align-items-end pb-4 mt-n19" style="min-height: 100px;"></div>

                            <!--begin::Info-->
                            <div class="d-flex flex-stack flex-wrap align-items-end">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">Services</a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Text-->
                                    <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">
                                        Browse available services, explore detailed offerings, and easily connect with the ones that fit your needs.
                                    </span>
                                    <!--end::Text-->
                                </div>
                                <!--end::User-->
                                <!--begin::Actions-->
                                <div class="d-flex">
                                    <form method="GET" action="{{ route('services.show_all') }}">
                                        <!--begin::Card-->
                                        <div class="card mb-7">
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <!--begin::Compact form-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Input group-->
                                                    <div class="position-relative w-md-400px me-md-2">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                        <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="Search" />
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin:Action-->
                                                    <div class="d-flex align-items-center">
                                                        <button type="submit" class="btn btn-primary me-5">Search</button>
                                                    </div>
                                                    <!--end:Action-->
                                                </div>
                                                <!--end::Compact form-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </form>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>

                <!--end::Toolbar-->
                <div class="row g-5 g-xl-10">
                    @if($data->isEmpty())
                        <!--begin::Col-->
                        <div class="col-xl-4">
                            <!--begin::Engage widget 1-->
                            <div class="card h-md-100" dir="ltr">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column flex-center">
                                    <!--begin::Heading-->
                                    <div class="mb-2">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">No services to display at the moment. 
                                        <br />Thanks for your interest!</h1>
                                        <!--begin::Illustration-->
                                        <div class="py-10 text-center">
                                            <img src="{{ asset('template/assets/media/svg/illustrations/easy/2.svg') }}" class="theme-light-show w-200px" alt="" />
                                            <img src="{{ asset('template/assets/media/svg/illustrations/easy/2-dark.svg') }}" class="theme-dark-show w-200px" alt="" />
                                        </div>
                                        <!--end::Illustration-->
                                    </div>
                                    <!--end::Heading-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Engage widget 1-->
                        </div>
                        <!--end::Col-->
                    @else
                        @foreach($data as $item)
                            <!--begin::Col-->
                            <div class="col-xxl-5 mb-5">
                                <!--begin::Card widget-->
                                <div class="card card-flush h-100">
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <div class="row gx-4 gx-sm-9 h-100">
                                            <!--begin::Image Column-->
                                            <div class="col-sm-6 mb-4 mb-sm-0">
                                                <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-100" 
                                                    style="background-image:url('{{ asset('storage/' . $item->image) }}'); background-size: cover;"></div>
                                            </div>
                                            <!--end::Image Column-->

                                            <!--begin::Content Column-->
                                            <div class="col-sm-6 d-flex flex-column">
                                                <!-- Header -->
                                                <div class="d-flex flex-stack mb-6">
                                                    <span class="text-gray-800 fs-1 fw-bold">{{ $item->company_name }}</span>
                                                </div>

                                                <!-- Social Links -->
                                                <div class="d-flex gap-2 mb-3 flex-wrap">
                                                    @if (!empty($item->instagram))
                                                        @php
                                                            $igLink = Str::startsWith($item->instagram, ['http://','https://']) ? $item->instagram : 'https://' . $item->instagram;
                                                        @endphp
                                                        <a href="{{ $igLink }}" target="_blank" rel="noopener" class="symbol symbol-35px symbol-circle">
                                                            <img alt="Instagram" src="{{ asset('template/assets/media/svg/brand-logos/instagram-2-1.svg') }}" />
                                                        </a>
                                                    @endif

                                                    @if (!empty($item->facebook))
                                                        @php
                                                            $fbLink = Str::startsWith($item->facebook, ['http://','https://']) ? $item->facebook : 'https://' . $item->facebook;
                                                        @endphp
                                                        <a href="{{ $fbLink }}" target="_blank" rel="noopener" class="symbol symbol-35px symbol-circle">
                                                            <img alt="Facebook" src="{{ asset('template/assets/media/svg/brand-logos/facebook-4.svg') }}" />
                                                        </a>
                                                    @endif

                                                    @if (!empty($item->youtube))
                                                        @php
                                                            $ytLink = Str::startsWith($item->youtube, ['http://','https://']) ? $item->youtube : 'https://' . $item->youtube;
                                                        @endphp
                                                        <a href="{{ $ytLink }}" target="_blank" rel="noopener" class="symbol symbol-35px symbol-circle">
                                                            <img alt="YouTube" src="{{ asset('template/assets/media/svg/brand-logos/youtube-3.svg') }}" />
                                                        </a>
                                                    @endif

                                                    @if (!empty($item->google))
                                                        @php
                                                            $googleLink = Str::startsWith($item->google, ['http://','https://']) ? $item->google : 'https://' . $item->google;
                                                        @endphp
                                                        <a href="{{ $googleLink }}" target="_blank" rel="noopener" class="symbol symbol-35px symbol-circle">
                                                            <img alt="Google" src="{{ asset('template/assets/media/svg/brand-logos/google-icon.svg') }}" />
                                                        </a>
                                                    @endif
                                                </div>

                                                <!-- Description -->
                                                <p class="fw-semibold text-gray-600 fs-6 mb-4">{{ $item->description }}</p>

                                                <!-- Info Cards -->
                                                <div class="d-flex flex-wrap gap-3 mb-4">
                                                    <!-- Phone -->
                                                    @php
                                                        $formattedPhone = preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $item->contact_number);
                                                    @endphp
                                                    <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                        <i class="fas fa-phone text-gray-400"></i>
                                                        <div>
                                                            <a href="tel:{{ preg_replace('/\D/', '', $item->contact_number) }}" class="text-decoration-none">
                                                                <div class="fw-bold text-primary">{{ $formattedPhone }}</div>
                                                            </a>
                                                            <div class="text-gray-400 small">Contact</div>
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                        <i class="fas fa-envelope text-gray-400"></i>
                                                        <div>
                                                            <div class="fw-bold text-gray-800">{{ $item->email }}</div>
                                                            <div class="text-gray-400 small">Email</div>
                                                        </div>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                                        <div>
                                                            <div class="fw-bold text-gray-800">{{ $item->address }}</div>
                                                            <div class="text-gray-400 small">Address</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Button -->
                                                @if ($item->link)
                                                    @php
                                                        $link = Str::startsWith($item->link, ['http://','https://']) ? $item->link : 'https://' . $item->link;
                                                    @endphp
                                                    <a href="{{ $link }}" class="btn btn-primary mt-auto align-self-start" target="_blank" rel="noopener">More Info</a>
                                                @endif
                                            </div>
                                            <!--end::Content Column-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card widget-->
                            </div>

                            <!--end::Col-->
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection