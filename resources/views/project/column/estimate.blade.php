<a href="#" class="text-primary fw-bolder text-hover-primary d-block mb-1 fs-6">$ {{ $project->price ?? "0.00" }}</a>
@if ($project->estimate)
@php
    $class ="text-muted fw-bold text-muted d-block fs-7";
    if($project->estimate == "refused"){
        $class ="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2 ";
    }
@endphp
<span  href="#" class="badge badge-light-danger fw-bolder fs-8 px-2  py-1 ms-2" title="Motif de refuse" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="click">{{ trans("lang.$project->estimate") }}</span>
@endif
<script>
    $(document).ready(function() {
        KTApp.initBootstrapTooltips();
    })
</script>