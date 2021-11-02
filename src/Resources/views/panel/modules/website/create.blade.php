@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::website.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.websites.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Dawnstar::general.back')
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dawnstar.websites.store') }}" id="websiteStore" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <label class="form-label">@lang('Dawnstar::website.labels.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status') == 0 ? 'checked' : '' }}>
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
                                <label class="form-label">@lang('Dawnstar::website.labels.default')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="default_1" name="default" class="form-check-input @error('default') is-invalid @enderror" value="1" {{ old('default') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default_1">@lang('Dawnstar::general.yes')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="default_0" name="default" class="form-check-input @error('default') is-invalid @enderror" value="0" {{ old('default', 0) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default_0">@lang('Dawnstar::general.no')</label>
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
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"/>
                                    <label for="name">@lang('Dawnstar::website.labels.name')</label>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain" name="domain" value="{{ old('domain') }}"/>
                                    <label for="domain">@lang('Dawnstar::website.labels.domain')</label>
                                    @error('domain')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select class="select2 form-select select2-multiple" data-toggle="select2" id="languages" name="languages[]" multiple data-placeholder="@lang('Dawnstar::general.select')...">
                                        @foreach($languages as $language)
                                            <option {{ in_array($language->id, old('languages', [])) ? 'selected' : '' }} value="{{ $language->id }}">{{ $language->native_name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="languages">@lang('Dawnstar::website.labels.languages')</label>

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
                                    </select>
                                    <label for="default_language">@lang('Dawnstar::website.labels.default_language')</label>
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
                    <button type="submit" class="btn btn-primary" form="websiteStore">@lang('Dawnstar::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .select2-selection__rendered {
            padding: 0 !important;
        }

        span.selection {
            position: relative;
        }

        .selection > .select2-selection--multiple {
            padding-top: 1.2rem;
            padding-bottom: .1rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('.select2-selection--multiple').addClass('form-select');

        $('#languages').change(function () {
            var values = $(this).val();
            var content = "";

            $.each(values, function (k, value) {
                var element = $('#languages').find('option[value="' + value + '"]');
                content += '<option value="' + value + '">' + element.html() + '</option>';
            });

            $('#default_language').html(content);
        });

        @error('languages')
        $('.select2-selection--multiple').addClass('is-invalid').attr('style', 'border-color: #ff5b5b !important');
        @enderror
        @if($errors->any())
        $('#languages').trigger('change');
        @endif
    </script>
@endpush
