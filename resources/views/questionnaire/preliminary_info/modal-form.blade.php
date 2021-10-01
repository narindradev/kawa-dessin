<div class="card card-custom ">
    <form class="form" id="question-form" method="POST" action="{{ "/questionnaire/preliminary_info/store" }}">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <div class="mb-10">
                    <label for="question" class="form-label">@lang('lang.question')</label>
                    <textarea id="question"  data-kt-autosize="true" name="question" autocomplete="off" class="form-control form-control-solid" rows="2"
                        placeholder=" ... " data-rule-required="true" data-msg-required="@lang('lang.required_input')">{{ $question->question ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 "> @lang('lang.cancel')</button>
                <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                    @include('partials.general._button-indicator', ['label' => trans('lang.save') , "message" => trans("lang.sending")])
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#question-form").appForm({
            onSuccess: function(response) {
                dataTableInstance.questTable.ajax.reload();

            },
        })
    })
</script>
