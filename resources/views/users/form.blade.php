<div class="card card-custom ">
    <form class="form" id="users-form" method="POST" action="{{ "/users/create/user"}}"
        enctype="multipart/form-data">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <div class="mb-10">
                    <label for="first_name" class="required form-label">@lang('lang.first_name')</label>
                    <input type="text" value="{{ "" }}" autocomplete="off" name="first_name"
                        class="form-control form-control-solid" placeholder="@lang('lang.first_name')" data-rule-required="true"
                        data-msg-required="@lang('lang.required_input')" />
                </div>
            </div>
            <div class="form-group">
                <div class="mb-10">
                    <label for="last_name" class="form-label">@lang('lang.last_name')</label>
                    <input type="text" value="{{ "" }}" autocomplete="off" name="last_name"
                        class="form-control form-control-solid" placeholder="@lang('lang.last_name')"  />
                </div>
            </div>
            <div class="form-group">
                <div class="mb-10">
                    <label for="email" class="required form-label">@lang('lang.email')</label>
                    <input type="text" value="{{ "" }}" autocomplete="off" name="email"
                        class="form-control form-control-solid" placeholder="@lang('lang.email')"  data-rule-required="true"
                        data-msg-required="@lang('lang.required_input')" data-rule-email="true" data-msg-email="@lang('lang.required_input_type_email')" />
                </div>
            </div>
            <div class="form-group">
                <div class="mb-10">
                    <label for="function" class="required form-label">@lang('lang.function')</label>
                    <div class="input-group">
                        <select name="user_type_id" data-dropdown-parent="#ajax-modal" data-rule-required="true" data-hide-search="true" data-msg-required="@lang('lang.required_input')" class="form-select  form-select-solid" data-control="select2" data-placeholder="@lang('lang.function')">
                            <option value="0" disabled selected>-- @lang('lang.function') --</option>
                            @foreach ($user_type as $type)
                                <option value="{{ get_array_value($type ,"value")}}" >{{ get_array_value($type ,"text")}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 ">
                @lang('lang.cancel')</button>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" =>
                trans("lang.sending")])
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        $("#users-form").appForm({
            onSuccess: function(response) {
                dataTableaddRowIntheTop(dataTableInstance.usersTable,response.data)
            },
        })
    })
</script>
