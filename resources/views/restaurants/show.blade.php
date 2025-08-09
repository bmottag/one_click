{{-- resources/views/restaurants/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Restaurants', 'url' => route('restaurants.show_all')],
            ['label' => 'All Events']
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
                    <h3 class="fw-bold my-2">Restaurants</h3>
                    <!--end::Heading-->
                </div>

                <!--begin::Form-->
                <form method="GET" action="{{ route('restaurants.show_all') }}">
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
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">No restaurants to display at the moment. 
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
                            <div class="col-xxl-5">
                                <!--begin::Card widget 18-->
                                <div class="card card-flush h-md-100">
                                    <!--begin::Body-->
                                    <div class="card-body py-9">
                                        <!--begin::Row-->
                                        <div class="row gx-9 h-100">
                                            <!--begin::Col-->
                                            <div class="col-sm-6 mb-10 mb-sm-0">
                                                <!--begin::Image-->
                                                <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px min-h-sm-100 h-100" 
                                                    style="background-size: 100% 100%;background-image:url('{{ asset('storage/' . $item->image) }}')"></div>
                                                <!--end::Image-->
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
                                                                <span class="text-gray-800 fs-1 fw-bold">{{ $item->title }}</span>
                                                            </div>
                                                            <!--end::Title-->
                                                            @php
                                                                $today = date('Y-m-d');

                                                                $state = $item->date > $today ? 'Active' : 'Close';
                                                                $style = $item->date > $today ? 'primary' : 'danger';
                                                            @endphp
                                                            <span class="badge badge-light-{{ $style }} flex-shrink-0 align-self-center py-3 px-4 fs-7">{{ $state }}</span>
                                                        </div>
                                                        <!--end::Heading-->
                                                        <!--begin::Items-->
                                                        <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                                                            <!--begin::Item-->
                                                            <div class="d-flex align-items-center me-5 me-xl-13">
                                                                @if (!empty($item->instagram))
                                                                    @php
                                                                        $igLink = Str::startsWith($item->instagram, ['http://', 'https://']) 
                                                                            ? $item->instagram 
                                                                            : 'https://' . $item->instagram;
                                                                    @endphp

                                                                    <a href="{{ $igLink }}" target="_blank" rel="noopener" class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Instagram">
                                                                        <img alt="Instagram" src="{{ asset('template/assets/media/svg/brand-logos/instagram-2-1.svg') }}" />
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <!--end::Item-->
                                                        </div>
                                                        <!--end::Items-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Body-->
                                                    <div class="mb-6">
                                                        <!--begin::Text-->
                                                        <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">{{ $item->description }}</span>
                                                        <!--end::Text-->
                                                        <!--begin::Stats-->
                                                        <div class="d-flex">
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
                                                                <!--begin::Date-->
                                                                <span class="fs-6 text-gray-700 fw-bold">{{ $item->address }}</span>
                                                                <!--end::Date-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold text-gray-400">Date</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
                                                                <!--begin::Number-->
                                                                <span class="fs-6 text-gray-700 fw-bold">{{ $item->place }}</span>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold text-gray-400">Place</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                        </div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Body-->
                                                    <!--begin::Footer-->
                                                    <div class="d-flex flex-stack mt-auto bd-highlight">
                                                        <!--begin::Actions-->
                                                        @if ($item->link)
                                                            @php
                                                                $link = Str::startsWith($item->link, ['http://', 'https://']) ? $item->link : 'https://' . $item->link;
                                                            @endphp
                                                            <a href="{{ $link }}" class="text-primary opacity-75-hover fs-6 fw-semibold" target="_blank" rel="noopener">More
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr095.svg-->
                                                            <span class="svg-icon svg-icon-4 svg-icon-gray-800 ms-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.3" d="M4.7 17.3V7.7C4.7 6.59543 5.59543 5.7 6.7 5.7H9.8C10.2694 5.7 10.65 5.31944 10.65 4.85C10.65 4.38056 10.2694 4 9.8 4H5C3.89543 4 3 4.89543 3 6V19C3 20.1046 3.89543 21 5 21H18C19.1046 21 20 20.1046 20 19V14.2C20 13.7306 19.6194 13.35 19.15 13.35C18.6806 13.35 18.3 13.7306 18.3 14.2V17.3C18.3 18.4046 17.4046 19.3 16.3 19.3H6.7C5.59543 19.3 4.7 18.4046 4.7 17.3Z" fill="currentColor" />
                                                                    <rect x="21.9497" y="3.46448" width="13" height="2" rx="1" transform="rotate(135 21.9497 3.46448)" fill="currentColor" />
                                                                    <path d="M19.8284 4.97161L19.8284 9.93937C19.8284 10.5252 20.3033 11 20.8891 11C21.4749 11 21.9497 10.5252 21.9497 9.93937L21.9497 3.05029C21.9497 2.498 21.502 2.05028 20.9497 2.05028L14.0607 2.05027C13.4749 2.05027 13 2.52514 13 3.11094C13 3.69673 13.4749 4.17161 14.0607 4.17161L19.0284 4.17161C19.4702 4.17161 19.8284 4.52978 19.8284 4.97161Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon--></a>
                                                        @endif
                                                        <a href="#" class="btn btn-primary btn-sm flex-shrink-0 me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_bidding">Join Event</a>
                                                        <!--end::Actions-->
                                                    </div>
                                                    <!--end::Footer-->
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
