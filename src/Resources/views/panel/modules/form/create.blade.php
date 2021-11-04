@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::form.title.create')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.forms.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Dawnstar::general.back')
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dawnstar.forms.store') }}" id="formStore" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label">@lang('Dawnstar::form.labels.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input @error('status') is-invalid @enderror" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-secondary">
                                        <input type="radio" id="status_2" name="status" class="form-check-input @error('status') is-invalid @enderror" value="2" {{ old('status', 2) == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_2">@lang('Dawnstar::general.status_options.2')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input @error('status') is-invalid @enderror" value="0" {{ old('status', 2) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_0">@lang('Dawnstar::general.status_options.0')</label>
                                    </div>
                                    @error('status')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">@lang('Dawnstar::form.labels.recaptcha_status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="recaş_1" name="recaptcha_status" class="form-check-input @error('recaptcha_status') is-invalid @enderror" value="1" {{ old('recaptcha_status') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="recaptcha_status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="recaptcha_status_0" name="recaptcha_status" class="form-check-input @error('recaptcha_status') is-invalid @enderror" value="0" {{ old('recaptcha_status', 0) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="recaptcha_status_0">@lang('Dawnstar::general.status_options.0')</label>
                                    </div>
                                    @error('recaptcha_status')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"/>
                                    <label for="name">@lang('Dawnstar::form.labels.name')</label>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="key" name="key" value="{{ old('key') }}" readonly/>
                                    <label for="key">@lang('Dawnstar::form.labels.key')</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('sender_email') is-invalid @enderror" id="sender_email" name="sender_email" value="{{ old('sender_email') }}"/>
                                    <label for="sender_email">@lang('Dawnstar::form.labels.sender_email')</label>
                                    @error('sender_email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">

                                    <select class="select2 form-select select2-multiple" id="receiver_emails" name="receiver_emails[]" multiple>
                                        @foreach(old('receiver_emails', []) as $email)
                                            <option value="{{ $email }}" selected>{{ $email }}</option>
                                        @endforeach
                                    </select>
                                    <label for="receiver_emails">@lang('Dawnstar::form.labels.receiver_emails')</label>
                                    @error('receiver_emails')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="formStore">@lang('Dawnstar::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .select2-selection__rendered {
            padding: 0 !important;
        }

        span.selection {
            position: relative;
        }

        .selection > .select2-selection--multiple {
            padding-top: 1.2rem;
            padding-bottom: .1rem;
        }
    </style>
@endpush


@push('scripts')
    <script>
        $('.select2').select2({tags: true});
        $('.select2-selection--multiple').addClass('form-select');

        @error('receiver_emails')
        $('.select2-selection--multiple').addClass('is-invalid').attr('style', 'border-color: #ff5b5b !important');
        @enderror
        @if($errors->any())
        $('#receiver_emails').trigger('change');
        @endif

        $('#name').on('keyup', function () {
            $('#key').val(slugify($(this).val()));
        })

        @if($errors->any())
            showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
