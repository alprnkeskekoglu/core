@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::website.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dawnstar.websites.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label">@lang('Dawnstar::general.status')</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="status_1" name="status" class="form-check-input" value="1" checked required>
                                        <label class="form-check-label" for="status_1">@lang('Dawnstar::general.status_options.1')</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="status_0" name="status" class="form-check-input" value="0" required>
                                        <label class="form-check-label" for="status_0">@lang('Dawnstar::general.status_options.0')</label>
                                    </div>
                                    <div class="invalid-feedback">
                                        @lang('Dawnstar::general.required')
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Is Default Website?</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline form-radio-success">
                                        <input type="radio" id="default_1" name="default" class="form-check-input" value="1" required>
                                        <label class="form-check-label" for="default_1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline form-radio-danger">
                                        <input type="radio" id="default_0" name="default" class="form-check-input" value="0" required>
                                        <label class="form-check-label" for="default_0">No</label>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" required/>
                                    <label for="name">Name</label>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="domain" name="domain" required/>
                                    <label for="domain">Domain</label>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="select2 form-select select2-multiple" data-toggle="select2" name="languages[]" multiple data-placeholder="Choose ...">
                                        <option value="CA">California</option>
                                        <option value="NV">Nevada</option>
                                        <option value="OR">Oregon</option>
                                        <option value="WA">Washington</option>
                                    </select>
                                    <label class="form-label" for="languages">Languages</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="default_language_id" name="default_language_id">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <label for="default_language_id">Default Language</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div> <!-- end card-body -->
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .select2-selection__rendered{
            padding: 0 !important;
        }
        span.selection{
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
        $('.select2-selection--multiple').addClass('form-select');
    </script>
@endpush
