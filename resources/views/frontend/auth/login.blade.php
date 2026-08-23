@extends('frontend.layouts.master')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <!-- Visual Column -->
        <div class="auth-visual">
            <div class="visual-content">
                <div class="brand-badge">{{ $Setting->translate('app_name') ?? 'قايم ورف' }}</div>
                <h1>{{ trans_db('frontend.Welcome Back') }}</h1>
                <p>سعدنا بعودتك! قم بتسجيل الدخول لمتابعة مشترياتك وخدماتك الطبية.</p>
                <div class="visual-features">
                    <div class="feature-item">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>حماية كاملة لبياناتك</span>
                    </div>
                   <div class="feature-item">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>متابعة دقيقة للشحنات</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="auth-form-side">
            <div class="form-header">
                <h3>{{ trans_db('frontend.Login') }}</h3>
                <p>{{ trans_db('frontend.Please login to your account') }}</p>
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

            <form method="POST" action="{{ route('login') }}" class="premium-form">
                @csrf
                
                <div class="premium-input-group">
                    <label for="login">{{ trans_db('frontend.Email or Phone') }}</label>
                    <div class="input-container">
                        <i class="fa-regular fa-envelope"></i>
                        <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus placeholder="{{ trans_db('frontend.Enter your email or phone') }}">
                    </div>
                </div>

                <div class="premium-input-group">
                    <label for="password">{{ trans_db('frontend.Password') }}</label>
                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input id="password" type="password" name="password" required placeholder="{{ trans_db('frontend.Enter your password') }}">
                        <i class="fa-regular fa-eye toggle-password"></i>
                    </div>
                </div>

                <div class="form-extra">
                    <label class="premium-checkbox">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span class="label-text">{{ trans_db('frontend.Remember Me') }}</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            {{ trans_db('frontend.Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="premium-btn">
                    <span>{{ trans_db('frontend.Login') }}</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                
                <div class="auth-divider">
                    <span>{{ trans_db('frontend.Or login with') }}</span>
                </div>

                <div class="social-grid">
                    <a href="{{ url('login/google') }}" class="social-btn google">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google">
                        <span>Google</span>
                    </a>
                    <a href="{{ url('login/facebook') }}" class="social-btn facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                </div>

                <div class="form-footer">
                    <p>{{ trans_db('frontend.Don\'t have an account?') }} <a href="{{ route('register') }}">{{ trans_db('frontend.Create Account') }}</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Premium Redesign for Auth */
    .auth-wrapper {
        min-height: 100vh;
        background: #fbfbfd;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Cairo', sans-serif;
    }

    .auth-container {
        width: 100%;
        max-width: 1050px;
        background: #fff;
        border-radius: 32px;
        display: flex;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        min-height: 650px;
    }

    /* Left Visual Side */
    .auth-visual {
        flex: 1.1;
        background: var(--primary-gradient);
        position: relative;
        padding: 60px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .auth-visual::before {
        content: '';
        position: absolute;
        width: 150%;
        height: 150%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        top: -25%;
        left: -25%;
    }

    .visual-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .brand-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 24px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .auth-visual h1 {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .auth-visual p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 40px;
        line-height: 1.8;
    }

    .visual-features {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 24px;
        border-radius: 16px;
        width: 100%;
        max-width: 300px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: 0.3s;
    }

    .feature-item:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(10px);
    }

    .feature-item i {
        font-size: 20px;
    }

    /* Right Form Side */
    .auth-form-side {
        flex: 1;
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        margin-bottom: 32px;
    }

    .form-header h3 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .form-header p {
        color: #64748b;
        font-size: 15px;
    }

    .premium-alert {
        padding: 16px;
        border-radius: 16px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        font-size: 14px;
        font-weight: 600;
        align-items: flex-start;
    }

    .premium-alert.error {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    .premium-alert ul { margin: 0; padding: 0; list-style: none; }

    .premium-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .premium-input-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .premium-input-group label {
        font-size: 14px;
        font-weight: 700;
        color: #475569;
    }

    .input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-container i {
        position: absolute;
        right: 16px;
        color: #94a3b8;
        transition: 0.3s;
    }

    .input-container input {
        width: 100%;
        padding: 14px 48px 14px 16px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        font-size: 16px;
        background: #f8fafc;
        transition: all 0.3s;
        color: #1e293b;
    }

    .input-container input:focus {
        border-color: var(--primary-color);
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 4px rgba(var(--primary-color-rgb), 0.1);
    }

    .input-container input:focus + i {
        color: var(--primary-color);
    }

    .input-container i.toggle-password {
        right: auto;
        left: 16px;
        cursor: pointer;
    }

    .form-extra {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }

    .premium-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        position: relative;
    }

    .premium-checkbox input { display: none; }

    .checkmark {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        position: relative;
        transition: 0.2s;
    }

    .premium-checkbox input:checked + .checkmark {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .premium-checkbox input:checked + .checkmark::after {
        content: '\2713';
        position: absolute;
        color: #fff;
        font-size: 14px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .forgot-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .premium-btn {
        width: 100%;
        padding: 16px;
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: 0.3s;
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
    }

    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        filter: brightness(1.05);
    }

    .auth-divider {
        position: relative;
        text-align: center;
        margin: 10px 0;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background: #f1f5f9;
    }

    .auth-divider span {
        position: relative;
        background: #fff;
        padding: 0 16px;
        color: #94a3b8;
        font-size: 14px;
    }

    .social-grid {
        display: flex;
        gap: 16px;
    }

    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        border-radius: 14px;
        border: 2px solid #f1f5f9;
        text-decoration: none;
        color: #475569;
        font-weight: 700;
        transition: 0.3s;
    }

    .social-btn img { width: 20px; }

    .social-btn:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: translateY(-2px);
    }

    .social-btn.facebook {
        background: #1877f2;
        border-color: #1877f2;
        color: #fff;
    }

    .social-btn.facebook:hover {
        background: #166fe5;
        border-color: #166fe5;
    }

    .form-footer {
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        color: #64748b;
    }

    .form-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 700;
    }

    @media (max-width: 992px) {
        .auth-container { flex-direction: column; max-width: 500px; }
        .auth-visual { padding: 40px; }
        .auth-form-side { padding: 40px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endsection
