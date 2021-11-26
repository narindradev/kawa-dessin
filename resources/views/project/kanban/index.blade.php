<x-base-layout>
    <div id="jkanban_project"  ></div>
    @section('scripts')
        <script>
            var url = url("/kanban/data/source")
            var requests = {
                "project_id": 12,
                "_token": _token
            }
            function initialisekanban(laodUrl = "", post = {}) {
                $.ajax({
                    url: laodUrl,
                    data: requests,
                    cache: false,
                    type: 'POST',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            return jkanban(response.data)
                        }
                    },
                    statusCode: {
                        404: function() {}
                    },
                    error: function() {}
                });
            }

            function jkanban(data) {
                var kanban = new jKanban({
                    element: '#jkanban_project',
                    // gutter           : '1px', 
                    widthBoard: '300px',
                    boards: data,
                    dragBoards: false, // the boards are draggable, if false only item can be dragged
                    click            : function (el) {
                        console.log(el);
                        console.log(el.id);
                    },
                });
            }
            initialisekanban(url, requests)
        </script>
    @endsection

</x-base-layout>
