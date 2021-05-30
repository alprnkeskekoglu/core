@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded">
                <div class="hero-inner">
                    <div class="content content-full">
                        <div class="px-3 py-5 text-center text-sm-left">
                            <div class="display-1 text-warning font-w700 invisible" data-toggle="appear">403</div>
                            <h1 class="h2 font-w700 mt-5 mb-3 invisible" data-toggle="appear" data-class="animated fadeInUp" data-timeout="300">@lang('DawnstarLang::permission.error.title')</h1>
                            <h2 class="h3 font-w400 mb-5 invisible" data-toggle="appear" data-class="animated fadeInUp" data-timeout="450">@lang('DawnstarLang::permission.error.desc')</h2>
                            <div class="invisible" data-toggle="appear" data-class="animated fadeInUp" data-timeout="600">
                                <a class="btn btn-hero-light" href="{{ route('dawnstar.dashboard') }}">
                                    <i class="fa fa-arrow-left mr-1"></i> @lang('DawnstarLang::permission.error.back_dashboard')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
