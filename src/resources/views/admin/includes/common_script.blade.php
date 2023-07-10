<script src="{{ asset('admin/js/pages/plugins/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/just-validate.production.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/iziToast.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/plugins/waves.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/plugins/feather.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/img-previewer.min.js') }}"></script>

<script type="text/javascript" nonce="{{ csp_nonce() }}">
    @if (session('success_status'))

        iziToast.success({
            title: 'Success',
            message: '{{ Session::get('success_status') }}',
            position: 'topRight',
            timeout:6000
        });

    @endif
    @if (session('error_status'))

        iziToast.error({
            title: 'Error',
            message: '{{ Session::get('error_status') }}',
            position: 'topRight',
            timeout:6000
        });

    @endif

</script>
<script type="text/javascript" nonce="{{ csp_nonce() }}">

    const errorToast = (message) =>{
        iziToast.error({
            title: 'Error',
            message: message,
            position: 'bottomCenter',
            timeout:7000
        });
    }
    const successToast = (message) =>{
        iziToast.success({
            title: 'Success',
            message: message,
            position: 'bottomCenter',
            timeout:6000
        });
    }

    const spinner = `
        <span class="d-flex align-items-center">
            <span class="spinner-border flex-shrink-0" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            <span class="flex-grow-1 ms-2">
                Loading...
            </span>
        </span>
    `;

</script>
