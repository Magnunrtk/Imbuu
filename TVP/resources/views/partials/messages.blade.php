<script type="text/javascript">
    function showNotification(type, title, text, position = 'top-right', options = null) {
        if ($("#toast-container").length) {
            $("#toast-container").remove();
        }

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toastr-" + position + "",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        options = options === null ? toastr.options : options;

        if (type === 'success') {
            toastr.success(text, title, options);
        } else if (type === 'error') {
            toastr.error(text, title, options);
        } else if (type === 'warning') {
            toastr.warning(text, title, options);
        } else if (type === 'info') {
            toastr.info(text, title, options);
        }
    }
    @if ($message = Session::get('success'))
    showNotification('success', 'Done', '{!! $message !!}');
    @endif
    @if ($message = Session::get('error'))
    showNotification('error', 'Error', '{!! $message !!}');
    @endif
    @if ($message = Session::get('warning'))
    showNotification('warning', 'Warning', '{!! $message !!}');
    @endif
    @if ($message = Session::get('danger'))
    showNotification('error', 'Error', '{!! $message !!}');
    @endif
    @if ($message = Session::get('info'))
    showNotification('info', 'Info', '{!! $message !!}');
    @endif
</script>
