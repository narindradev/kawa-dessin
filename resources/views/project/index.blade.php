<x-base-layout>

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-2">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label  fs-3 mb-1"> @lang('lang.list_of_project') </span>
            </h3>
        </div>
    </div>
    @include('project.filters' ,["inputs" => $filters])
    <div class="card card-flush ">
        <div class="card-header mt-5">
            <!--begin::Card title-->
            <div class="card-title flex-column">
                <h3 class="fw-bolder mb-1">Project Spendings</h3>
                <div class="fs-6 text-gray-400"></div>
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar my-1" data-select2-id="select2-data-159-jg33">
                <!--begin::Select-->
                <div class="me-6 my-1">
                    <select id="" name="year" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm select2-hidden-accessible" data-select2-id="select2-data-kt_filter_year" tabindex="-1" aria-hidden="true">
                        <option value="All" selected="selected" data-select2-id="select2-data-98-z3zs">All time</option>
                        <option value="thisyear" data-select2-id="select2-data-162-69g7">This year</option>
                        <option value="thismonth" data-select2-id="select2-data-163-qzbc">This month</option>
                        <option value="lastmonth" data-select2-id="select2-data-164-7mwv">Last month</option>
                        <option value="last90days" data-select2-id="select2-data-165-ufmw">Last 90 days</option>
                    </select>
                </div>
                <!--end::Select-->
                <!--begin::Select-->
                <div class="me-4 my-1">
                    <select id="kt_filter_orders" name="orders" data-control="select2" data-hide-search="true" class="w-125px form-select form-select-solid form-select-sm select2-hidden-accessible" data-select2-id="select2-data-kt_filter_orders" tabindex="-1" aria-hidden="true">
                        <option value="All" selected="selected" data-select2-id="select2-data-100-69mj">All Orders</option>
                        <option value="Approved" data-select2-id="select2-data-167-v93a">Approved</option>
                        <option value="Declined" data-select2-id="select2-data-168-d4fc">Declined</option>
                        <option value="In Progress" data-select2-id="select2-data-169-6m3t">In Progress</option>
                        <option value="In Transit" data-select2-id="select2-data-170-up1c">In Transit</option>
                    </select>
                </div>
                <!--end::Select-->
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-3 position-absolute ms-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" id="kt_filter_search" class="form-control form-control-solid form-select-sm w-150px ps-9" placeholder="Search Order">
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card toolbar-->
        </div>
        <div class="card-body py-1">
            <table id="offerTable" class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4 table-hover "></table>
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
                        {title: 'Type de project',"class":"text-left" ,},
                        {title: 'type de client',"class":"text-left"},
                        {title: 'Devis',"class":"text-left", },
                        {title: 'Date de creation',"orderable":true,"searchable":false,"class":"text-center"},
                        {title: 'Actions',"orderable":false,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/project/list"),
                        data: function(d) {
                            d.status_id = $("#status_id").val();
                        }
                    },
                });
                $('.filter-table').on('click', function() {
                    dataTableInstance.offerTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
