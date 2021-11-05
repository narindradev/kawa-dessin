<x-base-layout>
    <div id="kt_docs_jkanban_basic"></div>
    @section('scripts')
        <script>
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
                            'title': '{!! $item !!}'
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
                }]
            });
        </script>
    @endsection

</x-base-layout>
