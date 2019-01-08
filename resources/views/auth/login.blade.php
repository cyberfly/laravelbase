@extends('layouts.auth')

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <!-- Page JS Code -->

    <script src="{{ asset('js/pages/op_auth_signin.min.js') }}"></script>

@endsection

@section('content')

    <!-- Sign In Block -->
    <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
        <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
            <!-- Header -->
            <div class="mb-2 text-center">
                <a class="link-fx font-w700 font-size-h1" href="index.html">
                    <span class="text-dark">Dash</span><span class="text-primary">mix</span>
                </a>
                <p class="text-uppercase font-w700 font-size-sm text-muted">Sign In</p>
            </div>
            <!-- END Header -->

            <!-- Sign In Form -->

            <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-user-circle"></i>
                            </span>
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-asterisk"></i>
                            </span>
                        </div>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-left">
                    <div class="custom-control custom-checkbox custom-control-primary">
                        <input class="custom-control-input" type="checkbox" name="remember" id="login-remember-me" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="login-remember-me">{{ __('Remember Me') }}</label>
                    </div>

                    <div class="font-w600 font-size-sm py-1">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-hero-primary">
                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> {{ __('Login') }}
                    </button>
                </div>
            </form>
            <!-- END Sign In Form -->
        </div>
    </div>
    <!-- END Sign In Block -->

@endsection
