<x-base-layout>
    <div class="card card-xxl-stretch mb-3 mb-xl-8">
        <div class="card-header border-0 pt-7">
            <h3 class="card-data align-items-start flex-column">
                Liste des project
                <div class="btn-group mb-10">
                    <a href="javascript:;" id="btPause" class="btn btn-outline-secondary">Pause</a>
                    <a href="javascript:;" id="btResume" class="btn btn-outline-secondary">Resume</a>
                    <a href="javascript:;" id="btElapsed" class="btn btn-outline-secondary">Elapsed</a>
                    <a href="javascript:;" id="btInit" class="btn btn-outline-secondary">Init</a>
                    <a href="javascript:;" id="btDestroy" class="btn btn-outline-secondary">Destroy</a>
                </div>
                <textarea rows="10" cols="30" id="docStatus" class="form-control"></textarea><br />
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
        /* table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
            background-color: #3f3f47;
        } */
    </style>
    @section('scripts')
        <script>
            $(document).ready(function() {
                $(function() {
    // binds to document - shorthand
                $.idleTimer();

    // binds to document - explicit
            $( document ).idleTimer();

    // bind to different element
         $("#docStatus").idleTimer();
        });
        var docTimeout = 5000;

        /*
        Handle raised idle/active events
        */
        $(document).on("idle.idleTimer", function(event, elem, obj) {
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Idle @ " + moment().format() + " \n";
                })
                .removeClass("alert-success")
                .addClass("alert-warning")
                .scrollTop($("#docStatus")[0].scrollHeight);
        });
        $(document).on("active.idleTimer", function(event, elem, obj, e) {
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Active [" + e.type + "] [" + e.target.nodeName + "] @ " + moment().format() + " \n";
                })
                .addClass("alert-success")
                .removeClass("alert-warning")
                .scrollTop($("#docStatus")[0].scrollHeight);
        });

        /*
        Handle button events
        */
        $("#btPause").click(function() {
            $(document).idleTimer("pause");
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Paused @ " + moment().format() + " \n";
                })
                .scrollTop($("#docStatus")[0].scrollHeight);
            $(this).blur();
            return false;
        });
        $("#btResume").click(function() {
            $(document).idleTimer("resume");
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Resumed @ " + moment().format() + " \n";
                })
                .scrollTop($("#docStatus")[0].scrollHeight);
            $(this).blur();
            return false;
        });
        $("#btElapsed").click(function() {
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Elapsed (since becoming active): " + $(document).idleTimer("getElapsedTime") + " \n";
                })
                .scrollTop($("#docStatus")[0].scrollHeight);
            $(this).blur();
            return false;
        });
        $("#btDestroy").click(function() {
            $(document).idleTimer("destroy");
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Destroyed: @ " + moment().format() + " \n";
                })
                .removeClass("alert-success")
                .removeClass("alert-warning")
                .scrollTop($("#docStatus")[0].scrollHeight);
            $(this).blur();
            return false;
        });
        $("#btInit").click(function() {
            // for demo purposes show init with just object
            $(document).idleTimer({
                timeout: docTimeout
            });
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Init: @ " + moment().format() + " \n";
                })
                .scrollTop($("#docStatus")[0].scrollHeight);

            //Apply classes for default state
            if ($(document).idleTimer("isIdle")) {
                $("#docStatus")
                    .removeClass("alert-success")
                    .addClass("alert-warning");
            } else {
                $("#docStatus")
                    .addClass("alert-success")
                    .removeClass("alert-warning");
            }
            $(this).blur();
            return false;
        });

        //Clear old statuses
        $("#docStatus").val("");

        //Start timeout, passing no options
        //Same as $.idleTimer(docTimeout, docOptions);
        $(document).idleTimer(docTimeout);

        //For demo purposes, style based on initial state
        if ($(document).idleTimer("isIdle")) {
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Initial Idle State @ " + moment().format() + " \n";
                })
                .removeClass("alert-success")
                .addClass("alert-warning")
                .scrollTop($("#docStatus")[0].scrollHeight);
        } else {
            $("#docStatus")
                .val(function(i, v) {
                    return v + "Initial Active State @ " + moment().format() + " \n";
                })
                .addClass("alert-success")
                .removeClass("alert-warning")
                .scrollTop($("#docStatus")[0].scrollHeight);
        }
        //For demo purposes, display the actual timeout on the page
        $("#docTimeout").text(docTimeout / 1000);

                dataTableInstance.projectsTable = $("#projectsTable").DataTable({
                    dom: 'tirl',
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
                        // {data: 'version',"title" :"version","orderable":true,"searchable":false,"class":"text-center"},
                        {data: 'planning_study',"title" :"Urba","orderable":true,"searchable":false,"class":"text-center min-w-50px"},
                        @if (auth()->user()->is_admin() || auth()->user()->is_commercial()) 
                            {data: 'estimate',"title" :"Prix","class":"text-center  min-w-100px"},
                            {data: 'estimate_price',"title" :"Estimatif ","class":"text-center  min-w-100px"},
                        @endif

                        @if (!auth()->user()->is_dessignator()) 
                            {data: 'commercial',"title" :"commercial","orderable":true,"searchable":false,"class":"text-center min-w-80px"},
                        @endif
                        {data: 'mdp',"title" :"mdp","orderable":true,"searchable":false,"class":"text-center  min-w-80px"},
                        {data: 'dessignator',"title" :"dessignator","orderable":true,"searchable":false,"class":"text-center min-w-80px"},
                        @if (!auth()->user()->is_dessignator()) 
                            {data: 'town_planner',"title" :"Urbaniste","orderable":true,"searchable":false,"class":"text-center min-w-80px"},
                        @endif
                        @if (auth()->user()->is_admin()) 
                            {data: 'invoice',"title" :"Facture","orderable":true,"searchable":false,"class":"text-center w-80px"},
                        @endif
                        // {data: 'start_date',"title" :"Début    ","orderable":false,"searchable":true,"class":"text-center min-w-100px"},
                        // {data: 'due_date',"title" :"Fin      ","orderable":false,"searchable":true,"class":"text-center min-w-100px"},
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
                // $('#projectsTable tbody').on( 'click', 'tr', function () {
                    
                //     if ( $(this).hasClass('selected') ) {
                //         $(this).removeClass('selected');
                //     }
                //     else {
                //         dataTableInstance.projectsTable.$('tr.selected').removeClass('selected');
                //         $(this).addClass('selected');
                //     }
                // } );
            })
        </script>
    @endsection
</x-base-layout>
