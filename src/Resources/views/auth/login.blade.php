<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dawnstar</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('vendor/dawnstar/assets/css/dashmix.min.css') }}">
</head>
<body>
<div id="page-container">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('assets/media/photos/photo22@2x.jpg');">
            <div class="row no-gutters bg-primary-op">
                <div class="hero-static col-md-6 d-flex align-items-center bg-white">
                    <div class="p-3 w-100">
                        <div class="mb-3 text-center">
                            <a class="link-fx font-w700 font-size-h1" href="index.html">
                                <span class="text-dark">Dawn</span><span class="text-primary">star</span>
                            </a>
                            <p class="font-w700 font-size-sm text-muted">{{ __('DawnstarLang::auth.sign_in') }}</p>
                        </div>

                        <div class="row no-gutters justify-content-center">
                            <div class="col-sm-8 col-xl-6">
                                @include('DawnstarView::layouts.alerts')
                                <form action="{{ route('dawnstar.auth.login') }}" method="POST">
                                    @csrf
                                    <div class="py-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg form-control-alt" id="email" name="email" placeholder="{{ __('DawnstarLang::auth.email') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="{{ __('DawnstarLang::auth.password') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                                            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> {{ __('DawnstarLang::auth.sign_in') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                    <div class="p-3">
                        <p class="display-4 font-w700 text-white mb-3">
                            {{ __('DawnstarLang::auth.banner_title') }}
                        </p>
                        <p class="font-size-lg font-w600 text-white-75 mb-0">
                            Copyright &copy; <span data-toggle="year-copy"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="{{ asset('vendor/dawnstar/assets/js/dashmix.core.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/assets/js/dashmix.app.min.js') }}"></script>
</body>
</html>
