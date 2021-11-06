@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::admin.title.create')])
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
                    <form action="{{ route('dawnstar.structures.store') }}" id="adminStore" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">@lang('Dawnstar::structure.labels.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-secondary">
                                        <input type="radio" id="status_2" name="status" class="form-check-input @error('status') is-invalid @enderror" value="2" {{ old('status', 2) == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_2">@lang('Dawnstar::general.status_options.2')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status', 2) == 0 ? 'checked' : '' }}>
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
                                    <select class="form-select" id="type" name="type">
                                        <option value="">@lang('Dawnstar::general.select')</option>
                                        <option value="homepage" {{ old('type') == 'homepage' ? 'selected' : '' }}>
                                            @lang('Dawnstar::structure.labels.types.homepage')
                                        </option>
                                        <option value="search" {{ old('type') == 'search' ? 'selected' : '' }}>
                                            @lang('Dawnstar::structure.labels.types.search')
                                        </option>
                                        <option value="dynamic" {{ old('type') == 'dynamic' ? 'selected' : '' }}>
                                            @lang('Dawnstar::structure.labels.types.dynamic')
                                        </option>
                                        <option value="static" {{ old('type') == 'static' ? 'selected' : '' }}>
                                            @lang('Dawnstar::structure.labels.types.static')
                                        </option>
                                    </select>
                                    <label for="type">@lang('Dawnstar::structure.labels.type')</label>
                                    @error('type')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key') }}"/>
                                    <label for="name">@lang('Dawnstar::admin.labels.key')</label>
                                    @error('key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_detail" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_detail" name="has_detail" value="1">
                                    <label class="form-check-label" for="has_detail">@lang('Dawnstar::admin.labels.has_detail')</label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_category" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_category" name="has_category" value="1">
                                    <label class="form-check-label" for="has_category">@lang('Dawnstar::admin.labels.has_category')</label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_property" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_property" name="has_property" value="1">
                                    <label class="form-check-label" for="has_property">@lang('Dawnstar::admin.labels.has_property')</label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="has_url" value="0">
                                    <input type="checkbox" class="form-check-input" id="has_url" name="has_url" value="1">
                                    <label class="form-check-label" for="has_url">@lang('Dawnstar::admin.labels.has_url')</label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check form-large-check">
                                    <input type="hidden" name="is_searchable" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_searchable" name="is_searchable" value="1">
                                    <label class="form-check-label" for="is_searchable">@lang('Dawnstar::admin.labels.is_searchable')</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 mb-3">
                                <div class="d-flex justify-content-end">
                                    @foreach($languages as $language)
                                    <div>
                                        <input type="radio" class="btn-check" name="language" value="{{ $language->id }}" id="language_{{ $language->id }}" autocomplete="off" {{ $loop->first ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary btn-language border-0 rounded-3 p-1 text-black" for="language_{{ $language->id }}">
                                            <img src="{{ languageFlag($language->code) }}" width="25"> {{ strtoupper($language->code) }}
                                        </label>
                                        <span class="btn-language-status bg-danger"><i class="mdi mdi-close"></i></span>
                                    </div>
                                    @endforeach

                                    <div>
                                        <input type="radio" class="btn-check" name="language" value="2" id="langauge_2" disabled autocomplete="off">
                                        <label class="btn btn-outline-secondary btn-language border-0 rounded-3 p-1 text-black" for="langauge_2">
                                            <img src="//flagcdn.com/h20/tr.png" width="25"> TR
                                        </label>
                                        <span class="btn-language-status bg-success"><i class="mdi mdi-check"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name"/>
                                    <label for="name">Name (TR)</label>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="slug" name="slug" required/>
                                    <label for="name">Slug (TR)</label>
                                    <span class="help-block text-muted">/tr/</span>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div> <!-- end card-body -->
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    @if($errors->any())
        <script>
            showMessage('error', 'Oops...', '')
        </script>
    @endif
@endpush
