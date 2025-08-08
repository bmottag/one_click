{{-- resources/views/rents/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Rents', 'url' => route('rents.show_all')],
            ['label' => 'All Rents']
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
                            <div class="col-md-6 col-xl-4">
                                <!--begin::Card-->
                                <a href="../../demo8/dist/apps/projects/project.html" class="card border-hover-primary">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 pt-9">
                                        <!--begin::Card Title-->
                                        <div class="card-title m-0">
                                            <!--begin::Title-->
                                            <div class="flex-shrink-0 me-5">
                                                <span class="text-gray-800 fs-1 fw-bold">{{ $rent->rent_title }}</span>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Car Title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            @php
                                                $today = date('Y-m-d');

                                                $state = $rent->due_date > $today ? 'Active' : 'Close';
                                                $style = $rent->due_date > $today ? 'primary' : 'danger';
                                            @endphp
                                            <span class="badge badge-light-{{ $style }} flex-shrink-0 align-self-center py-3 px-4 fs-7">{{ $state }}</span>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end:: Card header-->
                                    <!--begin:: Card body-->
                                    <div class="card-body p-9">
                                        <!--begin::Description-->
                                        <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">{{ $rent->description }}</span>
                                        <!--end::Description-->
                                        <!--begin::Info-->
                                        <div class="d-flex flex-wrap mb-5">
                                            <!--begin::Due-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                <div class="fs-6 text-gray-800 fw-bold">{{ $rent->due_date->format('M j, Y') }}</div>
                                                <div class="fw-semibold text-gray-400">Due Date</div>
                                            </div>
                                            <!--end::Due-->
                                            <!--begin::Budget-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                <div class="fs-6 text-gray-800 fw-bold">{{ $rent->contact_number }}</div>
                                                <div class="fw-semibold text-gray-400">Contact Number</div>
                                            </div>
                                            <!--end::Budget-->
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end:: Card body-->
                                </a>
                                <!--end::Card-->
                            </div>
                            <!--end::Col-->
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection