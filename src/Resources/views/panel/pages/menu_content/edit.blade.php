@extends('DawnstarView::layouts.app')

@php($image = $menuContent->mf_image ? getMediaArray($menuContent->mf_image) : null)
@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::menu_content.edit_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <div class="block block-rounded">
                <div class="block-header block-header-default block-header-rtl">
                    <div class="block-options">
                        <a href="{{ route('dawnstar.menus.contents.create', $menu) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i>
                            {{ __('DawnstarLang::general.go_back') }}
                        </a>
                    </div>
                </div>
                <div class="block-content tab-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-md-4">
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-alt-warning orderSaveBtn"
                                            data-language="{{ $menuContent->language_id }}">{{ __('DawnstarLang::menu_content.order_save') }}</button>
                                </div>
                            </div>
                            <div class="menu-list dd" data-language="{{ $menuContent->language_id }}">
                                @include('DawnstarView::pages.menu_content.list')
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-2">
                            <form action="{{ route('dawnstar.menus.contents.update', [$menu, $menuContent]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="block-content">
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <label for="menu_image">{{ __('DawnstarLang::menu_content.labels.image') }}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-primary openFileManagerBtn" data-id="menu_image" data-mediatype="image" data-selectabletype="image"
                                                    data-maxmediacount="1">
                                                {{ __('DawnstarLang::general.filemanager') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block">
                                        <div id="show_menu_image">
                                            @if($image)
                                                <div class="px-1 text-center">
                                                    {!! $image['html'] !!}
                                                    <div class="font-size-sm text-muted">{!! $image['fullname'] !!}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="hidden" name="image" id="menu_image" value="{{ isset($image) ? $image['id'] : '' }}">
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">{{ __('DawnstarLang::menu_content.labels.status') }}</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                <input type="radio" class="custom-control-input"
                                                       id="status_active"
                                                       name="status"
                                                       value="1"
                                                    {{ old('status', $menuContent->status) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input"
                                                       id="status_passive"
                                                       name="status"
                                                       value="3"
                                                    {{ old('status', $menuContent->status) == 3 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="name">{{ __('DawnstarLang::menu_content.labels.name') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name', $menuContent->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="type">{{ __('DawnstarLang::menu_content.labels.type') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="type" name="type">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="1" {{ old('type', $menuContent->type) == 1 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.internal_link') }}
                                                </option>
                                                <option value="2" {{ old('type', $menuContent->type) == 2 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.out_link') }}
                                                </option>
                                                <option value="3" {{ old('type', $menuContent->type) == 3 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.blank_link') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $menuContent->type) == 1 ? '' : 'd-none' }}">
                                        <label class="col-sm-3 col-form-label" for="url_id">{{ __('DawnstarLang::menu_content.labels.url_id') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="url_id" name="url_id">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                @if($menuContent->url_id)
                                                    <option value="{{ $menuContent->url_id }}" selected>{{ $menuContent->url->model->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $menuContent->type) == 2 ? '' : 'd-none' }}">
                                        <label class="col-sm-3 col-form-label" for="out_link">{{ __('DawnstarLang::menu_content.labels.out_link') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="out_link" name="out_link"
                                                   value="{{ old('out_link', $menuContent->out_link) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $menuContent->type) == 3 ? 'd-none' : '' }}">
                                        <label class="col-sm-3 col-form-label" for="target">{{ __('DawnstarLang::menu_content.labels.target') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="target" name="target">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="_blank" {{ old('target', $menuContent->target) == '_blank' ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.target.blank') }}
                                                </option>
                                                <option value="_self" {{ old('target', $menuContent->target) == '_self' ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.target.self') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-sm btn-outline-primary float-right">
                                        <i class="fa fa-check"></i>
                                        {{ __('DawnstarLang::general.submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(".menu-list").nestable({maxDepth: 3});

        $('.orderSaveBtn').on('click', function () {
            var languageId = $(this).attr('data-language');

            $.ajax({
                url: '{{ route('dawnstar.menus.saveOrder', $menu) }}',
                method: 'post',
                data: {
                    'language_id': languageId,
                    'data': $('.menu-list[data-language="' + languageId + '"]').nestable('serialize'),
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.success.title') }}', '{{ __('DawnstarLang::menu_content.swal.success.subtitle') }}', 'success');
                },
                error: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.error.title') }}', '{{ __('DawnstarLang::menu_content.swal.error.subtitle') }}', 'error');
                }
            })
        });

        var languageId = '{{ $menuContent->language_id }}';
        getUrls(languageId);

        $('[id^="type"]').on('change', function () {
            var value = $(this).val();

            if (value == 1) {
                $('#url_id').closest('.form-group').removeClass('d-none');
                $('#out_link').closest('.form-group').addClass('d-none');
                $('#target').closest('.form-group').removeClass('d-none');
                getUrls(languageId);
            } else if (value == 2) {
                $('#url_id').closest('.form-group').addClass('d-none');
                $('#out_link').closest('.form-group').removeClass('d-none');
                $('#target').closest('.form-group').removeClass('d-none');

            } else {
                $('#url_id').closest('.form-group').addClass('d-none');
                $('#out_link').closest('.form-group').addClass('d-none');
                $('#target').closest('.form-group').addClass('d-none');
            }
        });

        function getUrls(languageId) {
            $('#url_id').select2({
                language: '{{ session('dawnstar.language.code') ?: 'en' }}',
                ajax: {
                    url: '{{ route('dawnstar.menus.getUrls') }}',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            language_id: languageId
                        }
                        return query;
                    }
                }
            });
        }


        $('.deleteBtn').on('click', function () {
            var self = $(this);
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
                    if (self.closest('.dd-item').find('.dd-list').length == 0) {
                        self.closest('form').submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            html: '{{ __('DawnstarLang::general.swal.delete_children') }}',
                            showCloseButton: true,
                            showCancelButton: true,
                            customClass: {
                                confirmButton: 'btn btn-danger m-1',
                                cancelButton: 'btn btn-secondary m-1'
                            },
                            confirmButtonText: '{{ __('DawnstarLang::general.swal.confirm_btn') }}',
                            cancelButtonText: '{{ __('DawnstarLang::general.swal.cancel_btn') }}',
                        }).then((result) => {
                            if (result.value) {
                                self.closest('form').find('input[name="child_delete"]').val('1')
                                self.closest('form').submit();
                            } else if (result.dismiss && result.dismiss == 'cancel') {
                                self.closest('form').find('input[name="child_delete"]').val('2')
                                self.closest('form').submit();
                            }
                        })
                    }

                }
            });
        });
    </script>

    <script>
        var currentMediaInputId;
        $('.openFileManagerBtn').on('click', function () {
            currentMediaInputId = $(this).attr('data-id');
            var _mediaType = $(this).attr('data-mediaType');
            var _selectableType = $(this).attr('data-selectableType');
            var _maxMediaCount = $(this).attr('data-maxMediaCount');
            var _selectedMediaIds = $('#' + currentMediaInputId).val();
            window.open(
                '{{ route('dawnstar.filemanager.index') }}' + '/' + _mediaType + '?selectableType=' + _selectableType + '&maxMediaCount=' + _maxMediaCount + '&selectedMediaIds=' + _selectedMediaIds,
                'Dawnstar File Manager', 'width=1520,height=740,left=200,top=100'
            );
        });


        function handleFileManager(medias) {
            var ids = '';
            var mediaHtml = '';

            $.each(medias, function (id, data) {
                ids += id + ',';
                mediaHtml += '<div class="px-1 text-center">' + data.html + '<div class="font-size-sm text-muted">' + data.fullname + '</div></div>';
            });

            ids = ids.replace(/,\s*$/, "")

            $('#' + currentMediaInputId).val(ids);
            $('#show_' + currentMediaInputId).html(mediaHtml);
        }
    </script>
@endpush
