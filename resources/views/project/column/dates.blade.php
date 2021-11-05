
@php
        $due_date = $project->due_date;
        if($due_date && $project->due_date->isToday()){
            $due_date = $project->due_date->format("d-M");
            $due_date ="<span class ='text-danger'>$due_date<span>";
        }
        if($project->start_date && $project->due_date){
            $date= $project->start_date->format("d-M") ." -> ". $due_date;
        }else{
            if(!$project->start_date && $project->due_date) {
                $date = $project->start_date->format("d-M") ." -> ". " - ";
            }
            if($project->start_date && !$project->due_date) {
                $date = "- " ." -> ".$due_date;
            }
            if(!$project->start_date && !$project->due_date) {
                $date = " - ";
            }
        }

@endphp

<div class="d-flex align-items-center flex-column"> 12-nov-2121 -> 12-nov-2121 </div>