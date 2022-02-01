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
    app_lang.try_again = "{{ trans('lang.try_again') }}"
    app_lang.email_required = "{{ trans('lang.email_required') }}"
    app_lang.password_required = "{{ trans('lang.password_required') }}"
    app_lang.detected_error = "{{ trans('lang.detected_error') }}"
    app_lang.got_it = "{{ trans('lang.got_it') }}"
    app_lang.valid_email = "{{ trans('lang.valid_email') }}" 
    app_lang.valid_password = "{{ trans('lang.valid_password') }}" 
    app_lang.success_login = "{{ trans('lang.success_login') }}" 
    app_lang.login_error = "{{ trans('lang.login_error') }}"
    app_lang.ok = "{{ trans('lang.ok') }}"
    function dataTableaddRowIntheTop(tableInstance, data ,draw = false) {
        var table = tableInstance
        var currentPage = table.page();
        table.row.add(data).draw(draw)
        var index = table.row(0).index(),
            rowCount = table.data().length - 1,
            insertedRow = table.row(rowCount).data(),
            tempRow;
        for (var i = rowCount; i > index; i--) {
            tempRow = table.row(i - 1).data();
            table.row(i).data(tempRow);
            table.row(i - 1).data(insertedRow);
        }
        table.page(currentPage).draw(draw);
    }
    function dataTableUpdateRow(tableInstance,row_id, data , draw = false) {
        tableInstance.row("#"+row_id).data(data).draw(draw);
    }
     function scrollBotton(target , vitesse = 2000) {
        $(target).animate({scrollTop: $(target)[0].scrollHeight}, vitesse);
    }
</script>
