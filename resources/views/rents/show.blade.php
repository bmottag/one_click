{{-- resources/views/rents/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Rents', 'url' => route('rents.show_all')]
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
                            'images/slides/top-travel-destinations-canada.png',
                            'images/slides/solar energy-consulting-services-canada.png',
                            'images/slides/real-estate-investment-canada.png'
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
                                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">Rents</a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Text-->
                                    <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">
                                        Browse available rentals, explore property details, and easily rent or list your own space.
                                    </span>
                                    <!--end::Text-->
                                </div>
                                <!--end::User-->
                                <!--begin::Actions-->
                                <div class="d-flex">
                                    <form method="GET" action="{{ route('rents.show_all') }}">
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
                    @if($rents->isEmpty())
                        <!--begin::Col-->
                        <div class="col-xl-4">
                            <!--begin::Engage widget 1-->
                            <div class="card h-md-100" dir="ltr">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column flex-center">
                                    <!--begin::Heading-->
                                    <div class="mb-2">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">No Rents available right now.
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
                        @foreach($rents as $rent)
                            <!--begin::Col-->
                            <div class="col-xxl-6 mb-5">
                                <!--begin::Card widget-->
                                <div class="card card-flush h-100">
                                    <!--begin::Body-->
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <div class="row gx-4 gx-sm-9 h-100">
                                            <!--begin::Carousel Column-->
                                            <div class="col-sm-6 mb-4 mb-sm-0">
                                                <div id="rentCarousel{{ $rent->id }}" class="carousel slide card-rounded h-100" data-bs-ride="false">
                                                    <div class="carousel-inner h-100 text-center">
                                                        @foreach($rent->images as $index => $img)
                                                            <div class="carousel-item @if($index == 0) active @endif">
                                                                <div class="d-flex align-items-center justify-content-center h-100">
                                                                    <img 
                                                                        src="{{ asset('storage/' . $img) }}" 
                                                                        class="img-fluid card-rounded shadow-sm" 
                                                                        style="width: 100%; height: 100%; object-fit: cover;" 
                                                                        alt="Rent image {{ $index + 1 }}"
                                                                    >
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Controls -->
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#rentCarousel{{ $rent->id }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#rentCarousel{{ $rent->id }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>

                                                    <!-- Indicators -->
                                                    <ol class="carousel-indicators">
                                                        @foreach($rent->images as $index => $img)
                                                            <li data-bs-target="#rentCarousel{{ $rent->id }}" data-bs-slide-to="{{ $index }}" class="@if($index == 0) active @endif"></li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                            <!--end::Carousel Column-->

                                            <!--begin::Content Column-->
                                            <div class="col-sm-6 d-flex flex-column">
                                                <!-- Header -->
                                                <div class="d-flex justify-content-between align-items-start mb-6">
                                                    <span class="text-gray-800 fs-1 fw-bold">{{ $rent->rent_title }}</span>
                                                    @php
                                                        $today = date('Y-m-d');
                                                        $state = $rent->due_date > $today ? 'Active' : 'Close';
                                                        $style = $rent->due_date > $today ? 'primary' : 'danger';
                                                    @endphp
                                                    <span class="badge badge-light-{{ $style }} py-2 px-3 fs-7">{{ $state }}</span>
                                                </div>

                                                <!-- Description -->
                                                <p class="fw-semibold text-gray-600 fs-6 mb-4">{{ $rent->description }}</p>

                                                <!-- Contact Info -->
                                                <div class="d-flex flex-wrap gap-3 mb-3">
                                                    <!-- Date -->
                                                    <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                                        <div>
                                                            <div class="fw-bold">{{ $rent->due_date->format('M j, Y') }}</div>
                                                            <div class="text-gray-400 small">Due Date</div>
                                                        </div>
                                                    </div>

                                                    <!-- Phone -->
                                                    @php
                                                        $formattedPhone = preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $rent->contact_number);
                                                    @endphp
                                                    <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                        <i class="fas fa-phone text-gray-400"></i>
                                                        <div>
                                                            <a href="tel:{{ preg_replace('/\D/', '', $rent->contact_number) }}" class="text-decoration-none">
                                                                <div class="fw-bold text-primary">{{ $formattedPhone }}</div>
                                                            </a>
                                                            <div class="text-gray-400 small">Contact</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Contact Info-->
                                            </div>
                                            <!--end::Content Column-->
                                        </div>
                                    </div>
                                    <!--end::Body-->
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