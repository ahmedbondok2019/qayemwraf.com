@extends('frontend.layouts.master')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container minimal">
        <div class="auth-form-side">
            <div class="form-header centered">
                <div class="icon-circle">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h3>{{ trans_db('frontend.Reset Password') }}</h3>
                <p>{{ trans_db('frontend.Enter your email to receive a reset link') }}</p>
            </div>

            @if (session('status'))
                <div class="premium-alert success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('status') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.email') }}" class="premium-form">
                @csrf
                
                <div class="premium-input-group">
                    <label for="email">{{ trans_db('frontend.Email Address') }}</label>
                    <div class="input-container">
                        <i class="fa-regular fa-envelope"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ trans_db('frontend.Enter your email') }}">
                    </div>
                </div>

                <button type="submit" class="premium-btn">
                    <span>{{ trans_db('frontend.Send Password Reset Link') }}</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
                
                <div class="form-footer">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fa-solid fa-arrow-right"></i>
                        {{ trans_db('frontend.Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Premium Redesign for Password Reset */
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
    }

    .premium-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    .premium-alert { padding: 16px; border-radius: 14px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; gap: 10px; align-items: center; }
    .premium-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .premium-alert.error { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .premium-alert ul { margin: 0; padding: 0; list-style: none; }

    .form-footer { text-align: center; margin-top: 10px; }
    .back-link { color: var(--primary-color); text-decoration: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.3s; }
    .back-link:hover { transform: translateX(5px); }
</style>
@endsection
