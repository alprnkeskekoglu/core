@extends('DawnstarView::layouts.app')

@php($image = $selectedMenuContent->mf_image ? getMediaArray($selectedMenuContent->mf_image) : null)
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
            <form action="{{ route('dawnstar.menu.content.update', ['menuId' => $menu->id, 'id' => $selectedMenuContent->id]) }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.menu.content.create', ['menuId' => $menu->id]) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content tab-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-md-4">
                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-alt-warning orderSaveBtn" data-language="{{ $selectedMenuContent->language_id }}">{{ __('DawnstarLang::menu_content.order_save') }}</button>
                                    </div>
                                </div>
                                <div class="menu-list dd" data-language="{{ $selectedMenuContent->language_id }}">
                                    @include('DawnstarView::pages.menu_content.list')
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-2">
                                <div class="block-content">
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <label for="menu_image">{{ __('DawnstarLang::menu_content.labels.image') }}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-primary openFileManagerBtn" data-id="menu_image" data-mediatype="image" data-selectabletype="image" data-maxmediacount="1">
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
                                                    {{ old('status', $selectedMenuContent->status) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input"
                                                       id="status_passive"
                                                       name="status"
                                                       value="3"
                                                    {{ old('status', $selectedMenuContent->status) == 3 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="name">{{ __('DawnstarLang::menu_content.labels.name') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name', $selectedMenuContent->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="type">{{ __('DawnstarLang::menu_content.labels.type') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="type" name="type">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="1" {{ old('type', $selectedMenuContent->type) == 1 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.internal_link') }}
                                                </option>
                                                <option value="2" {{ old('type', $selectedMenuContent->type) == 2 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.out_link') }}
                                                </option>
                                                <option value="3" {{ old('type', $selectedMenuContent->type) == 3 ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.type.blank_link') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $selectedMenuContent->type) == 1 ? '' : 'd-none' }}">
                                        <label class="col-sm-3 col-form-label" for="url_id">{{ __('DawnstarLang::menu_content.labels.url_id') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="url_id" name="url_id">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                @if($selectedMenuContent->url_id)
                                                    <option value="{{ $selectedMenuContent->url_id }}" selected>{{ $selectedMenuContent->url->model->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $selectedMenuContent->type) == 2 ? '' : 'd-none' }}">
                                        <label class="col-sm-3 col-form-label" for="out_link">{{ __('DawnstarLang::menu_content.labels.out_link') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="out_link" name="out_link"
                                                   value="{{ old('out_link', $selectedMenuContent->out_link) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row {{ old('type', $selectedMenuContent->type) == 3 ? 'd-none' : '' }}">
                                        <label class="col-sm-3 col-form-label" for="target">{{ __('DawnstarLang::menu_content.labels.target') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="target" name="target">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="_blank" {{ old('target', $selectedMenuContent->target) == '_blank' ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.target.blank') }}
                                                </option>
                                                <option value="_self" {{ old('target', $selectedMenuContent->target) == '_self' ? 'selected' : '' }}>
                                                    {{ __('DawnstarLang::menu_content.target.self') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                url: '{{ route('dawnstar.menu.content.saveOrder', ['menuId' => $menu->id]) }}',
                data: {
                    'language_id': languageId,
                    'data': $('.menu-list[data-language="' + languageId + '"]').nestable('serialize')
                },
                success: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.success.title') }}', '{{ __('DawnstarLang::menu_content.swal.success.subtitle') }}', 'success');
                },
                error: function (response) {
                    swal.fire('{{ __('DawnstarLang::menu_content.swal.error.title') }}', '{{ __('DawnstarLang::menu_content.swal.error.subtitle') }}', 'error');
                }
            })
        });

        var languageId = '{{ $selectedMenuContent->language_id }}';
        getUrls(languageId);

        $('[id^="type"]').on('change', function () {
            var value = $(this).val();
            languageId = $(this).attr('data-language');

            if (value == 1) {
                $('#url_id' + languageId).closest('.form-group').removeClass('d-none');
                $('#out_link' + languageId).closest('.form-group').addClass('d-none');
                $('#target' + languageId).closest('.form-group').removeClass('d-none');
                getUrls(languageId);
            } else if (value == 2) {
                $('#url_id' + languageId).closest('.form-group').addClass('d-none');
                $('#out_link' + languageId).closest('.form-group').removeClass('d-none');
                $('#target' + languageId).closest('.form-group').removeClass('d-none');

            } else {
                $('#url_id' + languageId).closest('.form-group').addClass('d-none');
                $('#out_link' + languageId).closest('.form-group').addClass('d-none');
                $('#target' + languageId).closest('.form-group').addClass('d-none');
            }
        });

        function getUrls(languageId) {
            $('#url_id' + languageId).select2({
                language: '{{ session('dawnstar.language.code') ?: 'en' }}',
                ajax: {
                    url: '{{ route('dawnstar.menu.getUrls') }}',
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


        function handleFileManager(medias){
            var ids = '';
            var mediaHtml = '';

            $.each(medias, function (id, data) {
                ids += id + ',';
                mediaHtml += '<div class="px-1 text-center">' + data.html + '<div class="font-size-sm text-muted">'+ data.fullname +'</div></div>';
            });

            ids = ids.replace(/,\s*$/, "")

            $('#' + currentMediaInputId).val(ids);
            $('#show_' + currentMediaInputId).html(mediaHtml);
        }
    </script>
@endpush
