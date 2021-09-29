<div class="card card-custom ">
    <div class="fv-row mb-0 fv-plugins-icon-container">
        <form id="refuse-form-estimate" method="POST" action="{{ url("/project/estimate/save_refuse/$project->id") }}">
            @csrf
            <div class="mb-3">
                <label class="form-label required ">@lang('lang.reason')</label>
                <div class="input-group">
                    <select name="reason" data-rule-required="true" data-hide-search="true"
                        data-msg-required="@lang('lang.required_input')" class="form-select form-select-solid"
                        data-control="select2" data-placeholder="@lang('lang.subject')">
                        <option value="0" disabled selected>-- @lang('lang.reason') --</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ get_array_value($subject, 'value') }}"> {{ get_array_value($subject, 'text') }}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="mb-3">
                    <label class="form-label">@lang('lang.note')</label>
                    <textarea id="note" data-kt-autosize="true" name="note" placeholder="@lang('lang.note')"
                        class="form-control  form-control-solid" rows="2"></textarea>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                    class="btn btn-light-light btn-sm mr-2 "> @lang('lang.cancel')</button>
                <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                    @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" => trans('lang.sending')])
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        KTApp.initAutosize();
        KTApp.initBootstrapTooltips();
        $("#refuse-form-estimate").appForm({
            onSuccess: function(response) {
                if (response.project) {

                }
            },
        })
    })
</script>
