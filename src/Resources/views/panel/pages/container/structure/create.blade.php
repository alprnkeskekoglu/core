@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::container.create_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.containers.structures.store') }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.containers.structures.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="reset" class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-sync"></i>
                                {{ __('DawnstarLang::general.refresh') }}
                            </button>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-sm-10 col-md-8">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="feature">{{ __('DawnstarLang::container.labels.feature') }}</label>
                                            <select class="form-control" id="feature" name="feature">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="1" {{ old('feature') == 1 ? 'selected' : '' }}>{{ __('DawnstarLang::container.feature.homepage') }}</option>
                                                <option value="2" {{ old('feature') == 2 ? 'selected' : '' }}>{{ __('DawnstarLang::container.feature.search') }}</option>
                                                <option value="3" {{ old('feature') == 3 ? 'selected' : '' }}>{{ __('DawnstarLang::container.feature.other') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ old('feature') ? '' : 'd-none' }}">
                                            <label class="col-form-label" for="key">{{ __('DawnstarLang::container.labels.key') }}</label>
                                            <input type="text" class="form-control" id="key" name="key" value="{{ old('key') }}" {{ old('feature') != 3 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">{{ __('DawnstarLang::container.labels.status') }}</label>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="status_active" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="status_draft" name="status" value="2" {{ old('status', 2) == 2 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="status_passive" name="status" value="3" {{ old('status') == 3 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">{{ __('DawnstarLang::container.labels.type') }}</label>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="type_multiple" name="type" value="dynamic" {{ old('type') == 'dynamic' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="type_multiple">{{ __('DawnstarLang::container.type.multiple') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="type_single" name="type" value="static" {{ old('type') == 'static' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="type_single">{{ __('DawnstarLang::container.type.single') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt4">
                                    <div class="col-md-12">
                                        <label class="d-block mb-3">{{ __('DawnstarLang::container.properties') }}</label>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="has_detail" name="has_detail" value="1" {{ old('has_detail') == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="has_detail">{{ __('DawnstarLang::container.labels.has_detail') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="has_category" name="has_category" value="1" {{ old('has_category') == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="has_category">{{ __('DawnstarLang::container.labels.has_category') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="is_searchable" name="is_searchable" value="1" {{ old('is_searchable') == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_searchable">{{ __('DawnstarLang::container.labels.is_searchable') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="mt-4">
                                    <ul class="nav nav-tabs nav-tabs-alt w-100" data-toggle="tabs" role="tablist">
                                        @foreach($languages as $language)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#{{$language->code}}">
                                                    <img src="//flagcdn.com/24x18/{{ $language->code == 'en' ? 'gb' : $language->code }}.png" alt="{{ $language->code }}">
                                                    {{ $language->native_name . ' (' . strtoupper($language->code) . ')' }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="block-content tab-content">
                                        @foreach($languages as $language)
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{$language->code}}" role="tabpanel">

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">{{ __('DawnstarLang::container.labels.status') }}</label>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                            <input type="radio" class="custom-control-input" id="details{{$language->id}}_status_active" name="details[{{$language->id}}][status]"
                                                                   value="1" {{ old('details.'.$language->id.'.status') == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                   for="details{{$language->id}}_status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                            <input type="radio" class="custom-control-input" id="details{{$language->id}}_status_passive" name="details[{{$language->id}}][status]"
                                                                   value="3" {{ old('details.'.$language->id.'.status', 3) == 3 ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                   for="details{{$language->id}}_status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="details{{$language->id}}_name">{{ __('DawnstarLang::container.labels.name') }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                               class="form-control containerName"
                                                               data-language="{{$language->id}}"
                                                               id="details{{$language->id}}_name"
                                                               autocomplete="off"
                                                               name="details[{{$language->id}}][name]"
                                                               value="{{ old('details.'.$language->id.'.name') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" for="details{{$language->id}}_slug">{{ __('DawnstarLang::container.labels.slug') }}</label>
                                                    <div class="col-sm-9">

                                                        <div class="input-group">

                                                            @if(session('dawnstar.website.default_language_code') == 1)
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        {{ '/' . $language->code }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <input type="text" class="form-control containerSlug"
                                                                   data-language="{{$language->id}}"
                                                                   id="details{{$language->id}}_slug"
                                                                   autocomplete="off"

                                                                   name="details[{{$language->id}}][slug]"
                                                                   value="{{ old('details.'.$language->id.'.slug') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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

@push('scripts')
    <script>
        var typingTimer;
        var doneTypingInterval = 400;
        var typedInput;

        $('body').delegate('.containerName', 'keyup', function () {
            clearTimeout(typingTimer);
            typedInput = $(this);

            var languageId = typedInput.attr('data-language');

            if(typedInput.val().length) {
                $('#details'+languageId+'_status_active').prop('checked', true)
                if($('#feature').val() != 1) {
                    typingTimer = setTimeout(slugify, doneTypingInterval);
                }
            } else {
                $('#details'+languageId+'_status_passive').prop('checked', true)
                $('.containerSlug[data-language="' + languageId + '"]').val('');
            }
        });

        $('body').delegate('.containerName', 'keydown', function () {
            clearTimeout(typingTimer);
        });


        $('#feature').on('change', function () {
            var value = $(this).val();

            if(value == 1) {
                $('#key').val('homepage');
                $('#key').attr('readonly', true);
                $('#type_multiple, #has_category, #is_searchable').attr('disabled', true);
                $('#type_multiple').attr('checked', false);
                $('#type_single, #has_detail').attr('checked', true);

                $('.containerSlug').attr('readonly', true);
                $('.containerSlug').val('/');
                $('#status_active').attr('checked', true);
            } else if(value == 2) {
                $('#key').val('search');
                $('#key').attr('readonly', true);
                $('#type_multiple, #has_category, #is_searchable').attr('disabled', true);
                $('#type_multiple').attr('checked', false);
                $('#type_single, #has_detail').attr('checked', true);
                $('.containerSlug').attr('readonly', false)
            } else {
                $('#key').val('');
                $('#key').attr('readonly', false);
                $('#type_multiple, #has_category, #is_searchable').attr('disabled', false);
                $('#type_single, #has_detail').attr('checked', false);
                $('.containerSlug').attr('readonly', false)
            }

            $('#key').closest('.form-group').removeClass('d-none');
        });

        $('[name="type"]').on('change', function () {

            var value = $(this).val();
            if(value == 'dynamic') {
                $('#has_category').attr('disabled', false);
            } else if(value == 'static') {
                $('#has_category').attr('disabled', true);
            }
        });

        slugify = function () {
            var text = typedInput.val();
            var map = {
                'çÇ': 'c',
                'ğĞ': 'g',
                'şŞ': 's',
                'üÜ': 'u',
                'ıİ': 'i',
                'öÖ': 'o'
            };
            for (var key in map) {
                text = text.replace(new RegExp('[' + key + ']', 'g'), map[key]);
            }
            var slug = '/' + text.replace(/[^-a-zA-Z0-9\s]+/ig, '')
                .replace(/\s/gi, "-")
                .replace(/[-]+/gi, "-")
                .toLowerCase();

            var languageId = typedInput.attr('data-language');

            $.ajax({
                'url': '{{ route('dawnstar.containers.getUrl') }}',
                'data': {'language_id': languageId, 'url': slug},
                'method': 'GET',
                success: function (response) {
                    $('.containerSlug[data-language="' + languageId + '"]').val(response);
                },
            });
        }
    </script>
@endpush
