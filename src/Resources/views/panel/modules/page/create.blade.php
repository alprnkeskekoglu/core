@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::page.title.create')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.structures.pages.store', [$structure]) }}" id="pageStore" method="POST">
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
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="pageStore">@lang('Dawnstar::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendor/dawnstar/assets/js/language-button.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/assets/js/slugify.js') }}"></script>
    <script>
        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
