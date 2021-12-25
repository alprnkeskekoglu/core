@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::website.title.edit')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.websites.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Core::general.back')
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.websites.update', $website) }}" id="websiteUpdate" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label">@lang('Core::website.labels.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status', $website->status) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">@lang('Core::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status', $website->status) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_0">@lang('Core::general.status_options.0')</label>
                                    </div>
                                    @error('status')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">@lang('Core::website.labels.default')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="default_1" name="default" class="form-check-input @error('default') is-invalid @enderror" value="1" {{ old('default', $website->default) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default_1">@lang('Core::general.yes')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="default_0" name="default" class="form-check-input @error('default') is-invalid @enderror" value="0" {{ $website->default == 1 ? 'disabled' : '' }} {{ old('default', $website->default) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default_0">@lang('Core::general.no')</label>
                                    </div>
                                    @error('default')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $website->name) }}"/>
                                    <label for="name">@lang('Core::website.labels.name')</label>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain" name="domain" value="{{ old('domain', $website->domain) }}"/>
                                    <label for="domain">@lang('Core::website.labels.domain')</label>
                                    @error('domain')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="select2 form-select select2-multiple" data-toggle="select2" id="languages" name="languages[]" multiple data-placeholder="@lang('Core::general.select')...">
                                        @foreach($languages as $language)
                                            <option {{ in_array($language->id, old('languages', $selectedLanguages->pluck('id')->toArray())) ? 'selected' : '' }} value="{{ $language->id }}">{{ $language->native_name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="languages">@lang('Core::website.labels.languages')</label>

                                    @error('languages')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('default_language') is-invalid @enderror" id="default_language" name="default_language">
                                        @foreach($selectedLanguages as $language)
                                            <option {{ $language->id === $website->defaultLanguage()->id ? 'selected' : '' }} value="{{ $language->id }}">{{ $language->native_name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="default_language">@lang('Core::website.labels.default_language')</label>
                                    @error('default_language')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="websiteUpdate">@lang('Core::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.select2').select2();
        $('.select2-selection--multiple').addClass('form-select');

        $('#languages').change(function () {
            var values = $(this).val();
            var content = "";

            $.each(values, function (k, value) {
                var element = $('#languages').find('option[value="' + value + '"]');
                var selected = (value == $('#default_language').val() ? 'selected' : '');
                content += '<option value="' + value + '" ' + selected + '>' + element.html() + '</option>';
            });

            $('#default_language').html(content);
        });

        @error('languages')
        $('.select2-selection--multiple').addClass('is-invalid').attr('style', 'border-color: #ff5b5b !important');
        @enderror
        @if($errors->any())
        $('#languages').trigger('change');
        @endif
        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
