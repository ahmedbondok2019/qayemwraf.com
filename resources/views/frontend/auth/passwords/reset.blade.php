@extends('frontend.layouts.master')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container minimal">
        <div class="auth-form-side">
            <div class="form-header centered">
                <div class="icon-circle">
                    <i class="fa-solid fa-lock-open"></i>
                </div>
                <h3>{{ trans_db('frontend.Set New Password') }}</h3>
                <p>{{ trans_db('frontend.Please enter your new password') }}</p>
            </div>

            @if ($errors->any())
                <div class="premium-alert error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="premium-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="premium-input-group">
                    <label for="email">{{ trans_db('frontend.Email Address') }}</label>
                    <div class="input-container">
                        <i class="fa-regular fa-envelope"></i>
                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="{{ trans_db('frontend.Enter your email') }}">
                    </div>
                </div>

                <div class="premium-input-group">
                    <label for="password">{{ trans_db('frontend.Password') }}</label>
                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input id="password" type="password" name="password" required placeholder="{{ trans_db('frontend.Create a strong password') }}">
                    </div>
                </div>

                <div class="premium-input-group">
                    <label for="password-confirm">{{ trans_db('frontend.Confirm Password') }}</label>
                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input id="password-confirm" type="password" name="password_confirmation" required placeholder="{{ trans_db('frontend.Repeat your password') }}">
                    </div>
                </div>

                <button type="submit" class="premium-btn">
                    <span>{{ trans_db('frontend.Reset Password') }}</span>
                    <i class="fa-solid fa-check-circle"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Reuse consistent premium styling */
    .auth-wrapper {
        min-height: 80vh;
        background: #fbfbfd;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Cairo', sans-serif;
    }

    .auth-container.minimal {
        width: 100%;
        max-width: 550px;
        background: #fff;
        border-radius: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .auth-form-side { padding: 50px; }
    .form-header.centered { text-align: center; margin-bottom: 32px; }

    .icon-circle {
        width: 70px;
        height: 70px;
        background: rgba(var(--primary-color-rgb), 0.1);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 20px;
    }

    .form-header h3 { font-size: 26px; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .form-header p { color: #64748b; font-size: 15px; }

    .premium-form { display: flex; flex-direction: column; gap: 24px; }
    .premium-input-group { display: flex; flex-direction: column; gap: 8px; }
    .premium-input-group label { font-size: 14px; font-weight: 700; color: #475569; }

    .input-container { position: relative; display: flex; align-items: center; }
    .input-container i { position: absolute; right: 16px; color: #94a3b8; }
    .input-container input {
        width: 100%;
        padding: 14px 48px 14px 16px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        font-size: 16px;
        transition: 0.3s;
        background: #f8fafc;
    }

    .input-container input:focus { border-color: var(--primary-color); outline: none; background: #fff; }

    .premium-btn {
        width: 100%;
        padding: 16px;
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: 0.3s;
        margin-top: 10px;
    }

    .premium-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    .premium-alert { padding: 16px; border-radius: 14px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; gap: 10px; align-items: center; background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .premium-alert ul { margin: 0; padding: 0; list-style: none; }
</style>
@endsection
