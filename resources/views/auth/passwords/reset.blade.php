@extends('layouts.auth')

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@endsection

@section('content')

    <!-- Password reset Block -->
    <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
        <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
            <!-- Header -->
            <div class="mb-2 text-center">
                <a class="link-fx font-w700 font-size-h1" href="index.html">
                    <span class="text-dark">Dash</span><span class="text-primary">mix</span>
                </a>
                <p class="text-uppercase font-w700 font-size-sm text-muted">Password reset</p>
            </div>
            <!-- END Header -->

            <!-- Password reset Form -->

            <form class="js-validation-signin" action="{{ route('password.update') }}" method="POST">
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
                <div class="form-group">
                    <div class="input-group">
                        <input id="password-confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password-confirmation" placeholder="{{ __('Confirm Password') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-check-circle"></i>
                            </span>
                        </div>

                        @if ($errors->has('password-confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password-confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-hero-primary">
                        <i class="fa fa-fw fa-paper-plane mr-1"></i> Reset Password
                    </button>
                </div>
            </form>
            <!-- END Password reset Form -->
        </div>
    </div>
    <!-- END Password reset Block -->

@endsection
