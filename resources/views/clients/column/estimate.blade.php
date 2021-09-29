@php
    $price = "$" . $project->price ?? '0.00';
@endphp
@if($project->price && $project->status_id == 3)
    @php
        // echo modal_anchor(url("/estimate/validation/$project->id"), "$price ??", ['class' => 'text-primary fw-bolder text-hover-primary d-block mb-1 fs-6', 'data-drawer' => true, 'title' => trans('lang.estimate_etude')]);
    @endphp
    <a href="{{ url("/project/detail/$project->id") }}"class="text-primary fw-bolder text-hover-primary d-block mb-1 fs-6"> {{ $price }} </a>
   
@else
    <a href="#" class="text-primary fw-bolder text-hover-primary d-block mb-1 fs-6"> {{ $price }} </a>
@endif
    <span class="text-muted fw-bold text-muted d-block fs-7">Non payé</span>
