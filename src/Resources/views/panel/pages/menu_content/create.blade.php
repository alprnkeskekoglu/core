@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::menu_content.create_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.menu.content.store', ['menuId' => $menu->id]) }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.menu.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-md-4">
                                <div class="js-nestable-connected-simple dd">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">Bootstrap</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="2">
                                                    <div class="dd-handle">Themes</div>
                                                </li>
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">Documentation</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="4">
                                            <div class="dd-handle">Learning</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle">Code</div>
                                                </li>
                                                <li class="dd-item" data-id="6">
                                                    <div class="dd-handle">Tutorials</div>
                                                </li>
                                                <li class="dd-item" data-id="7">
                                                    <div class="dd-handle">Articles</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="8">
                                            <div class="dd-handle">Design</div>
                                        </li>
                                        <li class="dd-item" data-id="9">
                                            <div class="dd-handle">Coding</div>
                                        </li>
                                        <li class="dd-item" data-id="10">
                                            <div class="dd-handle">Marketing</div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-2">

                                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
                                    @foreach($languages as $language)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#{{$language->code}}">
                                                {{ $language->native_name . ' (' . strtoupper($language->code) . ')' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="block-content tab-content">

                                    @foreach($languages as $language)
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{$language->code}}" role="tabpanel">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">{{ __('DawnstarLang::menu_content.labels.status') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                        <input type="radio" class="custom-control-input" id="status{{$language->id}}_active"
                                                               name="contents[{{$language->id}}][status]" value="1" {{ old('contents.'.$language->id.'.status') == 1 ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status{{$language->id}}_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                                        <input type="radio" class="custom-control-input" id="status{{$language->id}}_draft"
                                                               name="contents[{{$language->id}}][status]" value="2" {{ old('contents.'.$language->id.'.status', 2) == 2 ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status{{$language->id}}_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                        <input type="radio" class="custom-control-input" id="status{{$language->id}}_passive"
                                                               name="contents[{{$language->id}}][status]" value="3" {{ old('contents.'.$language->id.'.status') == 3 ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status{{$language->id}}_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="name{{$language->id}}">{{ __('DawnstarLang::menu_content.labels.name') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="name{{$language->id}}" name="contents[{{$language->id}}][name]"
                                                           value="{{ old('contents.'.$language->id.'.name') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" for="type{{$language->id}}">{{ __('DawnstarLang::menu_content.labels.type') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="type{{$language->id}}" data-language="{{$language->id}}" name="contents[{{$language->id}}][type]">
                                                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                        <option
                                                            value="1" {{ old('contents.'.$language->id.'.type') == 1 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.internal_link') }}</option>
                                                        <option
                                                            value="2" {{ old('contents.'.$language->id.'.type') == 2 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.out_link') }}</option>
                                                        <option
                                                            value="3" {{ old('contents.'.$language->id.'.type') == 3 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.blank_link') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row {{ old('contents.'.$language->id.'.type') == 1 ? '' : 'd-none' }}">
                                                <label class="col-sm-3 col-form-label" for="url_id{{$language->id}}">{{ __('DawnstarLang::menu_content.labels.url_id') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="url_id{{$language->id}}" name="contents[{{$language->id}}][url_id]">
                                                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row {{ old('contents.'.$language->id.'.type') == 2 ? '' : 'd-none' }}">
                                                <label class="col-sm-3 col-form-label" for="out_link{{$language->id}}">{{ __('DawnstarLang::menu_content.labels.out_link') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="out_link{{$language->id}}" name="contents[{{$language->id}}][out_link]"
                                                           value="{{ old('contents.'.$language->id.'.out_link') }}">
                                                </div>
                                            </div>
                                            <div class="form-group row {{ old('contents.'.$language->id.'.type') == 3 ? 'd-none' : '' }}">
                                                <label class="col-sm-3 col-form-label" for="target{{$language->id}}">{{ __('DawnstarLang::menu_content.labels.target') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="target{{$language->id}}" name="contents[{{$language->id}}][target]">
                                                        <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                        <option
                                                            value="_blank" {{ old('contents.'.$language->id.'.target') == '_blank' ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.target.blank') }}</option>
                                                        <option
                                                            value="_self" {{ old('contents.'.$language->id.'.target') == '_self' ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.target.self') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
        $(".js-nestable-connected-simple").nestable({maxDepth: 3})


        $('[id^="type"]').on('change', function () {
            var value = $(this).val();
            var languageId = $(this).attr('data-language');

            alert(value);

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
