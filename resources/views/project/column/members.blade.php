<div class="d-flex symbol-group symbol-hover">
    @foreach ($members as  $user)
        <div class="symbol symbol-30px symbol-circle" data-bs-placement="bottom" data-bs-toggle="tooltip"  data-bs-original-title="{{$user['name'] ?? $user->name }}">
            <img alt="Pic" src="{{$user['avatar'] ?? $user->avatar_url }}">
        </div>
        @php
            echo modal_anchor(url("/message/chat"), '<i class="fab text-primary fa-facebook-messenger fa-lg"></i>', ['class' => 'position-relative me-5', 'data-post-user_id' => $user['id'] ?? $user->id , 'data-drawer' => true, 'title' => trans('lang.private_chat')]);
        @endphp
    @endforeach
    @if (isset($add) &&  ($for_user->is_mdp()) )
        {!!$add!!}
    @endif
</div>
<script>
    $(document).ready(function() {
       
        KTApp.initBootstrapTooltips();
    })
</script>