@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::category.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-7">
                            <button type="button" class="btn btn-dark mb-2" id="orderSaveBtn">
                                <i class="mdi mdi-order-numeric-ascending"></i>
                                @lang('Core::category.order_save')
                            </button>
                            <div class="dd" id="menuList">
                                @include('Core::modules.category.items')
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <form action="{{ route('dawnstar.structures.categories.update', [$structure, $category]) }}" id="categoryUpdate" method="POST">
                                @method('PUT')
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
                                    <hr class="mt-3">
                                    {!! $moduleBuilder->metaTagHtml() !!}
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
            $('#menuList').nestable({
                maxDepth: 4
            });
        });

        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
        @if(session('success'))
        showMessage('success', '', '{{ session('success') }}')
        @endif
    </script>
@endpush
