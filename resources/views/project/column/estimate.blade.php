@php
    $price = $project->price ?? '0.00';
@endphp
<span  class="text-primary fw-bolder text-hover-primary d-block mb-1 fs-6">{{ format_to_currency($price) }}</span>

@if ($project->estimate && ($for_user->is_admin() || $for_user->is_commercial()))
    @php
        $class = 'success';
        if ($project->estimate == 'refused') {
            $class = 'danger';
        }
        $project_last_relaunch = '';
        if ($project->estimate == 'refused') {
            $project_last_relaunch = $relaunch->description;
            if ($last_relaunch->note) {
                $project_last_relaunch .= ' : ' . $last_relaunch->note;
            }
        }
    @endphp
    <span  class="badge badge-light-{{ $class }} fw-bolder fs-8 px-2  py-1 ms-2" @if ($project->estimate == 'refused')
        title="{{ $project_last_relaunch }}"
        data-bs-toggle="tooltip"
        data-bs-placement="bottom"
        data-bs-trigger="hover"
@endif>{{ trans("lang.$project->estimate") }}</span>
@endif
<script>
    $(document).ready(function() {
        KTApp.initBootstrapTooltips();
    })
</script>


