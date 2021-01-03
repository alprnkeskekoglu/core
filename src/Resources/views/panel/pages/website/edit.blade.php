@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::website.edit_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.website.update', ['id' => $website->id]) }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.website.index') }}" class="btn btn-sm btn-outline-secondary">
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

                                <div class="form-group">
                                    <label class="d-block">{{ __('DawnstarLang::website.labels.status') }}</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_active"
                                               name="status" value="1" {{ old('status', $website->status) == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_draft" name="status"
                                               value="2" {{ old('status', $website->status) == 2 ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="status_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_passive"
                                               name="status" value="3" {{ old('status', $website->status) == 3 ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::website.labels.order') }}</label>
                                            <input type="number" class="form-control" id="order" name="order"
                                                   value="{{ old('order', $website->order) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">{{ __('DawnstarLang::website.labels.is_default') }}</label>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="is_default_yes"
                                                       name="is_default" value="1" {{ old('is_default', $website->is_default) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                       for="is_default_yes">{{ __('DawnstarLang::general.yes') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="is_default_no"
                                                       name="is_default" value="2" {{ old('is_default', $website->is_default) == 2 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                       for="is_default_no">{{ __('DawnstarLang::general.no') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::website.labels.name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name', $website->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::website.labels.slug') }}</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   value="{{ old('slug', $website->slug) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="languages">{{ __('DawnstarLang::website.labels.languages') }}</label>
                                            <select class="form-control w-100" id="languages" name="languages[]" multiple>
                                                @foreach($languages as $language)
                                                    @php
                                                        $isSelected = in_array($language->id, old('languages', $website->languages->pluck('id')->toArray()));
                                                    @endphp
                                                    <option value="{{ $language->id }}" {{ $isSelected ? 'selected' : '' }}>
                                                        {{ $language->name . ' (' . strtoupper($language->code) . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="default_language">{{ __('DawnstarLang::website.labels.default_language') }}</label>
                                            <select class="form-control" id="default_language" name="default_language">
                                                @foreach($website->languages as $language)
                                                    <option value="{{ $language->id }}" {{ old('default_language', $website->defaultLanguage()->id) == $language->id ? 'selected' : '' }}>
                                                        {{ $language->name . ' (' . strtoupper($language->code) . ')' }}
                                                    </option>
                                                @endforeach
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
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#languages').select2({
            language: 'tr', //TODO Get From session website language
            multiple: true,
            matcher: languageSearch
        });

        $('#languages').change(function () {
            var values = $(this).val();
            var content = "";

            $.each(values, function (k, value) {
                var element = $('#languages').find('option[value="' + value + '"]');
                var selected = (value == $('#default_language').val() ? 'selected' : '');
                content += '<option value="' + value + '" ' + selected + '>' + element.html() + '</option>'
            });

            $('#default_language').html(content);
        });

        function languageSearch(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }

            var temp = data.text.toLowerCase();
            var searchTemp = params.term.toLowerCase();
            if (temp.indexOf(searchTemp) > -1) {
                return $.extend({}, data, true);
            }
            return null;
        }
    </script>
@endpush
