@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::page.title.edit')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        @include('Core::includes.buttons.back', ['route' => route('dawnstar.structures.pages.index', $structure)])
                        @if(auth('admin')->user()->hasRole('Super Admin'))
                            <a href="{{ route('dawnstar.module_builders.edit', $structure->moduleBuilder('page')) }}" class="btn btn-secondary">
                                @lang('ModuleBuilder::general.title.index')
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.structures.pages.update', [$structure, $page]) }}" id="pageUpdate" method="POST">
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
                            {!! $moduleBuilder->metaTagHtml() !!}
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="pageUpdate">@lang('Core::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendor/dawnstar/core/js/language-button.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/js/slugify.js') }}"></script>
    <script>
        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
