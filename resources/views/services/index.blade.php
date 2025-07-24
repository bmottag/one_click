{{-- resources/views/services/index.blade.php --}}
@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumb 
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Services', 'url' => route('services.show_all')],
            ['label' => $showingAll ? 'All Services' : 'My Services']
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
                    <h3 class="fw-bold my-2">Services</h3>
                    <!--end::Heading-->
                    <!--begin::Actions-->
                    <div class="d-flex flex-wrap my-2">
                        @if (!$showingAll)
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_new_service">New Service</a>
                        @endif
                    </div>
                    <!--end::Actions-->
                </div>

                <!--begin::Form-->
                <form method="GET" action="{{ $showingAll ? route('services.show_all') : route('services.index') }}">
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
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">No services to display at the moment. 
                                        @if ($showingAll)
                                            <br />Thanks for your interest!</h1>
                                        @else
                                            <br />To create a new one, please
                                            <span class="fw-bolder">  follow this link</span></h1>
                                            <!--end::Title-->
                                        @endif
                                        <!--begin::Illustration-->
                                        <div class="py-10 text-center">
                                            <img src="{{ asset('template/assets/media/svg/illustrations/easy/2.svg') }}" class="theme-light-show w-200px" alt="" />
                                            <img src="{{ asset('template/assets/media/svg/illustrations/easy/2-dark.svg') }}" class="theme-dark-show w-200px" alt="" />
                                        </div>
                                        <!--end::Illustration-->
                                    </div>
                                    <!--end::Heading-->
                                    @if (!$showingAll)
                                        <!--begin::Links-->
                                        <div class="text-center mb-1">
                                            <!--begin::Link-->
                                            <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_new_service">New Service</a>
                                            <!--end::Link-->
                                        </div>
                                        <!--end::Links-->
                                    @endif
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

    <!--begin::Modals-->
    <!--begin::Modal - New Target-->
    <div class="modal fade" id="kt_modal_new_service" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="kt_modal_new_service_form" class="form" enctype="multipart/form-data">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Service</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="text-muted fw-semibold fs-5">Add / Edit Service.</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Company Name</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Company Name" name="company_name" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="fs-6 fw-semibold mb-2"><span class="required">Description</span></label>
                            <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Description"></textarea>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Phone</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="Enter Phone Number" name="contact_number" />
                            </div>
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">Email</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="Enter Email" name="email" />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Address</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Address" name="address" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">
                                <span class="required">Image</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select an image that best represents your service."></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Image input placeholder-->
                            <style>.image-input-placeholder { background-image: url("{{ asset('template/assets/media/svg/files/blank-image.svg') }}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url("{{ asset('template/assets/media/svg/files/blank-image-dark.svg') }}"); }</style>
                            <!--end::Image input placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                <!--begin::Preview existing image-->
                                <div class="image-input-wrapper w-225px h-225px"></div>
                                <!--end::Preview existing image-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Link</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Restaurant Link" name="link" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Facebook</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Restaurant Facebook" name="facebook" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Instagram</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Restaurant Instagram" name="instagram" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span>Youtube</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Restaurant Youtube" name="youtube" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_service_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_modal_new_service_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Target-->
    <!--end::Modals-->
@endsection

@section('scripts')
    <script src="{{ asset('js/validations/services.js') }}"></script>
@endsection
