@php
    $count = $project->relaunchs()->whereRaw("NOT FIND_IN_SET('$for_user->id',seen_by)")->where("created_by","<>", $for_user->id)->get()->count();
    if ($count) {
        echo modal_anchor(url("/message/relaunch/$project->id"), '<i class="fab text-primary fa-facebook-messenger fa-lg"></i>'. '<span class="position-absolute top-0 start-100 translate-middle badge-sm badge badge-light-danger badge-circle">'.$count.'</span>' , ['class' => 'position-relative me-5', 'data-post-project_id' => $project->id , 'data-drawer' => true, 'title' => trans('lang.relaunch')]);
    }else {
        echo modal_anchor(url("/message/relaunch/$project->id"), '<i class="fab text-primary fa-facebook-messenger fa-lg"></i>' , ['class' => 'position-relative me-5', 'data-post-project_id' => $project->id , 'data-drawer' => true, 'title' => trans('lang.relaunch')]);
    }
@endphp
