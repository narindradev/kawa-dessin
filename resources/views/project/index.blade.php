<x-base-layout>

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-2">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label  fs-3 mb-1"> </span>
            </h3>
        </div>
    </div>
    <div class="card card-flush mb-3 ">
        <div class="card-header card-header-stretch">
            <!--begin::Title-->
            <div class="card-title">
                <h5 class="m-0 text-gray-800">Statement</h5>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch fs-5 fw-bold nav-line-tabs border-transparent" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_year_tab" class="nav-link text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_referrals_1" aria-selected="false">This Year</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2019_tab" class="nav-link text-active-gray-800 me-4" data-bs-toggle="tab" role="tab" href="#kt_referrals_2" aria-selected="false">2019</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2018_tab" class="nav-link text-active-gray-800 me-4" data-bs-toggle="tab" role="tab" href="#kt_referrals_3" aria-selected="false">2018</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2017_tab" class="nav-link text-active-gray-800 ms-8 active" data-bs-toggle="tab" role="tab" href="#kt_referrals_4" aria-selected="true">2017</a>
                    </li>
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-header mt-5">
            <div class="card-title flex-column">
                <h3 class="fw-bolder mb-1"></h3>
                <div class="fs-6 text-gray-400"></div>
            </div>
            <div class="card-toolbar my-1" data-select2-id="select2-data-159-jg33">
                <div class="me-4 my-1">
                    @include('project.filters-advanced' ,["inputs" => $advance_filter])
                </div>
                <div class="filter-datatable">
                    @include('project.filters-basic', ["inputs" => $basic_filter ,"filter_for" => "offerTable"])
                </div>
                <div class="me-4 my-2 ">
                    <div class="d-flex align-items-center position-relative my-1">
                        <input type="text" id="search-project" autocomplete="off" class="form-control form-control-solid form-select-sm w-200px ps-9 offerTable" placeholder="{{ trans('lang.search') }}">
                    </div>
                </div>
                <div class="me-4 my-2">
                    <a id="do-search-project" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default"><i class="bi bi-search"></i></a>
                </div>
            </div>
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
                    searching: false,
                    columns: [
                        {title: '',"class":"text-left","orderable":false,"searchable":false},
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
                            <?php foreach(inputs_filter_datatable($basic_filter) as $input ) { ?>
                            d.{{ $input }} = $("#{{ $input }}").val();
                            <?php } ?>
                        }
                    },
                });
                $('#search-project').on('keyup', function() {
                    dataTableInstance.offerTable.search(this.value).draw();
                });

                $('#do-search-project').on('click', function() {
                    dataTableInstance.offerTable.ajax.reload();
                });

                $('.offerTable').on('keyup', function() {
                    $("#search88").trigger("click")
                });
            })
        </script>
    @endsection
</x-base-layout>
