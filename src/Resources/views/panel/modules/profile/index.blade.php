@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::admin_action.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dawnstar.profile.update') }}" id="profileUpdate" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                @include('MediaManager::includes.media_box',['label' => __('Core::admin.labels.avatar'), 'medias' => $admin->mc_avatar, 'key' => 'avatar', 'max_count' => '1'])
                            </div>
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $admin->first_name) }}"/>
                                    <label for="name">@lang('Core::admin.labels.first_name')</label>
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $admin->last_name) }}"/>
                                    <label for="name">@lang('Core::admin.labels.last_name')</label>
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"/>
                                    <label for="password">@lang('Core::admin.labels.password')</label>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"/>
                                    <label for="password_confirmation">@lang('Core::admin.labels.password_confirmation')</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="profileUpdate">@lang('Core::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/media-manager/assets/js/media-manager.js') }}"></script>
    <script>
        @if($errors->any())
        showMessage('error', 'Oops...', '')
        @endif
        @if(session('success'))
        showMessage('success', '', '{{ session('success') }}')
        @endif
    </script>
@endpush

