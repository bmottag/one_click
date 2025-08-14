@extends('layouts.app')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">

                <div class="row g-5 g-xl-10">


                    <div class="col-xl-12 mb-5 mb-xl-10">
                        <!--begin::Slider Widget 2-->
                        <div id="kt_sliders_widget_2_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5500">

                            <!--begin::Body-->
                            <div class="card-body py-6">
                                <!--begin::Carousel-->
                                <div class="carousel-inner">
                                    <!--begin::Item-->
                                    <div class="carousel-item active show">
										<div class="bgi-no-repeat bgi-size-cover rounded min-h-700px mb-7" style="background-image:url({{ asset('images/planA.webp') }});"></div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="carousel-item">
                                        <div class="bgi-no-repeat bgi-size-cover rounded min-h-700px mb-7" style="background-image:url({{ asset('images/planB.webp') }});"></div>
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="carousel-item">
                                        <div class="bgi-no-repeat bgi-size-cover rounded min-h-700px mb-7" style="background-image:url({{ asset('images/planC.webp') }});"></div>
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Carousel-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Header-->
                            <div class="card-header pt-1">
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Carousel Indicators-->
                                    <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                                        <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="0" class="active ms-1"></li>
                                        <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="1" class="ms-1"></li>
                                        <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="2" class="ms-1"></li>
                                    </ol>
                                    <!--end::Carousel Indicators-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                        </div>
                        <!--end::Slider Widget 2-->
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection