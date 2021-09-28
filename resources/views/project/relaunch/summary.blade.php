<div class="fv-row mb-0 fv-plugins-icon-container">
    <form id="relaunch-form" method="POST" action="{{ '/project/relaunch/add' }}">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <div class="mb-3">
        <div class="input-group">
            <label class="form-label required ">@lang('lang.subject')</label>
            <select name="subject"  data-rule-required="true" data-hide-search="true" data-msg-required="@lang('lang.required_input')" class="form-select  form-select-solid" data-control="select2" data-placeholder="@lang('lang.subject')">
                <option value="0" disabled selected>-- @lang('lang.subject') --</option>
                @foreach ($subjects as $subject)
                    <option value="{{ get_array_value($subject ,"value")}}" >{{ get_array_value($subject ,"text")}}</option>
                @endforeach
            </select>
        </div>
    </div>
        <div class="form-group">
            <div class="mb-3">
                <label class="form-label">@lang('lang.note')</label>
                <textarea  id="note" data-kt-autosize="true" name="note" placeholder="@lang('lang.note')" class="form-control  form-control-solid" rows="2"></textarea>
            </div>
        </div>
    <div class="text-right">
        <button type="submit" id="submit" class="btn btn-sm btn-light-primary mr-2 ">
            @include('partials.general._button-indicator', ['label' => trans('lang.note_it').' <i class="fas fa-check"></i>',"message" => trans("lang.sending")])
        </button>
    </div>
    </form>
</div>
<div class="separator my-3"></div>
<div class="table-responsive">
    <table id="relaunchTable" class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
        <thead>
            <tr class="border-0">
                <th class="p-0 w-100px text-primary">Les dermier relance</th>
                <th class="p-0 w-10px"></th>
                <th class="p-0 w-10px "></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p href="#" class="text-dark fw-bolder ">Accord du devis finale</p>
                    <span class="text-muted fw-bold d-block">Appel </span>
                </td>
                <td class="text-end text-muted fw-bold">
                    <span class="text-muted fw-bold d-block">il y a 1 h </span>
                </td>
                <td class="text-end">
                    <i class="fas fa-check text-success"></i>
                </td>
            </tr>
            <tr>
                <td>
                    <p href="#" class="text-dark fw-bolder ">Paiment pour 1èr tranche</p>
                    <span class="text-muted fw-bold d-block">Appel </span>
                </td>
                <td class="text-end text-muted fw-bold">
                    <span class="text-muted fw-bold d-block">il y a 2 h </span>
                </td>
                <td class="text-end">
                    <i class="fas fa-check text-success"></i>
                </td>
            </tr>
            <tr>
                <td>
                    <p href="#" class="text-dark fw-bolder ">Appel pour le devis finale</p>
                    <span class="text-muted fw-bold d-block">Appel </span>
                </td>
                <td class="text-end text-muted fw-bold">
                    <span class="text-muted fw-bold d-block">il y a 3 h </span>
                </td>
                <td class="text-end">
                    <i class="fas fa-check text-success"></i>
                </td>
            </tr>
        </tbody>
    </table>
</div>

    
<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        KTApp.initAutosize();
        dataTableInstance.relaunchTable = $("#relaunchTable").DataTable({
            dom: "t"
        })
        $("#relaunch-form").appForm({
            isModal: false,
            onSuccess: function(response) {
                $("#note").val("")
                dataTableInstance.relaunchTable.row().data(response.data);
                
            },
        })
    })
</script>

