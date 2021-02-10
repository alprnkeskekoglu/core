@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::tool.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="pt-4 px-4 bg-body-dark rounded push">
                <div class="row row-deck justify-content-center">
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="javascript:void(0)" onclick="toolAjax('cacheClear')" class="block block-rounded block-link-pop text-center d-flex align-items-center bg-gd-sublime">
                            <div class="block-content">
                                <p class="mb-2 d-none d-sm-block text-white">
                                    <i class="fa fa-eraser opacity-75 fa-2x"></i>
                                </p>
                                <p class="font-w600 font-size-sm text-uppercase text-white">Cache Clear</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="javascript:void(0)" onclick="toolAjax('configClear')" class="block block-rounded block-link-pop text-center d-flex align-items-center bg-gd-sublime">
                            <div class="block-content">
                                <p class="mb-2 d-none d-sm-block text-white">
                                    <i class="fa fa-eraser opacity-75 fa-2x"></i>
                                </p>
                                <p class="font-w600 font-size-sm text-uppercase text-white">Config Clear</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="javascript:void(0)" onclick="toolAjax('viewClear')" class="block block-rounded block-link-pop text-center d-flex align-items-center bg-gd-sublime">
                            <div class="block-content">
                                <p class="mb-2 d-none d-sm-block text-white">
                                    <i class="fa fa-eraser opacity-75 fa-2x"></i>
                                </p>
                                <p class="font-w600 font-size-sm text-uppercase text-white">View Clear</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="{{ route('dawnstar.tool.env') }}" class="block block-rounded block-link-pop text-center d-flex align-items-center bg-gd-sublime">
                            <div class="block-content">
                                <p class="mb-2 d-none d-sm-block text-white">
                                    <i class="fa fa-edit opacity-75 fa-2x"></i>
                                </p>
                                <p class="font-w600 font-size-sm text-uppercase text-white">Edit .env</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function toolAjax(type) {

            Dashmix.layout('header_loader_on');
            $.ajax({
                'method': 'POST',
                'url': '{{ route('dawnstar.tool.init') }}',
                'data': {'function': type, '_token': '{{csrf_token()}}'},
                success: function (response) {
                    swal.fire(response.title, response.subtitle, 'success');
                    Dashmix.layout('header_loader_off');
                }
            })
        }
    </script>
@endpush
