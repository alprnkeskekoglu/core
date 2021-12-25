<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dawnstar | Login</title>

    <link rel="shortcut icon" href="{{ asset('vendor/dawnstar/core/images/favicon.ico') }}">
    <link href="{{ asset('vendor/dawnstar/core/css/icons.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/dawnstar/core/css/app-modern.min.css') }}" rel="stylesheet" id="light-style"/>
</head>

<body class="authentication-bg pb-0">

<div class="auth-fluid">
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">
                <div class="auth-brand text-center text-lg-start">
                    <span><img src="assets/images/logo-dark.png" alt="" height="18"></span>
                </div>

                <h4 class="mt-0">@lang('Core::auth.login')</h4>

                <form action="{{ route('dawnstar.login') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"/>
                        <label for="email">@lang('Core::auth.email')</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"/>
                        <label for="password">@lang('Core::auth.password')</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <!--
                    <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a>
                    -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                            <label class="form-check-label" for="remember">@lang('Core::auth.remember')</label>
                        </div>
                    </div>
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> @lang('Core::auth.login')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3">All In One!</h2>
            <p class="lead">
                <i class="mdi mdi-format-quote-open"></i>
                High-Powered. Quick. Low-Code. High Security.
                <i class="mdi mdi-format-quote-close"></i>
            </p>
            <p>
                {{ date('Y') }} - created by <a href="https://github.com/alprnkeskekoglu" target="_blank" class="text-white">@alprnkeskekoglu</a>
            </p>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/dawnstar/core/js/vendor.min.js') }}"></script>
<script src="{{ asset('vendor/dawnstar/core/js/app.min.js') }}"></script>
</body>
</html>
