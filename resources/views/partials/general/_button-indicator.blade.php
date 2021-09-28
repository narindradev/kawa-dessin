@php
    $label = $label ?? trans('lang.save');
    $message = $message ?? trans('lang.please_wait');
@endphp

<!--begin::Indicator-->
<span class="indicator-label">
    {!! $label !!}
</span>
<span class="indicator-progress">
    {{ $message }}
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
<!--end::Indicator-->
