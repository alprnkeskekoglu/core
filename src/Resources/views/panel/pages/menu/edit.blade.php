@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $menu->name }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.menus.update', ['id' => $menu->id]) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.menus.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-sm-10 col-md-8">

                                <div class="form-group">
                                    <label class="d-block">{{ __('DawnstarLang::menu.labels.status') }}</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_active" name="status" value="1" {{ old('status', $menu->status) == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_draft" name="status" value="2" {{ old('status', $menu->status) == 2 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_passive" name="status" value="3" {{ old('status', $menu->status) == 3 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::menu.labels.name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::menu.labels.key') }}</label>
                                            <input type="text" class="form-control form-control-alt" id="key" disabled="disabled" value="{{ $menu->key }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('#name').on('keyup', function () {
            var value = $(this).val();
            $('#key').val(slugify(value));
        });

        slugify = function (text) {
            var map = {
                'çÇ': 'c',
                'ğĞ': 'g',
                'şŞ': 's',
                'üÜ': 'u',
                'ıİ': 'i',
                'öÖ': 'o'
            };
            for (var key in map) {
                text = text.replace(new RegExp('[' + key + ']', 'g'), map[key]);
            }
            return text.replace(/[^-a-zA-Z0-9\s]+/ig, '')
                .replace(/\s/gi, "-")
                .replace(/[-]+/gi, "-")
                .toLowerCase();
        }
    </script>
@endpush
