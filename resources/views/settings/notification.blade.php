<form class="form" id="notification-setting-form" method="POST"
    action="{{ '/app/setting/notification/save' }}">
    @csrf
    <div class="form-group">
        <div class="mb-4">
            <label for="sender_mail" class="required form-label">@lang('lang.sender_mail') (Address email )</label>
            <input type="text" value="{{ app_setting('sender_mail') }}" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" data-rule-email="true"
                data-msg-email="@lang('lang.required_input_type_email')" autocomplete="off" name="sender_mail"
                class="form-control form-control-solid" placeholder="info@gmail.com" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" />
        </div>
        <div class="mb-4">
            <label for="mail_password" class="required form-label">@lang('lang.mail_password') </label>
            <input type="text" value="{{ app_setting('mail_password') }}" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" 
                name="mail_password" class="form-control form-control-solid" placeholder="@lang('lang.mail_password') email expediteur"/>
        </div>
    </div>
    <div class="form-group">
        <div class="mb-4">
            <label for="sender_name" class="required form-label">@lang('lang.sender_name')</label>
            <input type="text" value="{{ app_setting('sender_name') ?? app_setting('app_name') }}" autocomplete="off"
                name="sender_name" class="form-control form-control-solid" placeholder="@lang('lang.sender_name')" />
        </div>
    </div>
    <div class="form-group">
        <div class="mb-4">
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-20px w-30px" type="checkbox"  name = "test_email" value="1" id="test_email"/>
                <label class="form-check-label" for="test_email">
                   Test un envoi mail
                </label>
            </div>
        </div>
    </div>
    <div class="form-group" style="display: none" id="test_to">
        <div class="mb-3">
            <label for="test_to" class=" form-label">Envoyer à</label>
            <input type="text"  data-rule-required="false"
            data-msg-required="@lang('lang.required_input')"  data-rule-email="true"
            data-msg-email="@lang('lang.required_input_type_email')" autocomplete="off" name="test_to" id="to"  class="form-control form-control-solid" placeholder="email-exist@gmail.com" />
        </div>
    </div>
    <div class="separator mb-2"></div>
    <div class="form-group">
        <div class="mb-4">
            <label for="nexmo_sender" class=" form-label">SMS</label>
            <input type="text" value="{{ app_setting('nexmo_sender')}}" autocomplete="off" name="nexmo_sender" class="form-control form-control-solid" placeholder="+201096422454" />
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit"  class=" btn btn-sm btn-light-primary  mr-2">
            @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" =>
            trans("lang.sending")])
        </button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#notification-setting-form").appForm({
            isModal: false,
            onSuccess: function(response) {
                console.log(response)
              if (response.type == "test") {
                  if (!response.success) {
                    toastr.error(response.message);
                  }
              }
            },
        })
        var mail_cc = document.querySelector("#mail_cc");
        new Tagify(mail_cc, {
            maxTags: 5,
        });
        $("#test_email").on("click" ,function(){
            if ($(this).is(':checked')) {
                $("#test_to").css("display","")
                $("#to").attr("data-rule-required",true)
                
            }else{
                $("#test_to").css("display","none")
                $("#to").attr("data-rule-required",false)
            }
        })
    })
</script>
