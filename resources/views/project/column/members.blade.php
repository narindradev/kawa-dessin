<div class="d-flex symbol-group symbol-hover">
    @foreach ($members as  $user)
        <div class="symbol symbol-30px symbol-circle" data-bs-placement="bottom" data-bs-toggle="tooltip"  data-bs-original-title="{{$user['name']}}">
            <img alt="Pic" src="{{$user['avatar']}}">
        </div>
    @endforeach
    @if (isset($add) &&  ($for_user->is_mdp()) )
        {!!$add!!}
    @endif
</div>