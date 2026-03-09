


@extends('layouts.app_auth')

@section('title')
    {{ __('website.Login') }}
@endsection

@section('content')

    <!-- Our SigIn -->
    <section class="our-log-reg bgc-f5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5 col-xxl-4 m-auto">
                    <div class="log_reg_form mt70-992">
                        <h2 class="title">{{ __('website.Reset Password') }}</h2>
                        <p class="mb-30">{{ __('website.Don"t have an account?') }}
                            <a href="{{ route('user.register') }}">{{ __('website.Create Here') }}</a>
                        </p>

                        <div class="login_form">
                        <form class="register-form outer-top-xs" role="form" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="alert alert-danger alert-dismissable" style="list-style-type: none;">
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(Session::get('success'))
                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                @endif

                                @if(Session::get('failed'))
                                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                                @endif

                                @if(Session::get('message'))
                                    <div class="alert alert-danger">{{ Session::get('message') }}</div>
                                @endif

                                <div class="mb-2 mr-sm-2">
                                    <label class="form-label">{{ __("website.Email") }}</label>
                                    <input type="email" class=" form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-2 mr-sm-2">
                                    <label class="form-label">{{ __("website.password") }}</label>
                                    <input type="password" class=" form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-2 mr-sm-2">
                                    <label class="form-label">{{ __("website.confirm password") }}</label>
                                    <input class=" form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-log btn-thm mt20">{{ __('Reset Password') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection