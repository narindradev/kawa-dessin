<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-6">
            <h3 class="card-data align-items-start flex-column">
                Liste des project
            </h3>
        </div>
    </div>

    {{-- <div class="card card-flush mb-3 ">
        @include('project.filters.users-tag' ,["users" => $users])
    </div> --}}

    <div class="card card-flush ">

        <div class="card-header mt-5">
            <div class="card-data flex-column">
                <h3 class="fw-bolder mb-1"></h3>
                <div class="fs-6 text-gray-400"></div>
            </div>
            <div class="card-toolbar my-1" data-select2-id="select2-data-159-jg33">
                <div class="me-4 my-1">
                    {{-- @include('project.filters.filters-advanced' ,["inputs" => $advance_filter]) --}}
                </div>
                <div class="filter-datatable">
                    @include('project.filters.filters-basic', ["inputs" => $basic_filter ,"filter_for" => "offerTable"])
                </div>
                <div class="me-4 my-2 ">
                    <div class="d-flex align-items-center position-relative my-1">
                        <input type="text" id="search_project" autocomplete="off"
                            class="form-control form-control-solid form-select-sm w-200px ps-9 "
                            placeholder="{{ trans('lang.search') }}">
                    </div>
                </div>
                <div class="me-4 my-2">
                    <a id="do-search-project" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default"><i
                            class="bi bi-search" style="width: 10px;"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="projectsTable" class="table table-row-dashed align-middle  table-hover"></table>
        </div>
    </div>
   
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.projectsTable = $("#projectsTable").DataTable({
                    dom : 'tir',
                    processing: true,
                    columns: [
                        {data: 'badge',"title" :"","class":"text-left","orderable":false,"searchable":false},
                        {data: 'client_info',"title" :"Client","class":"text-left"},
                        {data: 'messenger',"title" :"","class":"text-left","orderable":true,"searchable":false},
                        {data: 'categories',"title" :"Type","class":"text-left" ,},
                        {data: 'client_type',"title" :"Type de client","class":"text-left"},
                        {data: 'status',"title" :"Statut","orderable":true,"searchable":false,"class":"text-center"},
                        {data: 'estimate',"title" :"Prix","class":"text-left", },
                        {data: 'version',"title" :"version","orderable":true,"searchable":false,"class":"text-center w-2"},
                        {data: 'date',"title" :"Creation","orderable":true,"searchable":false,"class":"text-center"},
                        {data: 'actions',"title" :"Actions","orderable":false,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/project/list"),
                        data: function(data) {
                            
                            <?php foreach(inputs_filter_datatable($basic_filter) as $input ) { ?>
                                data.{{ $input }} = $("#{{ $input }}").val();
                            <?php } ?>
                            data.user_id = $("#user_id").val();
                        }
                    },
                });
                
                $('#search_project').on('keyup', function() {
                    dataTableInstance.projectsTable.search(this.value).draw();
                });
                
                $('#do-search-project').on('click', function() {
                    dataTableInstance.projectsTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
