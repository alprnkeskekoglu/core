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
    @stack('styles')
</head>

<body class="loading" data-layout="detached">
@include('Core::includes.header')
<div class="container-fluid">
    <div class="wrapper">
        @include('Core::includes.sidebar')
        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
            @include('Core::includes.footer')
        </div>
    </div>
</div>

<script src="{{ asset('vendor/dawnstar/assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/app.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/dawnstar.js') }}"></script>
@stack('scripts')
</body>
</html>
