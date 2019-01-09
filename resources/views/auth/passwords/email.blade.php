@extends('layouts.auth')

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

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
                <p class="text-uppercase font-w700 font-size-sm text-muted">Password Reminder</p>
            </div>
            <!-- END Header -->

            <!-- Sign In Form -->

            <form class="js-validation-signin" action="{{ route('password.email') }}" method="POST">
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
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-hero-primary">
                        <i class="fa fa-fw fa-paper-plane mr-1"></i> Reset Password
                    </button>
                </div>
                <div class="form-group text-center">
                    <a class="btn btn-hero-secondary pl-6 pr-6" href="{{ route('home') }}">
                        <i class="fa fa-fw fa-reply mr-1"></i> Login
                    </a>
                </div>
            </form>
            <!-- END Sign In Form -->
        </div>
    </div>
    <!-- END Sign In Block -->

@endsection
