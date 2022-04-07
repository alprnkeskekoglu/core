@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => $container->translation->name])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        @if($structure->type == 'dynamic')
                            @include('Core::includes.buttons.back', ['route' => route('dawnstar.structures.pages.index', $structure)])
                        @endif
                        @if(auth('admin')->user()->hasRole('Super Admin'))
                            <a href="{{ route('dawnstar.module_builders.edit', $structure->moduleBuilder('container')) }}" class="btn btn-secondary">
                                @lang('ModuleBuilder::general.title.index')
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.structures.containers.update', [$structure, $container]) }}" id="containerUpdate" method="POST">
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
                            {!! $moduleBuilder->metaTagHtml() !!}
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="containerUpdate">@lang('Core::general.save')</button>
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
