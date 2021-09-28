<x-base-layout>
    <div class="card card-xxl-stretch  mb-xl-8">
    <div class="card-header border-1 pt-2">
        <div class="me-2 card-title align-items-start flex-column">
            <span class="card-label  fs-3 mb-1">  @lang('lang.list_question')  </span>

        </div>
        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
            data-bs-original-title="@lang('lang.add_question')">
            @php
                echo modal_anchor(url("/questionnaire/preliminary/modal_form"), '<i class="fas fa-plus"></i>', ['title' => trans('lang.add_question'), 'class' => 'btn btn-sm btn-light-primary']);
            @endphp
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-body py-5">
            <table id="questionsTable" class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4 table-hover "></table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        dataTableInstance.questTable = $("#questionsTable").DataTable({
            processing: true,
            columns: [
                {title: 'Questions',"class": "text-left","orderable": false},
                {title: '-',"orderable": false,"searchable": false,"class": "dt-body-right"},
            ],
            ajax: {
                url: url("/questionnaire/preliminary_info/data_list"),
            },
        });
    })
</script>
</x-base-layout>
