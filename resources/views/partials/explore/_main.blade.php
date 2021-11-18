<!--begin::Exolore drawer toggle-->
@if (auth()->user()->not_client())
<a id="private-chat" class="btn btn-sm  position-fixed  zindex-2 top-75 mt-50 end-0 transform-90 fs-6 me-2">
    @php
        $users = get_cache_chat_user();
    @endphp
    @foreach ($users as $user)
        <span id="private-chat-user-{{  $user->id }}" class="">
            <div class="symbol symbol-35px symbol-circle" 
                style="transform: rotate(279deg) " 
                data-bs-placement="bottom"
                data-bs-toggle="tooltip" 
                data-bs-original-title="{{  $user->name }}"
                data-post-user_id="{{ $user->id }}"
                data-drawer=true
                data-act="ajax-drawer"
                data-title="@lang('lang.private_chat')"
                data-action-url="{{ url("/message/chat")}}">
                <img alt="Pic" src="{{ $user->avatar_url }}">
                @if($user->message_not_seen)
                    <span id="chat-private-id-notfication-count-{{ $user->id }}"  class="position-absolute top-0 start-100 translate-middle  badge badge-circle  badge-sm badge-light-info ">{{$user->message_not_seen}}</span>
                @else
                    <span id="chat-private-id-notfication-count-{{ $user->id }}" style="display: none" class="position-absolute top-0 start-100 translate-middle  badge badge-circle  badge-sm badge-light-info "></span>
                @endif
            </div>
        </span>
    @endforeach
</a>
@endif