<div class="fv-row mb-0 fv-plugins-icon-container">
    <form id="relaunch-form" method="POST" action="{{ url("/project/relaunch/add/$project->id") }}">
        @csrf
        <div class="mb-3">
            <div class="input-group">
                <label class="form-label required ">@lang('lang.subject')</label>
                <select name="subject" data-rule-required="true" data-hide-search="true"
                    data-msg-required="@lang('lang.required_input')" class="form-select  form-select-solid"
                    data-control="select2" data-placeholder="@lang('lang.subject')">
                    <option value="0" disabled selected>-- @lang('lang.subject') --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ get_array_value($subject, 'value') }}">
                            {{ get_array_value($subject, 'text') }}</option>
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
        <div class="text-right">
            <button type="submit" id="submit" class="btn btn-sm btn-light-primary mr-2 ">
                @include('partials.general._button-indicator', ['label' => trans('lang.note_it').' <i
                    class="fas fa-check"></i>',"message" => trans("lang.sending")])
            </button>
        </div>
    </form>
</div>

<div class="table-responsive">
    <table id="relaunchTable" class="table table-row-dashed"></table>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        KTApp.initAutosize();
        dataTableInstance.relaunchTable = $("#relaunchTable").DataTable({
            dom: "t",
            ordering: false,
            columns: [
                {data: 'subjet',"title" :"Sujet","class":"text-left text-gray-400 fw-bolder","searchable":false},
                {data: 'note',"title" :"Note","class":"text-left text-gray-400 fw-bolder"},
                {data: 'date',"title" :"","class":"text-left searchable text-gray-400 fw-bolder","searchable":false},
                {data: 'created_by',"title" :"Par","class":"text-left text-gray-400 fw-bolder"},
                {data: 'status',"title" :"","class":"text-left text-gray-400 fw-bolder"},
            ],
            ajax: {
                url: url("/project/relaunch/list/{{$project->id }}"),
            },
        })
        $("#relaunch-form").appForm({
            isModal: false,
            onSuccess: function(response) {
                console.log(response.relaunch)
                $("#note").val("")
                dataTableaddRowIntheTop(dataTableInstance.relaunchTable ,response.relaunch )
            },
        })
    })
</script>
@endsection

