@php
$form = "project"; $target = $project_id;
if ($user_id) {
    $form = "private"; $target = $user_id;
}
@endphp
<div id="messages-list" class="scroll-y my-1" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px" style="height: 765px;">
    <form class="form message-chat" id="form-load-{{"$form"}}-id-{{"$target"}}" method="POST" action="{{ url("/message/load/more") }} ">
        <div class="d-flex flex-wrap flex-center ">
            @csrf
            <input type="hidden" name="offest" id="offest" value="{{ $per_page}}">
            <input type="hidden" name="loaded_more" id="loaded_more" value="0">
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
<form class="form" id="chat-form-{{$form}}-id-{{$target}}" method="POST" action="{{ url("/message/send") }} ">
    <div class="" id="kt_drawer_chat_messenger_footer">
        @csrf
        <input type="hidden" name="user_id"  value="{{ $user_id }}">
        <input type="hidden" name="project_id" value="{{ $project_id }}">
        <textarea class="form-control form-control-flush mb-1 message-chat-input" id="message-chat-input" data-rule-required="true" data-msg-required="@lang('lang.required_input')" name="message" data-kt-autosize="true" rows="2" placeholder="@lang("lang.write")" style="overflow: hidden; overflow-wrap: break-word; height: 50px;"></textarea>
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
        $("#chat-form-{{$form}}-id-{{ $target}}").appForm({
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
        $("#form-load-{{ $form }}-id-{{ $target }}").appForm({
            isModal: false,
            showAlertSuccess : false,
            onSuccess: function(response) {
                
                $("#offest").val(response.offest)
                $("#loaded_more").val("1")
                if (!response.has_more) {
                    $("#load-more").remove()
                }
                if (response.data) {
                    $(".message-chat:first").after(response.data)
                }
                return false;
            },
        })
        // $('#messages-list').on('scroll',function (e) {
        //     var elem = $(e.currentTarget);
        //     if (elem.offset().top ) {
        //         alert("sd");
                
        //     }
        //     if ((elem[0].scrollHeight + elem.scrollTop())  == elem.outerHeight()) {
        //         $("#loaded_more").val("0")
        //     }else{
        //         $("#loaded_more").val("1")
        //     }
        // });

        $(document).on('click', '.delete-message', function (e) {
            var target= $(this)
            var id = target.attr("data-message-id")
            var id_ = id.replace("me-","")
            var blockLoader = '<div  class="blockui-message"><span class="spinner-border text-primary"></span> ' + app_lang.please_wait + ' <span id ="upload-info"></span></div>'
            var blockToMask = document.querySelector("#message-item-"+ id_);
            var blockUI = new KTBlockUI(blockToMask, { message: blockLoader });
            blockUI.block();
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
                        $("#message-item-"+result.id).fadeOut("slow") 
                        setTimeout(() => {
                                $("#message-item-"+result.id).remove()
                        }, 100);
                    }
                    blockUI.release();
                },
                error: function (request, status, error) {
                    blockUI.release();
                    return toastr.error(status);
                }
                
            });
        })
    })
</script>