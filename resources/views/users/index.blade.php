<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-6">
            <h3 class="card-data align-items-start flex-column">
                Liste des utilisateurs
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                data-bs-original-title="@lang('lang.add_new_user')">
                @php
                    echo modal_anchor(url('/users/form/user'), '<i class="fas fa-plus"></i>' . trans('lang.add_new_user'), ['title' => trans('lang.add_new_user'), 'class' => 'btn btn-sm btn-light-primary']);
                @endphp
            </div>
        </div>
    </div>
    
    <div class="card card-flush ">

        <div class="card-header mt-5">
            <div class="card-data flex-column">
                <h3 class="fw-bolder mb-1"></h3>
                <div class="fs-6 text-gray-400"></div>
            </div>
            <div class="card-toolbar my-1" data-select2-id="select2-data-159-jg33">
                <div class="filter-datatable">
                    {{-- @include('project.filters.filters-basic', ["inputs" => $basic_filter ,"filter_for" => "offerTable"]) --}}
                </div>
                <div class="me-3 my-2 ">
                    <div class="d-flex align-items-center position-relative my-1">
                        <input type="text" id="search_project" autocomplete="off"
                            class="form-control form-control-solid form-select-sm w-200px ps-9 "
                            placeholder="{{ trans('lang.search') }}">
                    </div>
                </div>
                <div class="me-3 my-2">
                    <a id="do-search-project" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default"><i
                            class="bi bi-search" style="width: 10px;"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="usersTable" class="table table-row-dashed align-middle  table-hover "></table>
        </div>
    </div>
   
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.usersTable = $("#usersTable").DataTable({
                    dom : "tirp",
                    ordering: true,
                    processing: true,
                    columns: [
                        {data: 'name',"title" :"Name","class":"text-left","orderable":true},
                        {data: 'email',"title" :"email","class":"text-left"},
                        {data: 'fonction',"title" :"Type","class":"text-left"},
                        {data: 'actions',"title" :"Actions","class":"text-left" ,"searchable":false,"orderable":false},
                    
                    ],
                    ajax: {
                        url: url("/users/data_list"),
                        data: function(data) {
                        
                        }
                    },
                });
                
                $('#search_project').on('keyup', function() {
                    dataTableInstance.usersTable.search(this.value).draw();
                });
                
                $('#do-search-project').on('click', function() {
                    dataTableInstance.usersTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
