<x-base-layout>

    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div id="kt_docs_jkanban_basic"></div>
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
        <div class="col-2">

            <button class="button">test</button>
            <input type="text" name="offer_id" value=""  id ="offer_id" class="filter">
        </div>
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
                        data: function(d) {
                            d.offer_id = $("#offer_id").val();
                        }
                    },
                });

                $('.button').on('click', function() {
                    dataTableInstance.offerTable.ajax.reload();
                });

                var kanban = new jKanban({
    element: '#kt_docs_jkanban_basic',
    gutter: '0',
    widthBoard: '250px',
    boards: [{
            'id': '_inprocess',
            'title': 'In Process',
            'item': [{
                    'title': '<span class="font-weight-bold">You can drag me too</span>'
                },
                {
                    'title': '<span class="font-weight-bold">Buy Milk</span>'
                }
            ]
        }, {
            'id': '_working',
            'title': 'Working',
            'item': [{
                    'title': '<span class="font-weight-bold">Do Something!</span>'
                },
                {
                    'title': '<span class="font-weight-bold">Run?</span>'
                }
            ]
        }, {
            'id': '_done',
            'title': 'Done',
            'item': [{
                    'title': '<span class="font-weight-bold">All right</span>'
                },
                {
                    'title': '<span class="font-weight-bold">Ok!</span>'
                }
            ]
        }
    ]
});
            })
        </script>
    @endsection
</x-base-layout>
