@if ($project->estimate == "accepted" && $project->status->id == 3 && $for_user->is_client())
    <span class="badge badge-light-{{$project->status->class}} fw-bolder fs-8 px-2 py-1 ms-2"> Complétion de dossies</span>   
@elseif($project->status->id == 1 && $for_user->is_client())
    <span class="badge badge-light-{{$project->status->class}} fw-bolder fs-8 px-2 py-1 ms-2"> En cours traitement</span>   
@else
    @php
        $status = project_custom_status($project->status, $for_user);
    @endphp
    <span class="badge badge-light-{{$status->class}} fw-bolder fs-8 px-2 py-1 ms-2">{{ trans("lang.{$status->name}") }}</span>   
@endif