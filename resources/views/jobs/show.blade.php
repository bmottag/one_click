{{-- resources/views/jobs/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Jobs', 'url' => route('jobs.show_all')]
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
                                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">Jobs</a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Text-->
                                    <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">
                                        Discover job opportunities, explore details, and easily apply or post new openings.
                                    </span>
                                    <!--end::Text-->
                                </div>
                                <!--end::User-->
                                <!--begin::Actions-->
                                <div class="d-flex">
                                    <form method="GET" action="{{ route('jobs.show_all') }}">
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
                    @if($jobs->isEmpty())
                        <!--begin::Col-->
                        <div class="col-xl-4">
                            <!--begin::Engage widget 1-->
                            <div class="card h-md-100" dir="ltr">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column flex-center">
                                    <!--begin::Heading-->
                                    <div class="mb-2">
                                        <!--begin::Title-->
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">No Jobs available right now.
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
                        @foreach($jobs as $job)
                            <!--begin::Col-->
                            <div class="col-md-6 col-xl-4 mb-5">
                                <!--begin::Card-->
                                <div class="card border-hover-primary h-100 d-flex flex-column">
                                    <!-- Card Header -->
                                    <div class="card-header border-0 pt-4 d-flex justify-content-between align-items-start">
                                        <span class="text-gray-800 fs-1 fw-bold">{{ $job->job_title }}</span>
                                        @php
                                            $today = date('Y-m-d');
                                            $state = $job->due_date > $today ? 'Active' : 'Close';
                                            $style = $job->due_date > $today ? 'primary' : 'danger';
                                        @endphp
                                        <span class="badge badge-light-{{ $style }} py-2 px-3 fs-7">{{ $state }}</span>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body d-flex flex-column p-4">
                                        <!-- Job Description -->
                                        <p class="fw-semibold text-gray-600 fs-6 mb-4">{{ $job->job_description }}</p>

                                        <!-- Info Cards -->
                                        <div class="d-flex flex-wrap gap-3 mb-4">
                                            <!-- Company -->
                                            <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                <i class="fas fa-building text-gray-400"></i>
                                                <div>
                                                    <div class="fw-bold text-gray-800">{{ $job->company }}</div>
                                                    <div class="text-gray-400 small">Company</div>
                                                </div>
                                            </div>

                                            <!-- Due Date -->
                                            <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                                <div>
                                                    <div class="fw-bold text-gray-800">{{ $job->due_date->format('M j, Y') }}</div>
                                                    <div class="text-gray-400 small">Due Date</div>
                                                </div>
                                            </div>

                                            <!-- Contact -->
                                            @php
                                                $formattedPhone = preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $job->contact_number);
                                            @endphp
                                            <div class="border border-gray-300 border-dashed rounded p-3 flex-fill d-flex align-items-center gap-2">
                                                <i class="fas fa-phone text-gray-400"></i>
                                                <div>
                                                    <a href="tel:{{ preg_replace('/\D/', '', $job->contact_number) }}" class="text-decoration-none">
                                                        <div class="fw-bold text-primary">{{ $formattedPhone }}</div>
                                                    </a>
                                                    <div class="text-gray-400 small">Contact</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Optional Button -->
                                        @if($job->link)
                                            @php
                                                $link = Str::startsWith($job->link, ['http://', 'https://']) ? $job->link : 'https://' . $job->link;
                                            @endphp
                                            <a href="{{ $link }}" class="btn btn-primary mt-auto align-self-start" target="_blank" rel="noopener">Apply Now</a>
                                        @endif
                                    </div>
                                </div>
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

@section('scripts')
    <script src="{{ asset('js/validations/jobs.js') }}"></script>
@endsection