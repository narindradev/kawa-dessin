@php
    $status = project_custom_status($project->status , $for_user);
    $status_dropdown_html = "";
    // foreach ($status_drop as $s) {
        // $status_dropdown_html = view("project.column.statust")->render() ;//$status_dropdown_html . "<div><a href='/link'>- {$s["text"]}</a> </b></div></b>";
    // }
@endphp
<span type="button" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-bs-toggle="dropdown" class="badge badge-light-{{$project->status->class}}"> {{ trans("lang.{$status->name}") }} </span> 
{!! view("project.column.status-dropdown",["status_drop" => $status_drop , "project" => $project])->render() !!}
{{-- <div class="d-flex"> --}}
    {{-- <a type="button" id="status-project-{{$project->id}}" class="btn btn-sm btn-light-{{ $status->class }} py-1 px-2" tabindex="0" data-bs-trigger="click" data-bs-placement = "bottom" data-bs-dismiss="true" title="Dismissable popover"  data-bs-html="true" data-bs-content='{{ $status_dropdown_html }}'>
        @if ($project->status->name =="correction" &&  $project->correction)
            {!! project_correction_range($project) !!}
        @endif
        {{ trans("lang.{$status->name}") }} 
    </a> --}}
        &nbsp;
    {{-- <span class="badge-sm badge badge-light-{{$status->class}} fw-bolder">{{ trans("lang.{$status->name}") }}</span> &nbsp;   --}}
    {{-- <a class="btn-sm btn btn-light-{{$project->version == "APS" ? "danger" : "success"}}  py-1 px-2">{{ $project->version }}</a>    --}}
{{-- </div> --}}
{{-- <script>
    $(document).ready(function() {
        var exampleEl = document.getElementById('status-project-{{$project->id}}')
        var popover = new bootstrap.Popover(exampleEl ,{})
        KTApp.initBootstrapTooltips();
    });
</script> --}}