@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::menu_item.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        @foreach(session('dawnstar.languages') as $language)
                            <li class="nav-item">
                                <a href="{{ route('dawnstar.menus.items.index', [$menu, 'language_id' => $language->id]) }}" class="nav-link {{ $activeLanguage->id == $language->id ? 'active' : '' }}">
                                    <img src="{{ languageFlag($language->code) }}" width="25"> {{ strtoupper($language->code) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" data-language="{{ $activeLanguage->id }}">
                            <div class="row">
                                <div class="col-lg-7">
                                    <button type="button" class="btn btn-dark mb-2" id="orderSaveBtn">
                                        <i class="mdi mdi-order-numeric-ascending"></i>
                                        @lang('Core::menu_item.order_save')
                                    </button>
                                    <div class="dd" id="menuList">
                                        @include('Core::modules.menu_item.items')
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <form action="{{ route('dawnstar.menus.items.store', $menu) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="language_id" value="{{ $activeLanguage->id }}">
                                        <div class="row">
                                            <div class="col-lg-12 mb-4">
                                                @include('MediaManager::includes.media_box',['label' => __('Core::menu_item.labels.image'), 'key' => 'image', 'max_count' => '1'])
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="form-label">@lang('Core::menu_item.labels.status') ({{ strtoupper($activeLanguage->code) }})</label>
                                                <div class="mb-3">
                                                    <div class="form-check form-check-inline form-radio-success">
                                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="status_1">@lang('Core::general.status_options.1')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline form-radio-danger">
                                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="status_0">@lang('Core::general.status_options.0')</label>
                                                    </div>
                                                    @error('status')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select typeSelect @error('type') is-invalid @enderror" id="type" name="type">
                                                        <option value="">@lang('Core::general.select')</option>
                                                        @for($i = 1; $i <= 3; $i++)
                                                            <option value="{{ $i }}" {{ old('type') == $i ? 'selected' : '' }}>
                                                                @lang('Core::menu_item.types.' . $i)
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <label for="type">@lang('Core::menu_item.labels.type') ({{ strtoupper($activeLanguage->code) }})</label>
                                                    @error('type')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-none" id="urlIdBox">
                                                <div class="form-floating mb-3">
                                                    <select class="select2 form-select @error('url_id') is-invalid @enderror" data-type="select2" id="url_id" name="url_id">
                                                        <option value="">@lang('Core::general.select')</option>
                                                    </select>
                                                    <label for="url_id">@lang('Core::menu_item.labels.url_id') ({{ strtoupper($activeLanguage->code) }})</label>
                                                    @error('url_id')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-none" id="externalLinkBox">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control @error('external_link') is-invalid @enderror" id="external_link" name="external_link" value="{{ old('external_link') }}">
                                                    <label for="external_link">@lang('Core::menu_item.labels.external_link') ({{ strtoupper($activeLanguage->code) }})</label>
                                                    @error('external_link')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-none" id="targetBox">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select @error('target') is-invalid @enderror" id="target" name="target">
                                                        <option value="">@lang('Core::general.select')</option>
                                                        <option value="_self" {{ old('target') == '_self' ? 'selected' : '' }}>@lang('Core::menu_item.targets.self')</option>
                                                        <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>@lang('Core::menu_item.targets.blank')</option>
                                                    </select>
                                                    <label for="target">@lang('Core::menu_item.labels.target') ({{ strtoupper($activeLanguage->code) }})</label>
                                                    @error('target')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                                    <label for="name">@lang('Core::menu_item.labels.name') ({{ strtoupper($activeLanguage->code) }})</label>
                                                    @error('name')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">@lang('Core::general.save')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/core/plugins/nestable/nestable.min.css') }}"/>
@endpush
@push('scripts')
    <script src="{{ asset('vendor/dawnstar/core/js/language-button.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/media-manager/js/media-manager.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/plugins/nestable/nestable.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#menuList').nestable({
                maxDepth: 4
            });


            $('#type').on('change', function () {
                var value = $(this).val();
                var languageId = $(this).closest('.tab-pane').attr('data-language');

                $('#urlIdBox, #externalLinkBox, #targetBox').addClass('d-none');

                if (value == 1) {
                    $('#urlIdBox, #targetBox').removeClass('d-none')
                } else if (value == 2) {
                    $('#externalLinkBox, #targetBox').removeClass('d-none')
                }
            });

            $('select[data-type="select2"]').select2({
                language: '{{ session('dawnstar.language.code') }}',
                ajax: {
                    url: '{{ route('dawnstar.menus.items.getUrls', $menu) }}',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            language_id: $(this).closest('.tab-pane').attr('data-language')
                        }
                        return query;
                    }
                }
            });
            $('.select2-selection').addClass('form-select');

            $('#orderSaveBtn').on('click', function () {
                var languageId = $(this).closest('.tab-pane').attr('data-language');

                $.ajax({
                    url: '{{ route('dawnstar.menus.items.saveOrder', $menu) }}',
                    method: 'POST',
                    data: {
                        'language_id': languageId,
                        'data': $('#menuList').nestable('serialize'),
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        showMessage('success', '', '@lang('Core::menu_item.success.order')')
                    },
                    error: function (response) {
                        showMessage('error', 'Oops...', '')
                    }
                })
            });
        });

        @if($errors->any())
        showMessage('error', 'Oops...', '')
        $('#type').trigger('change');
        @endif
        @if(session('success'))
        showMessage('success', '', '{{ session('success') }}')
        @endif
    </script>
@endpush
