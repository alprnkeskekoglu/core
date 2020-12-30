<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dawnstar</title>
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('vendor/dawnstar/assets/css/dashmix.min.css') }}">
    @stack('styles')
</head>
<body>

<div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
<!-- Sidebar -->
@include('DawnstarView::layouts.sidebar')
<!-- Sidebar End -->

<!-- Header -->
@include('DawnstarView::layouts.header')
<!-- Header End -->

@yield('content')

<!-- Footer -->
@include('DawnstarView::layouts.footer')
<!-- Footer End -->
</div>

<script src="{{ asset('vendor/dawnstar/assets/js/dashmix.core.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/dashmix.app.min.js') }}"></script>
@stack('scripts')
</body>
</html>
