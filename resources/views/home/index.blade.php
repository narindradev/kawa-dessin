@extends('base.base')

@section('content')

<div class="content pt-0 d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <!--begin::Hero-->
    <div class="d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url('https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/bg/bg-9.jpg');height:350px">
        <div class="container">
            <!--begin::Topbar-->
            <div class="d-flex justify-content-between align-items-center border-bottom border-white py-7">
                <h3 class="h4 text-dark mb-0">Help Center</h3>
                <div class="d-flex">
                    <a href="#" class="font-size-h6 font-weight-bold">Community</a>
                    <a href="#" class="font-size-h6 font-weight-bold ml-8">Visit Blog</a>
                </div>
            </div>
            <!--end::Topbar-->
            <div class="d-flex align-items-stretch text-center flex-column py-40">
                <!--begin::Heading-->
                <h1 class="text-dark font-weight-bolder mb-12 title">Démarrer votre projet</h1>
                <!--end::Heading-->
            </div>
        </div>
    </div>
    <!--end::Hero-->
    <!--begin::Section-->
    <div class="container py-8">
        <div class="row">
            <div class="col-lg-6">
                <!--begin::Callout-->
                <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">
                                <a href="#" class="h4 text-dark text-hover-primary mb-5">Simulation 3D</a>
                                <p class="text-dark-50">There are many variations of Lorem Ipsum available.</p>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a href="/metronic/demo1/custom/apps/support-center/feedback.html" target="_blank" class="btn font-weight-bolder text-uppercase btn-success py-4 px-2">Start</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
            <div class="col-lg-6">
                <!--begin::Callout-->
                <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">
                                <a href="#" class="h4 text-dark text-hover-primary mb-5">Nouvelle contruction</a>
                                <p class="text-dark-50">There are many variations of Lorem Ipsum available.</p>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a href="/metronic/demo1/custom/apps/support-center/feedback.html" target="_blank" class="btn font-weight-bolder text-uppercase btn-warning py-4 px-2">
                                    Start
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
            <div class="col-lg-6">
                <!--begin::Callout-->
                <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">
                                <a href="#" class="h4 text-dark text-hover-primary mb-5">Travaux sur batiment existant</a>
                                <p class="text-dark-50">There are many variations of Lorem Ipsum available.</p>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a href="/metronic/demo1/custom/apps/support-center/feedback.html" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-2">
                                    Start
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
            <div class="col-lg-6">
                <!--begin::Callout-->
                <div class="card card-custom mb-2 bg-diagonal bg-diagonal-light-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                            <div class="d-flex flex-column mr-5">
                                <a href="#" class="h4 text-dark text-hover-primary mb-5">Annexe</a>
                                <p class="text-dark-50">There are many variations of Lorem Ipsum available.</p>
                            </div>
                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                <a href="/metronic/demo1/custom/apps/support-center/feedback.html" target="_blank" class="btn font-weight-bolder text-uppercase btn-warning py-4 px-2">
                                    Start
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Callout-->
            </div>
        </div>
    </div>
</div>

@endsection