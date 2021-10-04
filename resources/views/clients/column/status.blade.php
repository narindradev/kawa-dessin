@if ($project->estimate == "accepted" && $project->status->id == 3 && auth()->user()->is_client())
    <span class="badge badge-light-{{$project->status->class}} fw-bolder fs-8 px-2 py-1 ms-2"> Complétion de dossies</span>   
@elseif($project->status->id == 1 && auth()->user()->is_client())
    <span class="badge badge-light-{{$project->status->class}} fw-bolder fs-8 px-2 py-1 ms-2"> En cours traitement</span>   
@else
    <span class="badge badge-light-{{$project->status->class}} fw-bolder fs-8 px-2 py-1 ms-2">{{ trans("lang.{$project->status->name}") }}</span>   
@endif