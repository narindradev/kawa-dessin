<div class="d-flex flex-aligns-center pe-10 pb-2 pe-lg-20">
    {{-- <img alt="" class="w-30px me-3" src="{{ asset(theme()->getMediaUrlPath() . 'svg/files/upload.svg') }}"/> --}}
    {{-- <img alt="" class="w-30px me-3" src="{{ asset(theme()->getMediaUrlPath() . 'svg/files/upload.svg') }}"/> --}}
    <div class="ms-1 fw-bold">
        <span class="fs-6 text-primary fw-bolder">{{ $file->originale_name }}</span>
        <div class="text-gray-400"><i> {{ trans('lang.size') }} : {{ file_sisze($file->size) }},
                {{ trans('lang.type') }} : {{ $file->type }} </i> </div>
    </div>
</div>
<a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ asset("$file->url") }}">
    <!--begin::Image-->
    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-100px"
        style="background-image:url('{{ asset("$file->url") }}')">
    </div>
    <!--end::Image-->

    <!--begin::Action-->
    <div class="overlay-layer card-rounded  bg-opacity-25 shadow">
        <i class="bi bi-eye-fill text-hover-primary fs-2x"></i>
    </div>
    <!--end::Action-->
</a>
