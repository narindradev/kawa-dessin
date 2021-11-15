@php
    $class = $my_message ? "primary" :"info";
    $position = $my_message ? "end" :"start";
    $date= $message->created_at->isToday() ? $message->created_at->diffForHumans() :  $message->created_at->format("d-m-Y H:m")
@endphp
<div  id="message-item-{{ $message->id }}" class="message-item d-flex justify-content-{{ $position }} mb-3 mt-3 me-2  ">
    <div class="d-flex flex-column align-items-{{ $position }}">
        <div class="d-flex align-items-center mb-0">
            <div class="me-1">
                <span class="text-muted fs-4 mb-0"> <i>{{ $date }}</i></span>
                <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1"> <u>{{ $my_message ? "" : "{$message->sender->name}" }}</u>  </a>
            </div>
            @if (!$my_message)
                <div class="symbol symbol-35px symbol-circle mb-1">
                    <img alt="Pic" src="https://i.pravatar.cc/80?img={{$message->sender->id}}">
                </div>
            @endif
        </div>
        <div class="p-5 rounded bg-light-{{$class}} text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">
            {{ $message->content }} 
        </div>
        {!! view("messages.action",["message" => $message ,"for_user" =>  $for_user ,"my_message" => $my_message])->render() !!}
        @if($message->files_info)
            @foreach ($message->files_info as $file)
                {!! view("messages.file",["file" => $file ,"for_user" =>  $for_user])->render() !!}
            @endforeach
        @endif
    </div>
</div>
{{-- Mark as seen a message --}}
@if (isset($from_notification) || ( !$my_message  && !in_array($for_user->id, explode(",",$message->seen)) ) )
    <script id="script-set-seen-{{$message->id}}">
        $(document).ready(function(){
            $.ajax({
                url: url("/message/set/seen"),
                type: 'POST',
                dataType: 'json',
                data: {
                    id:"{{ $message->id }}",
                    _token: _token
                },
                success: function(result) {
                    if (result.success) {
                        $("#script-set-seen-{{$message->id}}").remove() // remove this script for to not execute secondly
                    }
                },
            });
        })
    </script>
@endif