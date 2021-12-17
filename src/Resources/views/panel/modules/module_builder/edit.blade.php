@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::module_builder.title.index')])
    <div class="row" id="moduleBuilder">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dawnstar.module_builders.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i>
                            @lang('Dawnstar::general.back')
                        </a>
                        <div>
                            <buttons-component></buttons-component>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <builder-component></builder-component>
                        </div>
                    </div>
                    <element-modal-component></element-modal-component>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.module_builder_id = '{{ $moduleBuilder->id }}'
        window.language_id = '{{ session('dawnstar.language.id') }}'
    </script>
    <script src="{{ asset('vendor/dawnstar/assets/js/builder.js') }}"></script>
@endpush
