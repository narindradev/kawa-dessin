<div class="card card-custom ">
    <form class="form" id="estimate-form" method="POST" action="{{ "/project/estimate/add/$project->id" }}"
        enctype="multipart/form-data">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <div class="mb-10">
                    <label for="estimate" class="required form-label">@lang('lang.estimate')</label>
                    <input type="text" autocomplete="off" name="devis" class="form-control form-control-solid"
                        placeholder="@lang('lang.estimate')" data-rule-required="true"
                        data-msg-required="@lang('lang.required_input')" />
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 ">
                @lang('lang.cancel')</button>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" => trans("lang.sending")])
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#estimate-form").appForm({
            onSuccess: function(response) {
                if (response.project) {
                    dataTableUpdateRow(dataTableInstance.projectsTable, response.row_id, response.project)
                }
            },
        })
    })
</script>
