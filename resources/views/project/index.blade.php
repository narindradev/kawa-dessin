<x-base-layout>
    <div class="card card-xxl-stretch mb-3 mb-xl-8">
        <div class="card-header border-0 pt-7">
            <h3 class="card-data align-items-start flex-column">
                Liste des project
            </h3>
        </div>
    </div>
    @if (!auth()->user()->is_dessignator())
        <div class="card card-flush mb-3 ">
            @include('project.filters.users-tag' ,["users" => $users])
        </div>
    @endif
    <div class="card card-flush ">
        <div class="card-header mt-2">
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
                <div class="filter-datatable">
                </div>
                <div class="me-4 my-2 ">
                    <div class="d-flex align-items-center position-relative my-1">
                        <input type="text" id="search_project" autocomplete="off"
                            class="form-control form-control-solid form-select-sm w-200px ps-9 "
                            placeholder="{{ trans('lang.search') }}">
                    </div>
                </div>
                <div class="me-4 my-2">
                    <a id="do-search-project" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default">
                        <i class="bi bi-search" style="width: 10px;"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="table-responsive"> --}}
                <table id="projectsTable" class="table table-row-dashed align-middle "></table>
            {{-- </div> --}}
        </div>
    </div>
    <style>
        table.dataTable th{
            border-bottom-color:transparent;;
        }
        table.dataTable.table-row-dashed.DTFC_Cloned tbody tr:nth-of-type(odd) {
            background-color: #1E1E2D;
            border-right-color: transparent
        }
        table.dataTable.table-row-dashed.DTFC_Cloned tbody tr:nth-of-type(even) {
            background-color: #1E1E2D;
            border-right-color: transparent
        }
        table.dataTable.table-row-dashed.DTFC_Cloned thead th {
            background-color: #1E1E2D;
            border-right-color: transparent
        }
        div.dataTables_wrapper div.dataTables_info {
            padding-top: 0px !important;
        }
    </style>
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.projectsTable = $("#projectsTable").DataTable({
                    dom: 'ti rl',
                    paging: false,
                    processing:true,
                    ordering: false,
                    scrollY: 550,
                    scrollX:true,
                    // fixedColumns:   {
                    //     leftColumns: 2,
                    // },
                    columns: [
                        {data: 'badge',"title" :"","class":"text-left","orderable":false,"searchable":false},
                        {data: 'client_info',"title" :"Client","class":"text-left min-w-120px "},
                        {data: 'messenger',"title" :"","class":"text-left ","orderable":true,"searchable":false},
                        {data: 'categories',"title" :"Type","class":"text-center min-w-100px "},
                        @if (!auth()->user()->is_dessignator()) 
                            {data: 'client_type',"title" :"Type de client","class":"text-center min-w-100px"},
                        @endif
                       
                        {data: 'status',"title" :"Statut","orderable":true,"searchable":false,"class":"text-center"},
                        @if (auth()->user()->is_admin() || auth()->user()->is_commercial()) 
                            {data: 'estimate',"title" :"Prix","class":"text-center  min-w-100px"},
                            {data: 'estimate_price',"title" :"Devis en estimatif ","class":"text-center  min-w-100px"},
                        @endif

                        {data: 'version',"title" :"version","orderable":true,"searchable":false,"class":"text-center"},
                        @if (!auth()->user()->is_dessignator()) 
                            {data: 'commercial',"title" :"commercial","orderable":true,"searchable":false,"class":"text-center min-w-80px"},
                        @endif
                        {data: 'mdp',"title" :"mdp","orderable":true,"searchable":false,"class":"text-center  min-w-80px"},
                        {data: 'dessignator',"title" :"dessignator","orderable":true,"searchable":false,"class":"text-center min-w-80px"},

                        @if (auth()->user()->is_admin()) 
                            {data: 'invoice',"title" :"Facture","orderable":true,"searchable":false,"class":"text-center w-80px"},
                        @endif
                        {data: 'start_date',"title" :"Début    ","orderable":false,"searchable":true,"class":"text-center min-w-100px"},
                        {data: 'due_date',"title" :"Fin      ","orderable":false,"searchable":true,"class":"text-center min-w-100px"},
                        @if (!auth()->user()->is_dessignator()) 
                        {   data: 'delivery_date',"title" :"Livraison","orderable":false,"searchable":false,"class":"text-center min-w-100px"},
                        @endif

                        @if (auth()->user()->is_admin() || auth()->user()->is_commercial() ) 
                            {data: 'payment',"title" :"Paiment","orderable":true,"searchable":false,"class":"text-center min-w-100px"},
                        @endif
                        @if (!auth()->user()->is_dessignator()) 
                            {data: 'date',"title" :"Creation","orderable":true,"searchable":false,"class":"text-center min-w-100px"},
                        @endif

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
                $('#do-search-project').on('click', function(e) {
                    dataTableInstance.projectsTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
