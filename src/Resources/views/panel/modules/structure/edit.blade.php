@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::structure.title.edit')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.admins.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Dawnstar::general.back')
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.structures.update', $structure) }}" id="structureUpdate" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">@lang('Dawnstar::structure.labels.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status', $structure->status) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-secondary">
                                        <input type="radio" id="status_2" name="status" class="form-check-input @error('status') is-invalid @enderror" value="2" {{ old('status', $structure->status) == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_2">@lang('Dawnstar::general.status_options.2')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status', $structure->status) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_0">@lang('Dawnstar::general.status_options.0')</label>
                                    </div>
                                    @error('status')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="type" name="type" value="{{ $structure->type }}" readonly/>
                                    <label for="name">@lang('Dawnstar::structure.labels.type')</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="key" name="key" value="{{ $structure->key }}" readonly/>
                                    <label for="name">@lang('Dawnstar::structure.labels.key')</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_detail" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_detail" name="has_detail" value="1" {{ old('has_detail', $structure->has_detail) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_detail">@lang('Dawnstar::structure.labels.has_detail')</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_category" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_category" name="has_category" value="1" {{ old('has_category', $structure->has_category) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_category">@lang('Dawnstar::structure.labels.has_category')</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_property" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_property" name="has_property" value="1" {{ old('has_property', $structure->has_property) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_property">@lang('Dawnstar::structure.labels.has_property')</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_url" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_url" name="has_url" value="1" {{ old('has_url', $structure->has_url) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_url">@lang('Dawnstar::structure.labels.has_url')</label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="is_searchable" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_searchable" name="is_searchable" value="1" {{ old('is_searchable', $structure->is_searchable) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_searchable">@lang('Dawnstar::structure.labels.is_searchable')</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4 mt-3">
                            <div class="col-lg-12 mb-3">
                                <div class="d-flex">
                                    @foreach($languages as $language)
                                        @php
                                            $translation = $structure->container->translations()->where('language_id', $language->id)->first();
                                        @endphp
                                        <div class="ms-1">
                                            <button type="button" class="btn btn-outline-secondary p-1 languageBtn{{ $loop->first ? ' active' : '' }}" data-language="{{ $language->id }}" {{ old('languages.' . $language->id, $translation->status) == 1 ? '' : 'disabled' }}>
                                                <img src="{{ languageFlag($language->code) }}" width="25"> {{ strtoupper($language->code) }}
                                            </button>
                                            <span class="btn-language-status {{ old('languages.' . $language->id, $translation->status) == 1 ? 'bg-danger' : 'bg-success' }}" data-status="1">
                                                <i class="mdi {{ old('languages.' . $language->id, $translation->status) == 1 ? 'mdi-close' : 'mdi-check' }}"></i>
                                            </span>
                                            <input type="hidden" name="languages[{{ $language->id }}]" value="{{ $translation->status ?: 0 }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @foreach($languages as $language)
                                    @php
                                        $translation = $structure->container->translations()->where('language_id', $language->id)->first();
                                    @endphp
                                    <div class="form-floating mb-3 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                                        <input type="text" class="form-control nameInput @if($errors->has('translations.' . $language->id . '.name')) is-invalid @endif"
                                               id="translations_{{ $language->id }}_name"
                                               name="translations[{{ $language->id }}][name]"
                                               value="{{ old('translations.'.$language->id.'.name', $translation->name) }}"
                                               data-language="{{ $language->id }}"/>
                                        <label for="translations_{{ $language->id }}_name">@lang('Dawnstar::container.labels.name') ({{ strtoupper($language->code) }})</label>
                                        @if($errors->has('translations.' . $language->id . '.name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('translations.' . $language->id . '.name') }}
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-6">
                                @foreach($languages as $language)
                                    <div class="form-floating mb-3 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                                        <input type="text" class="form-control slugInput @if($errors->has('translations.' . $language->id . '.slug')) is-invalid @endif"
                                               id="translations_{{ $language->id }}_slug"
                                               name="translations[{{ $language->id }}][slug]"
                                               value="{{ old('translations.'.$language->id.'.slug', $translation->slug) }}"
                                               data-language="{{ $language->id }}"/>
                                        <label for="translations_{{ $language->id }}_slug">@lang('Dawnstar::container.labels.slug') ({{ strtoupper($language->code) }})</label>
                                        <div class="help-block text-muted ms-2">/{{ $language->code }}<span>{{ old('translations.'.$language->id.'.slug', $translation->slug) }}</span></div>
                                        @error('translations.' . $language->id . '.slug')
                                        <div class="invalid-feedback">
                                            {{ $errors->first('translations.' . $language->id . '.slug') }}
                                        </div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="structureUpdate">@lang('Dawnstar::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $('.languageBtn').on('click', function () {
            var language = $(this).data('language');
            $('.languageBtn').removeClass('active');
            $(this).addClass('active');

            $('.hasLanguage').addClass('d-none');
            $('.hasLanguage[data-language="' + language + '"]').removeClass('d-none');
        });

        $('.btn-language-status').on('click', function () {
            var status = $(this).data('status');

            if (status == 0) {
                $(this).addClass('bg-danger').removeClass('bg-success');
                $(this).find('i').addClass('mdi-close').removeClass('mdi-check');
                $(this).data('status', 1);
                $(this).parent().find('input').val(1);
                $(this).parent().find('button').prop('disabled', false);
            } else if (status == 1) {
                $(this).addClass('bg-success').removeClass('bg-danger');
                $(this).find('i').addClass('mdi-check').removeClass('mdi-close');
                $(this).data('status', 0);
                $(this).parent().find('input').val(0);
                $(this).parent().find('button').prop('disabled', true);
            }
        });

        var typingTimer;
        var doneTypingInterval = 250;
        var typedInput;
        $('body').delegate('.nameInput', 'keyup', function () {
            clearTimeout(typingTimer);
            typedInput = $(this);

            var languageId = typedInput.data('language');

            if(typedInput.val().length && $('#type').val() != 'homepage') {
                typingTimer = setTimeout(getUrl, doneTypingInterval);
            } else {
                $('.slugInput[data-language="' + languageId + '"]').val('/');
            }
        });

        $('body').delegate('.nameInput', 'keydown', function () {
            clearTimeout(typingTimer);
        });

        $('body').delegate('.slugInput', 'keyup', function () {
            $(this).parent().find('div.help-block > span').html($(this).val())
        });

        function getUrl() {
            var name = typedInput.val();
            var languageId = typedInput.attr('data-language');

            $.ajax({
                'url': '{{ route('dawnstar.getUrl') }}',
                'data': {'language_id': languageId, 'name': name},
                'method': 'GET',
                success: function (response) {
                    $('.slugInput[data-language="' + languageId + '"]').val('/' + response).trigger('keyup');
                },
            });
        }

        $(document).ready(function () {
            updateOptions($('#type').val());
        })

        $('#type').on('change', function () {
            var value = $(this).val();

            $('#key').val('').attr('readonly', false);
            $('#has_detail, #has_category, #has_property, #has_url, #is_searchable').prop('checked', false);
            $('#has_detail, #has_category, #has_property, #has_url, #is_searchable').prop('disabled', false);

            updateOptions(value);
        });

        function updateOptions(value) {
            if(value == 'homepage') {
                $('#key').val('homepage').prop('readonly', true);
                $('#has_detail, #has_url').prop('checked', true);
                $('#has_category, #has_property, #is_searchable').prop('disabled', true);
                $('.slugInput').val('/');
            } else if(value == 'search') {
                $('#key').val('search').prop('readonly', true);
                $('#has_url').prop('checked', true);
                $('#has_detail, #has_category, #has_property, #is_searchable').prop('disabled', true);
            } else if(value == 'static') {
                $('#has_category, #has_property').prop('disabled', true);
            }
        }


        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
