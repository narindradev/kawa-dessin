<script>
    var _token = $('meta[name="csrf-token"]').attr('content')

    var getCsrfToken = function () {
        if(!_token){
            return console.log("Token is not set")
        }
        return _token
    }
    function url(url="") {
        return "{{ url("") }}" + url
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
    app_lang.undo = "{{ trans("lang.cancel") }}"
    app_lang.message = "{{ trans("lang.message")}}"
    app_lang.processing = "{{ trans("lang.processing") }}"
    app_lang.loading = "{{ trans("lang.loading") }}"
    app_lang.please_wait = "{{ trans("lang.please_wait") }}"
    app_lang.sending = "{{ trans("lang.sending") }}"
    app_lang.error = "{{ trans("lang.error") }}"
   
</script>