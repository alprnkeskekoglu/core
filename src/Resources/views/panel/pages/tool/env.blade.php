@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::website.edit_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content w-75">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.tool.env.update') }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <textarea class="form-control" name="env" rows="50">{!! $env !!}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
