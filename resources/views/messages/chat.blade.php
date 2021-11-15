<div id="messages-list" class="scroll-y my-1" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px" style="height: 765px;">
    <form class="form message-chat" id="form-load-{{"project-id-$project_id"}}" method="POST" action="{{ url("/message/load/more") }} ">
        <div class="d-flex flex-wrap flex-center ">
            @csrf
            <input type="hidden" name="offest" id="offest" value="{{ $per_page}}">
            <input type="hidden" name="project_id"  value="{{ $project_id }}">
            <input type="hidden" name="user_id"  value="{{ $user_id }}">
            <button type="submit" class="btn-sm btn btn-light " id="load-more">
                @include('partials.general._button-indicator', ['label' => trans('lang.show_more'),"message" => trans('lang.loading')])
            </button>
        </div>
    </form>
    @foreach ($messages as $message)
        {!! view("messages.item" ,["message" => $message ,"my_message" => ($message->sender_id == $auth->id) ,"for_user" => $auth ])->render() !!}
    @endforeach
</div>
<form class="form" id="chat-form-{{"project-id-$project_id"}}" method="POST" action="{{ url("/message/send") }} ">
    <div class="card-footer " id="kt_drawer_chat_messenger_footer">
        @csrf
        <input type="hidden" name="user_id"  value="{{ $user_id }}">
        <input type="hidden" name="project_id" value="{{ $project_id }}">
        <textarea class="form-control form-control-flush mb-1 message-chat-input" id="message-chat-input" data-rule-required="true" data-msg-required="@lang('lang.required_input')" name="message" data-kt-autosize="true" rows="2" placeholder="Ecrivez ..." style="overflow: hidden; overflow-wrap: break-word; height: 50px;"></textarea>
        <div class="separator my-1"></div>
        <div class="d-flex flex-stack  ">
            <div class="d-flex align-items-center mt-2">
                <input class="form-control form-control-sm form-control-white message-chat-input" name="files[]" type="file" id="message-file-input" multiple>
            </div>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  ">
                @include('partials.general._button-indicator', ['label' => trans('lang.send'),"message" => "..."])
            </button>
        </div>
    </div>
</form>
<style>
    .action-message{
        opacity: 0;
    }
    .action-message:hover{
        opacity: 30;
    }
</style>
<script>
    $(document).ready(function() {
        var messages = "#messages-list"
        setTimeout(() => {
            $("#message-chat-input").focus()
        }, 200);
        scrollBotton(messages , 3000)
        $("#chat-form-project-id-{{ $project_id}}").appForm({
            forceBlock: true,
            onSuccess: function(response) {
                $("#message-chat-input").val("")
                $("#message-file-input").val("")
                if ( $(".message-item").length) {
                    $(".message-item:last").after(response.data)
                }else{
                    $(messages).html(response.data)
                }
                setTimeout(() => {
                    scrollBotton(messages,3000)
                }, 200);
            },
        })
        $("#form-load-project-id-{{ $project_id}}").appForm({
            isModal: false,
            onSuccess: function(response) {
                console.log(response);
                $("#offest").val(response.offest)
                if (!response.has_more) {
                    $("#load-more").remove()
                }
                if (response.data) {
                    $(".message-chat:first").after(response.data)
                }
                return false;
            },
        })
        $(".delete-message").on("click",function(){
            var target= $(this)
            var id = target.attr("data-message-id")
            $.ajax({
                url: url("/message/set/delete"),
                type: 'POST',
                dataType: 'json',
                data: {
                    id:id,
                    _token: _token
                },
                success: function(result) {
                    if (result.success) {
                        target.remove() 
                        $("#message-item-"+result.id).fadeOut("slow" ,function(){
                            setTimeout(() => {
                                $("#message-item-"+result.id).remove()
                            }, 0.5);
                        }) 
                    }
                },
            });
        })
    })
</script>