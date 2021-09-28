<div class="card card-xxl-stretch mb-5 mb-xl-8">
    <div class="card-header border-1 pt-2">
        <div class="me-2 card-title align-items-start flex-column">
            <span class="card-label  fs-3 mb-1">  @lang('lang.list_question')  </span>

            <div class="text-muted fs-7 fw-bold"> {{ $category->name }}</div>
        </div>
        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
            data-bs-original-title="@lang('lang.add_question')">
            @php
                echo modal_anchor(url("/questionnaire/modal_form/$category->id/$question->id"), '<i class="fas fa-plus"></i>', ['title' => trans('lang.add_question'), 'class' => 'btn btn-sm btn-light-primary']);
            @endphp
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-body py-5">
            <table id="questTable" class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4 table-hover "></table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        dataTableInstance.questTable = $("#questTable").DataTable({
            dom : "ftp",
            processing: true,
            columns: [
                {title: '',"class": "text-left","orderable": false},
                {title: '',"orderable": false,"searchable": false,"class": "dt-body-right"},
            ],
            ajax: {
                url: url("/questionnaire/data_list/{{ $category->id }}"),
            },
        });
    })
</script>
