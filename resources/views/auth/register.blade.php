@extends('layouts.auth')

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/op_auth_signup.min.js') }}"></script>
    
@endsection

@section('content')

 <!-- Sign Up Block -->
 <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
    <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
        <!-- Header -->
        <div class="mb-2 text-center">
            <a class="link-fx font-w700 font-size-h1" href="index.html">
                <span class="text-dark">Dash</span><span class="text-primary">mix</span>
            </a>
            <p class="text-uppercase font-w700 font-size-sm text-muted">Sign Up</p>
        </div>
        <!-- END Header -->

        <!-- Register Form -->

        <form class="js-validation-signup" action="{{ route('register') }}"  method="POST" >
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-user-circle"></i>
                        </span>
                    </div>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-envelope-open"></i>
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
                    <input  id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-asterisk"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input  id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Password Confirm') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-asterisk"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-hero-success">
                    <i class="fa fa-fw fa-plus mr-1"></i> Sign Up
                </button>
            </div>
        </form>
        <!-- END Register Form -->
    </div>
</div>
<!-- END Sign Up Block -->
@endsection
