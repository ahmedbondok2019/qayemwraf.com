
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
                    <h2 class="title">{{ __("website.Reset Password") }}</h2>
                    <div class="login_form">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            
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
                                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                            @endif

                            <div class="mb-2 mr-sm-2">
                                <label class="form-label">{{ __("website.Email") }}</label>
                                <input type="email" class=" form-control " placeholder="{{ __('website.enter your email') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                            </div>
                            <button type="submit" class="btn btn-log btn-thm mt20">{{ __("website.Send Password Reset Link") }}</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

@endsection