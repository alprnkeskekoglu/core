@extends('Core::layouts.app')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="text-center">
                <h1 class="text-error mt-4">403</h1>
                <a class="btn btn-info mt-3" href="{{ route('dawnstar.dashboard.index') }}"><i class="mdi mdi-reply"></i> @lang('Core::dashboard.title')</a>
            </div>
        </div>
    </div>
@endsection
