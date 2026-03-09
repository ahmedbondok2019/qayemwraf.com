@extends('frontend.layouts.master')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h3>{{ trans_db('frontend.Welcome Back') }}</h3>
            <p>{{ trans_db('frontend.Please login to your account') }}</p>
        </div>
        
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="login">{{ trans_db('frontend.Email or Phone') }}</label>
                <div class="input-wrapper">
                    <i class="fa-regular fa-user"></i>
                    <input id="login" type="text" class="@error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus placeholder="{{ trans_db('frontend.Enter your email or phone') }}">
                </div>
                @error('login')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ trans_db('frontend.Password') }}</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ trans_db('frontend.Enter your password') }}">
                    <i class="fa-regular fa-eye toggle-password"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-actions">
                <div class="remember-me">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ trans_db('frontend.Remember Me') }}
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ trans_db('frontend.Forgot Your Password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="auth-btn">
                {{ trans_db('frontend.Login') }} <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
            
            <div class="social-login">
                <div class="divider">
                    <span>{{ trans_db('frontend.Or login with') }}</span>
                </div>
                <div class="social-buttons">
                    <a href="{{ url('login/google') }}" class="social-btn google">
                        <i class="fa-brands fa-google"></i>
                        <span>Google</span>
                    </a>
                    <a href="{{ url('login/facebook') }}" class="social-btn facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                </div>
            </div>

            <div class="auth-footer">
                <p>{{ trans_db('frontend.Don\'t have an account?') }} <a href="{{ route('register') }}">{{ trans_db('frontend.Create Account') }}</a></p>
            </div>
        </form>
    </div>
</div>

<style>
    /* Premium Auth Styling */
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
        color: #C5A059;
        margin-bottom: 0.5rem;
        background: linear-gradient(120deg, #1E5631, #4C825D);
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
        left: 1rem; /* Adjust based on RTL/LTR */
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
    
    html[dir="rtl"] .input-wrapper i.toggle-password {
        left: 1rem;
        right: auto;
    }

    .input-wrapper input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem; /* Adjust based on RTL/LTR */
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
        border-color: #1E5631;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(30, 86, 49, 0.1);
        outline: none;
    }

    .input-wrapper input:focus + i {
        color: #1E5631;
    }

    .toggle-password {
        right: 1rem;
        left: auto;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        font-size: 0.9rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .forgot-password {
        color: #1E5631;
        text-decoration: none;
        transition: color 0.2s;
    }

    .forgot-password:hover {
        color: #C5A059;
        text-decoration: underline;
    }

    .auth-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1E5631 0%, #4C825D 100%);
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
    }

    .auth-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(30, 86, 49, 0.3);
    }
    
    .auth-btn:active {
        transform: translateY(0);
    }

    .social-login {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .divider {
        position: relative;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e2e8f0;
        z-index: 0;
    }

    .divider span {
        background: #fff; /* Matches card background roughly or transparent if blurred, but needs text bg to hide line */
        background: rgba(255, 255, 255, 0.9); /* Match card bg */
        padding: 0 1rem;
        color: #a0aec0;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        padding: 0.8rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .social-btn.google {
        background: #fff;
        color: #4a5568;
        border-color: #e2e8f0;
    }

    .social-btn.google:hover {
        background: #f8fafc;
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }

    .social-btn.facebook {
        background: #1877f2;
        color: white;
    }

    .social-btn.facebook:hover {
        background: #166fe5;
        box-shadow: 0 4px 6px rgba(24, 119, 242, 0.3);
        transform: translateY(-2px);
    }

    .auth-footer {
        margin-top: 2rem;
        text-align: center;
        color: #718096;
        font-size: 0.95rem;
    }

    .auth-footer a {
        color: #1E5631;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .auth-footer a:hover {
        color: #C5A059;
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
