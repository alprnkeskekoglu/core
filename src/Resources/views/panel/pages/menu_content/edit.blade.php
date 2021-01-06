@extends('DawnstarView::layouts.app')

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
                                        <button type="button" class="btn btn-alt-warning orderSaveBtn">Sıralama Kaydet</button>
                                    </div>
                                </div>
                                <div class="menu-list dd">
                                    <ol class="dd-list">
                                        {{--TODO: make this part recursive--}}
                                        @foreach($menuContents as $menuContent)
                                            <li class="dd-item" data-id="{{ $menuContent->id }}">
                                                <div class="float-right p-2 mr-2">
                                                    <div class="badge badge-{{ $menuContent->status == 1 ? 'success' : 'danger' }} mr-2">&nbsp;&nbsp;</div>
                                                    <a href="{{ route('dawnstar.menu.content.edit', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                                                       class="mr-2 {{ $selectedMenuContent->id == $menuContent->id ? '' : 'text-black' }}"
                                                       data-toggle="tooltip"
                                                       data-placement="right"
                                                       title="{{ __('DawnstarLang::general.edit') }}">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="{{ route('dawnstar.menu.content.delete', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                                                       data-toggle="tooltip"
                                                       class="text-black"
                                                       data-placement="right"
                                                       title="{{ __('DawnstarLang::general.delete') }}">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <div class="dd-handle">
                                                    {{ $menuContent->name }}
                                                </div>
                                                @if($menuContent->children->isNotEmpty())
                                                    <ol class="dd-list">
                                                        @foreach($menuContent->children as $menuContentChild)
                                                            <li class="dd-item" data-id="{{ $menuContentChild->id }}">
                                                                <div class="float-right p-2 mr-2">
                                                                    <div class="badge badge-{{ $menuContentChild->status == 1 ? 'success' : 'danger' }} mr-2">&nbsp;&nbsp;</div>
                                                                    <a href="{{ route('dawnstar.menu.content.edit', ['menuId' => $menu->id, 'id' => $menuContentChild->id]) }}"
                                                                       class="mr-2 {{ $selectedMenuContent->id == $menuContentChild->id ? '' : 'text-black' }}"
                                                                       data-toggle="tooltip"
                                                                       data-placement="right"
                                                                       title="{{ __('DawnstarLang::general.edit') }}">
                                                                        <i class="fa fa-pencil-alt"></i>
                                                                    </a>
                                                                    <a href="{{ route('dawnstar.menu.content.delete', ['menuId' => $menu->id, 'id' => $menuContentChild->id]) }}"
                                                                       class="text-black"
                                                                       data-toggle="tooltip"
                                                                       data-placement="right" title="{{ __('DawnstarLang::general.delete') }}">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="dd-handle">{{ $menuContentChild->name }}</div>
                                                                @if($menuContentChild->children->isNotEmpty())
                                                                    <ol class="dd-list">
                                                                        @foreach($menuContentChild->children as $menuContentCh)
                                                                            <li class="dd-item" data-id="{{ $menuContentCh->id }}">
                                                                                <div class="float-right p-2 mr-2">
                                                                                    <div class="badge badge-{{ $menuContentCh->status == 1 ? 'success' : 'danger' }} mr-2">&nbsp;&nbsp;</div>
                                                                                    <a href="{{ route('dawnstar.menu.content.edit', ['menuId' => $menu->id, 'id' => $menuContentCh->id]) }}"
                                                                                       class="mr-2 {{ $selectedMenuContent->id == $menuContentCh->id ? '' : 'text-black' }}"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="right"
                                                                                       title="{{ __('DawnstarLang::general.edit') }}">
                                                                                        <i class="fa fa-pencil-alt"></i>
                                                                                    </a>
                                                                                    <a href="{{ route('dawnstar.menu.content.delete', ['menuId' => $menu->id, 'id' => $menuContentCh->id]) }}"
                                                                                       class="text-black"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="right"
                                                                                       title="{{ __('DawnstarLang::general.delete') }}">
                                                                                        <i class="fa fa-trash-alt"></i>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="dd-handle">{{ $menuContentCh->name }}</div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-2">
                                <div class="block-content">
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
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(".menu-list").nestable({maxDepth: 3})

        $('.orderSaveBtn').on('click', function () {
            var languageId = $(this).attr('data-language');

            $.ajax({
                url: '{{ route('dawnstar.menu.content.saveOrder', ['menuId' => $menu->id]) }}',
                data: {
                    'language_id': languageId,
                    'data': $('.menu-list[data-language="' + languageId + '"]').nestable('serialize')
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
@endpush
