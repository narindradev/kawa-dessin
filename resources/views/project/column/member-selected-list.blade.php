
    @if($is_member)
        {!! js_anchor('<i class="text-hover-primary fas fa-user-minus" style="font-size:15px" ></i>', ["data-post-project_id"=>$project_id,"data-post-user_id"=>$user->id, "data-action-url" => url("/project_member/delete"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"]) !!}
    @else
    <div class="form-check form-check-custom form-check-solid ">
        <input class="form-check-input mx-5 user-item" type="checkbox" name="user_ids[]" value="{{$user->id}}"/>
        <input type="hidden" name="project_id" value="{{$project_id}}">
    </div>
    @endif
