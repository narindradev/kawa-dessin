<x-base-layout>

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        
        <div class="card-header border-0 pt-2">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label  fs-3 mb-1"> @lang('lang.list_of_offers') </span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                data-bs-original-title="@lang('lang.add_offer')">
                @php
                    echo modal_anchor(url('offer/form_modal/'), '<i class="fas fa-plus"></i>' . trans('lang.add_new_offer'), ['title' => trans('lang.add_new_offer'), 'class' => 'btn btn-sm btn-light-primary']);
                @endphp
            </div>
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-body py-5">
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
                        {title: 'name',"class":"text-left"},
                        {title: 'description',"class":"text-left"},
                        {title: '<i class="fas fa-bars" style="font-size:20px"></i>',"orderable":false,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/offer/data_list"),
                    },
                });
            })
        </script>
    @endsection
</x-base-layout>
