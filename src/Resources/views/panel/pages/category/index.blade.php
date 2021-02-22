@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::category.create_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-header block-header-default block-header-rtl">
                    <div class="block-options">
                        <a href="{{ route('dawnstar.containers.pages.index', ['containerId' => $container->id]) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i>
                            {{ __('DawnstarLang::general.go_back') }}
                        </a>
                        <a href="{{ route('dawnstar.containers.categories.create', ['containerId' => $container->id]) }}" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                            <i class="fa fa-fw fa-plus mr-1"></i>
                            {{ __('DawnstarLang::general.add_new') }}
                        </a>
                    </div>
                </div>
                <div class="block-content tab-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-md-6 offse-md-3">
                            @if($categories->isNotEmpty())
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-alt-warning orderSaveBtn">Sıralama Kaydet</button>
                                    </div>
                                </div>
                                <div class="category-list dd">
                                    @include('DawnstarView::pages.category.list', ['categories' => $categories])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(".category-list").nestable({maxDepth: 3})

        $('.orderSaveBtn').on('click', function () {
            $.ajax({
                url: '{{ route('dawnstar.containers.categories.saveOrder', ['containerId' => $container->id]) }}',
                data: {
                    'data': $('.category-list').nestable('serialize')
                },
                success: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.success.title') }}', '{{ __('DawnstarLang::menu_content.swal.success.subtitle') }}', 'success');
                },
                error: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.error.title') }}', '{{ __('DawnstarLang::menu_content.swal.error.subtitle') }}', 'error');
                }
            })
        });


        jQuery('.deleteBtn').on('click', e => {
            var url = e.currentTarget.getAttribute('data-url');
            swal.fire({
                title: '{{ __('DawnstarLang::general.swal.title') }}',
                text: '{{ __('DawnstarLang::general.swal.subtitle') }}',
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                confirmButtonText: '{{ __('DawnstarLang::general.swal.confirm_btn') }}',
                cancelButtonText: '{{ __('DawnstarLang::general.swal.cancel_btn') }}',
                html: false,
                preConfirm: e => {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        'url': url,
                        'method': 'DELETE',
                        'data': {'_token': '{{ csrf_token() }}'},
                        success: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.success.title') }}', '{{ __('DawnstarLang::general.swal.success.subtitle') }}', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.error.title') }}', '{{ __('DawnstarLang::general.swal.error.subtitle') }}', 'error');
                        }
                    })
                }
            });
        });
    </script>
@endpush
