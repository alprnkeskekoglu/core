<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dawnstar</title>
    <link rel="shortcut icon" href="{{ asset('vendor/dawnstar/assets/images/favicon.ico') }}">
    <link href="{{ asset('vendor/dawnstar/assets/css/icons.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/dawnstar/assets/css/app-modern.min.css') }}" rel="stylesheet" id="light-style"/>
    <link href="{{ asset('vendor/dawnstar/assets/css/app-modern-dark.min.css') }}" rel="stylesheet" id="dark-style"/>
    <link href="{{ asset('vendor/dawnstar/assets/css/dawnstar.css') }}" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" >
    @stack('styles')
</head>

<body class="loading" data-layout="detached">
@include('Dawnstar::includes.header')
<div class="container-fluid">
    <div class="wrapper">
        @include('Dawnstar::includes.sidebar')
        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
            @include('Dawnstar::includes.footer')
        </div>
    </div>
</div>

<script src="{{ asset('vendor/dawnstar/assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/app.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    function showNotification(type, message) {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "showDuration": "100",
            "hideDuration": "750",
            "timeOut": "2000",
            "extendedTimeOut": "750",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        if(type === 'success') {
            toastr.success(message)
        } else if(type === 'error') {
            toastr.error(message)
        }
    }
</script>
@stack('scripts')
</body>
</html>
