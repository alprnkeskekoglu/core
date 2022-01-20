@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::category.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        @include('Core::includes.buttons.back', ['route' => route('dawnstar.structures.pages.index', $structure)])
                        @if(auth('admin')->user()->hasRole('Super Admin'))
                            <a href="{{ route('dawnstar.module_builders.edit', $structure->moduleBuilder('category')) }}" class="btn btn-secondary">
                                @lang('ModuleBuilder::general.title.index')
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-dark mb-2" id="orderSaveBtn">
                                <i class="mdi mdi-order-numeric-ascending"></i>
                                @lang('Core::category.order_save')
                            </button>
                            <div class="dd" id="categoryList">
                                @include('Core::modules.category.items')
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <form action="{{ route('dawnstar.structures.categories.store', [$structure]) }}" id="categoryStore" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="d-flex">
                                            @foreach($languages as $language)
                                                <div class="ms-1">
                                                    <button type="button" class="btn btn-outline-secondary p-1 languageBtn{{ $loop->first ? ' active' : '' }}" data-language="{{ $language->id }}" {{ old('languages.' . $language->id, 1) == 1 ? '' : 'disabled' }}>
                                                        <img src="{{ languageFlag($language->code) }}" width="25"> {{ strtoupper($language->code) }}
                                                    </button>
                                                    <span class="btn-language-status {{ old('languages.' . $language->id, 1) == 1 ? 'bg-danger' : 'bg-success' }}" data-status="1"><i class="mdi {{ old('languages.' . $language->id, 1) == 1 ? 'mdi-close' : 'mdi-check' }}"></i></span>
                                                    <input type="hidden" name="languages[{{ $language->id }}]" value="{{ old('languages.' . $language->id, 1) }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {!! $moduleBuilder->html() !!}
                                    @if($structure->has_property)
                                        <hr class="mt-3">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <select class="select2 form-select select2-multiple" data-toggle="select2" id="properties" name="properties[]" multiple>
                                                    @foreach($properties as $property)
                                                        <option value="{{ $property->id }}">{!! $property->translation->name !!}</option>
                                                    @endforeach
                                                </select>
                                                <label for="properties">@lang('Core::category.labels.properties')</label>
                                            </div>
                                        </div>
                                    @endif
                                    {!! $moduleBuilder->metaTagHtml() !!}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="categoryStore">@lang('Core::general.save')</button>
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
            $('.select2-selection--multiple').addClass('form-select');
            $('#categoryList').nestable({
                maxDepth: 4
            });
        });
        $('#orderSaveBtn').on('click', function () {
            $.ajax({
                url: '{{ route('dawnstar.structures.categories.saveOrder', $structure) }}',
                method: 'POST',
                data: {
                    'data': $('#categoryList').nestable('serialize'),
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    showMessage('success', '', '@lang('Core::category.success.order')')
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
