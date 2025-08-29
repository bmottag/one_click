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
                <!--begin::Toolbar-->
                <div class="d-flex flex-wrap flex-stack mb-6">
                    <!--begin::Heading-->
                    <h3 class="fw-bold my-2">Rents</h3>
                    <!--end::Heading-->
                </div>

                <!--begin::Form-->
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
                <!--end::Form-->

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
                            <div class="col-xxl-5">
                                <!--begin::Card widget 18-->
                                <div class="card card-flush h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body py-9">
                                        <!--begin::Row-->
                                        <div class="row gx-9 h-100">
                                            <!--begin::Col-->
                                            <div class="col-sm-6 mb-10 mb-sm-0">
                                                <!--begin::Carousel-->
                                                <div id="eventCarousel{{ $rent->id }}" class="carousel slide card-rounded min-h-400px min-h-sm-100 h-100" data-bs-ride="carousel">
                                                    <div class="carousel-inner h-100">
                                                        @foreach($rent->images as $index => $img)
                                                            <div class="carousel-item @if($index == 0) active @endif h-100">
                                                                <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-100" 
                                                                    style="background-size: 100% 100%; background-image: url('{{ asset('storage/' . $img) }}')">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Controls -->
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel{{ $rent->id }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel{{ $rent->id }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>

                                                    <!-- Indicators -->
                                                    <ol class="carousel-indicators">
                                                        @foreach($rent->images as $index => $img)
                                                            <li data-bs-target="#eventCarousel{{ $rent->id }}" data-bs-slide-to="{{ $index }}" class="@if($index == 0) active @endif"></li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                                <!--end::Carousel-->
                                            </div>

                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-sm-6">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column h-100">
                                                    <!--begin::Header-->
                                                    <div class="mb-7">
                                                        <!--begin::Headin-->
                                                        <div class="d-flex flex-stack mb-6">
                                                            <!--begin::Title-->
                                                            <div class="flex-shrink-0 me-5">
                                                                <span class="text-gray-800 fs-1 fw-bold">{{ $rent->rent_title }}</span>
                                                            </div>
                                                            <!--end::Title-->
                                                            @php
                                                                $today = date('Y-m-d');

                                                                $state = $rent->due_date > $today ? 'Active' : 'Close';
                                                                $style = $rent->due_date > $today ? 'primary' : 'danger';
                                                            @endphp
                                                            <span class="badge badge-light-{{ $style }} flex-shrink-0 align-self-center py-3 px-4 fs-7">{{ $state }}</span>
                                                        </div>
                                                        <!--end::Heading-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Body-->
                                                    <div class="mb-6">
                                                        <!--begin::Text-->
                                                        <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">{{ $rent->description }}</span>
                                                        <!--end::Text-->
                                                        <!--begin::Stats-->
                                                        <div class="d-flex">
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
                                                                <!--begin::Date-->
                                                                <span class="fs-6 text-gray-700 fw-bold">{{ $rent->due_date->format('M j, Y') }}</span>
                                                                <!--end::Date-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold text-gray-400">Date</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
                                                                <!--begin::Number-->
                                                                <span class="fs-6 text-gray-700 fw-bold">{{ $rent->contact_number }}</span>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold text-gray-400">Contact Number</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                        </div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Body-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Card widget 18-->
                            </div>
                            <!--end::Col-->
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection