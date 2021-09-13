<x-base-layout>

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div id="kt_docs_jkanban_basic"></div>
        <div class="card-header border-0 pt-2">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label  fs-3 mb-1"> @lang('lang.list_of_project') </span>
            </h3>
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-body py-5">
            <button class="button">test</button>
            <input type="text" name="status_id" value=""  id ="status_id" class="filter">
            <input type="text" name="priority_id" value=""  id ="priority_id" class="filter">
            <input type="text" name="client_id" value=""  id ="client_id" class="filter">
            <table id="offerTable" class="table table-row-bordered  table-hover "></table>
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.offerTable = $("#offerTable").DataTable({
                    processing: true,
                    columns: [
                        {title: 'id',"class":"text-left"},
                        {title: 'client',"class":"text-left"},
                        {title: 'Type de project',"class":"text-left"},
                        {title: 'type de client',"class":"text-left"},
                      
                        {title: 'Date de creation',"orderable":true,"searchable":false,"class":"text-center"},
                        {title: 'Actions',"orderable":true,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/project/list"),
                        data: function(d) {
                            d.status_id = $("#status_id").val();
                            d.priority_id = $("#priority_id").val();
                            d.client_id = $("#client_id").val();
                        }
                    },
                }); 

                $('.button').on('click', function() {
                    dataTableInstance.offerTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
