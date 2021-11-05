

@php
    $status = project_custom_status($project->status , $for_user);
@endphp
<span class="bullet bullet-vertical h-40px bg-{{$status->class}}"></span>