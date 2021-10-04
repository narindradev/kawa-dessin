<script>
    var _token = $('meta[name="csrf-token"]').attr('content')

    var getCsrfToken = function() {
        if (!_token) {
            return console.log("Token is not set")
        }
        return _token
    }

    function url(url = "") {
        return "{{ url('') }}" + url
    }
    var dataTableInstance = {}
    toastr.options = {
        "closeButton": true,
        "newestOnTop": 1,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "preventDuplicates": 0,
        "timeOut": 5000,
        "showEasing": "swing",
        "hideEasing": "linear",
    }
    var app_lang = {}
    app_lang.undo = "{{ trans('lang.cancel') }}"
    app_lang.message = "{{ trans('lang.message') }}"
    app_lang.processing = "{{ trans('lang.processing') }}"
    app_lang.loading = "{{ trans('lang.loading') }}"
    app_lang.please_wait = "{{ trans('lang.please_wait') }}"
    app_lang.sending = "{{ trans('lang.sending') }}"
    app_lang.error = "{{ trans('lang.error') }}"


    function dataTableaddRowIntheTop(tableInstance, data) {
        var table = tableInstance
        var currentPage = table.page();
        table.row.add(data).draw()
        var index = table.row(0).index(),
            rowCount = table.data().length - 1,
            insertedRow = table.row(rowCount).data(),
            tempRow;
        for (var i = rowCount; i > index; i--) {
            tempRow = table.row(i - 1).data();
            table.row(i).data(tempRow);
            table.row(i - 1).data(insertedRow);
        }
        table.page(currentPage).draw(false);
    }

    function dataTableUpdateRow(tableInstance,row, data) {
        tableInstance.row("#"+row).data(data).draw();
    }
</script>
