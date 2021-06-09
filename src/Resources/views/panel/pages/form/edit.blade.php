@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $form->name }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.forms.update', $form) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.forms.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                    <label class="d-block">{{ __('DawnstarLang::form.labels.status') }}</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_active" name="status" value="1" {{ old('status', $form->status) == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_draft" name="status" value="2" {{ old('status', $form->status) == 2 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                        <input type="radio" class="custom-control-input" id="status_passive" name="status" value="3" {{ old('status', $form->status) == 3 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::form.labels.name') }}</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $form->name) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::form.labels.key') }}</label>
                                            <input type="text" class="form-control form-control-alt" id="key" disabled="disabled" value="{{ $form->key }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sender">{{ __('DawnstarLang::form.labels.sender') }}</label>
                                            <input type="text" class="form-control" id="sender" name="sender" value="{{ old('sender', $form->sender) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="receivers">{{ __('DawnstarLang::form.labels.receivers') }}</label>
                                            <input type="text" class="form-control" id="receivers" name="receivers" value="{{ old('receivers', implode(',', $form->receivers)) }}">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="d-block">{{ __('DawnstarLang::form.labels.recaptcha_status') }}</label>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="recapthca_status_active" name="recaptcha_status" value="1" {{ old('recaptcha_status', $form->recaptcha_status) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="recapthca_status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="recapthca_status_passive" name="recaptcha_status" value="3" {{ old('recaptcha_status', $form->recaptcha_status) == 3 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="recapthca_status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 {{ $form->recaptcha_status == 1 ? '' : 'd-none' }} recaptchaDiv">
                                        <div class="form-group">
                                            <label for="recaptcha_site_key">{{ __('DawnstarLang::form.labels.recaptcha_site_key') }}</label>
                                            <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $form->recaptcha_site_key) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 {{ $form->recaptcha_status == 1 ? '' : 'd-none' }} recaptchaDiv">
                                        <div class="form-group">
                                            <label for="recaptcha_secret_key">{{ __('DawnstarLang::form.labels.recaptcha_secret_key') }}</label>
                                            <input type="text" class="form-control" id="recaptcha_secret_key" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key', $form->recaptcha_secret_key) }}">
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

        $('[name="recaptcha_status"]').change(function () {
            if($(this).val() == 1) {
                $('.recaptchaDiv').removeClass('d-none');
            } else {
                $('.recaptchaDiv').addClass('d-none');
            }
        })

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
