@extends('frontend.layouts.master')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h3>{{ trans_db('frontend.Set New Password') }}</h3>
            <p>{{ trans_db('frontend.Please enter your new password') }}</p>
        </div>
        
        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email">{{ trans_db('frontend.Email Address') }}</label>
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ trans_db('frontend.Enter your email') }}">
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ trans_db('frontend.Password') }}</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ trans_db('frontend.Create a strong password') }}">
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ trans_db('frontend.Confirm Password') }}</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ trans_db('frontend.Repeat your password') }}">
                </div>
            </div>

            <button type="submit" class="auth-btn">
                {{ trans_db('frontend.Reset Password') }} <i class="fa-solid fa-check-circle"></i>
            </button>
        </form>
    </div>
</div>

<style>
    /* Reuse consistent premium styling */
    .auth-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #FDFCF5 0%, #E8F5E9 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .auth-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 70%);
        animation: rotate 20s linear infinite;
        z-index: 0;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 3rem;
        width: 100%;
        max-width: 480px;
        box-shadow: 
            0 20px 40px rgba(0,0,0,0.1),
            0 0 0 1px rgba(255,255,255,0.5) inset;
        transform: translateY(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        z-index: 1;
        position: relative;
    }

    .auth-card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 30px 60px rgba(0,0,0,0.12),
            0 0 0 1px rgba(255,255,255,0.6) inset;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .auth-header h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
        background: linear-gradient(120deg, #1c4dac, #4C825D);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .auth-header p {
        color: #718096;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper i {
        position: absolute;
        left: 1rem;
        color: #a0aec0;
        transition: color 0.3s ease;
        z-index: 2;
    }
    
    html[dir="rtl"] .input-wrapper i.fa-envelope, 
    html[dir="rtl"] .input-wrapper i.fa-lock,
    html[dir="rtl"] .input-wrapper i.fa-user {
        right: 1rem;
        left: auto;
    }

    .input-wrapper input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    html[dir="rtl"] .input-wrapper input {
        padding: 1rem 3rem 1rem 1rem;
    }

    .input-wrapper input:focus {
        border-color: #1c4dac;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(30, 86, 49, 0.1);
        outline: none;
    }

    .input-wrapper input:focus + i {
        color: #1c4dac;
    }

    .auth-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1c4dac 0%, #4C825D 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        box-shadow: 0 4px 6px rgba(30, 86, 49, 0.25);
        margin-top: 1rem;
    }

    .auth-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(30, 86, 49, 0.3);
    }
    
    .auth-btn:active {
        transform: translateY(0);
    }

    .invalid-feedback {
        display: block;
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @media (max-width: 640px) {
        .auth-container {
            padding: 1rem;
        }
        
        .auth-card {
            padding: 2rem;
        }
    }
</style>
@endsection
