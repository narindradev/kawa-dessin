@php
    $count = 0;
    if ($for_user->not_admin()) {
        if ($from_notification) {
            $count =  $project->messages()->whereRaw("NOT FIND_IN_SET('$for_user->id',seen_by)")->whereRaw("NOT FIND_IN_SET('$for_user->id',deleted_by)")->where("sender_id" ,"<>" ,"$for_user->id")->get()->count();
        }else {
            $count = $project->messages->count();
        }
    }
    $message_not_seen = $count ? "<span class='position-absolute top-0 start-100 translate-middle  badge badge-circle  badge-sm badge-light-danger' id='project_message_user_unread_$project->id'>".$count."</span>": "" ;
    echo modal_anchor(url("/message/chat"), '<i class="fab text-primary fa-facebook-messenger fa-lg"></i>'.$message_not_seen, ['class' => 'position-relative me-5', 'data-post-project_id' => $project->id , 'data-drawer' => true, 'title' => trans('lang.chat')]);
@endphp
