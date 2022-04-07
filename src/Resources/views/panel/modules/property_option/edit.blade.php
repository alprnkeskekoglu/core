@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::property.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        @include('Core::includes.buttons.back', ['route' => route('dawnstar.structures.properties.index', $structure)])
                        @if(auth('admin')->user()->hasRole('Super Admin'))
                            <a href="{{ route('dawnstar.module_builders.edit', $structure->moduleBuilder('property')) }}" class="btn btn-secondary">
                                @lang('ModuleBuilder::general.title.index')
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <button type="button" class="btn btn-dark mb-2" id="orderSaveBtn">
                                <i class="mdi mdi-order-numeric-ascending"></i>
                                @lang('Core::property.order_save')
                            </button>

                            <div class="dd" id="propertyList">
                                <ol class="dd-list">
                                    @foreach($propertyOptions as $propertyOption)
                                        <li class="dd-item" data-id="{{ $propertyOption->id }}">
                                            <div class="float-end" style="padding: 0.65rem">
                                                <i class="mdi mdi-18px mdi-circle text-{{ $propertyOption->status == 1 ? 'success' : 'danger' }}"></i>
                                                <a href="{{ route('dawnstar.structures.properties.options.edit', [$structure, $property, $propertyOption]) }}" class="text-secondary">
                                                    <i class="mdi mdi-18px mdi-pencil"></i>
                                                </a>
                                                <form action="{{ route('dawnstar.structures.properties.options.destroy', [$structure, $property, $propertyOption]) }}" method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn action-icon p-0">
                                                        <i class="mdi mdi-18px mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="dd-handle bg-white py-2 ps-3 rounded-1" style="height: 45px">{{ $propertyOption->translation->name }}</div>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <form action="{{ route('dawnstar.structures.properties.options.update', [$structure, $property, $option]) }}" id="categoryUpdate" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="d-flex">
                                            @foreach($languages as $language)
                                                <div class="ms-1">
                                                    <button type="button" class="btn btn-outline-secondary p-1 languageBtn{{ $loop->first ? ' active' : '' }}"
                                                            data-language="{{ $language->id }}" {{ old('languages.' . $language->id, $activeLanguageIds[$language->id]) == 1 ? '' : 'disabled' }}>
                                                        <img src="{{ languageFlag($language->code) }}" width="25"> {{ strtoupper($language->code) }}
                                                    </button>
                                                    <span class="btn-language-status {{ old('languages.' . $language->id, $activeLanguageIds[$language->id]) == 1 ? 'bg-danger' : 'bg-success' }}" data-status="{{ $activeLanguageIds[$language->id] }}">
                                                        <i class="mdi {{ old('languages.' . $language->id, $activeLanguageIds[$language->id]) == 1 ? 'mdi-close' : 'mdi-check' }}"></i>
                                                    </span>
                                                    <input type="hidden" name="languages[{{ $language->id }}]" value="{{ old('languages.' . $language->id, $activeLanguageIds[$language->id]) }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {!! $moduleBuilder->html() !!}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="categoryUpdate">@lang('Core::general.save')</button>
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
    <script src="{{ asset('vendor/dawnstar/core/js/slugify.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/plugins/nestable/nestable.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#propertyList').nestable({
                maxDepth: 1
            });
        });
        $('#orderSaveBtn').on('click', function () {
            $.ajax({
                url: '{{ route('dawnstar.structures.properties.options.saveOrder', [$structure, $property]) }}',
                method: 'POST',
                data: {
                    'data': $('#propertyList').nestable('serialize'),
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    showMessage('success', '', '@lang('Core::property.success.order')')
                },
                error: function (response) {
                    showMessage('error', 'Oops...', '')
                }
            })
        });

        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
        @if(session('success'))
        showMessage('success', '', '{{ session('success') }}')
        @endif
    </script>
@endpush
