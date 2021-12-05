@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::menu.title.create')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dawnstar.menus.store') }}" id="menuStore" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-label">@lang('Dawnstar::menu.labels.status')</label>
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
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"/>
                                    <label for="name">@lang('Dawnstar::menu.labels.name')</label>
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
                                    <label for="key">@lang('Dawnstar::menu.labels.key')</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" form="menuStore">@lang('Dawnstar::general.save')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#name').on('keyup', function () {
            $('#key').val(slugify($(this).val()));
        })

        @if($errors->any())
            showMessage('error', 'Oops...', '')
        @endif
    </script>
@endpush
