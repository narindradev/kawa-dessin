<x-base-layout>

    <div class="row">
        
        <div class="col-xxl-12" id="category-section">
            <div class="card card-xxl-stretch mb-3 mb-xl-1">
                <div class="card-header border-1 pt-1">
                    <div class="me-2 card-title align-items-start flex-column">
                        <span class="card-label  fs-3 mb-1"> @lang('lang.list_of_category') </span>

                        <div class="text-muted fs-7 fw-bold"> {{ $offer->name }}</div>
                    </div>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        data-bs-original-title="@lang('lang.add_category')">
                        @php
                            echo modal_anchor(url("/category/modal_form/$offer->id"), '<i class="fas fa-plus"></i>' . trans('lang.add_category'), ['title' => trans('lang.add_category'), 'class' => 'btn btn-sm btn-light-primary']);
                        @endphp
                    </div>
                </div>
                <div class="card-body py-5">
                    <table id="categoryTable" class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4 table-hover "></table>
                </div>
            </div>
        </div>
        <div class="col-xxl-5" id="questionnaire-section">

        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.categoryTable = $("#categoryTable").DataTable({
                    processing: true,
                    columns: [  
                        {title: 'id',"class":"text-left"},
                        {title: 'name',"class":"text-left"},
                        {title: 'Devi estimatif',"class":"text-left"},
                        {title: 'Affiché au formulaire du client',"class":"text-left"},
                        {title: 'description',"class":"text-left"},
                        {title: '<i class="fas fa-bars" style="font-size:20px"></i>',"orderable":false,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/category/data_list/{{ $offer->id }}"),
                    },

                });
            })
            // Questionnaire-section
            $('body').on('click', '[data-action=load-question]', function(e) {
                var $target = $(this)
                var url = $target.attr('data-action-url'),
                    id = $target.attr('data-id');
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#category-section").removeClass("col-xxl-12").addClass("col-xxl-7")
                            $("#questionnaire-section").html(result.html)
                        }
                    },
                    error: function(request, status, error) {
                        toastr.error("<span> Status : " + request.status + "MessageError : " + request
                            .responseJSON.message ? request.responseJSON.message : error + "File : " +
                            request.responseJSON.file + "Line : " + request.responseJSON.line +
                            " </span>");
                    }
                });
            })
        </script>
    @endsection
</x-base-layout>
