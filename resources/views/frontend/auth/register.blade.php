@extends('frontend.layouts.master')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container register">
        <!-- Visual Column -->
        <div class="auth-visual">
            <div class="visual-content">
                <div class="brand-badge">{{ $Setting->translate('app_name') ?? 'قايم ورف' }}</div>
                <h1>{{ trans_db('frontend.Create Account') }}</h1>
                <p>انضم إلينا اليوم للحصول على أفضل رعاية طبية وعروض حصرية لأسرة المستشفيات.</p>
                
                <div class="visual-steps">
                    <div class="step-item active">
                        <div class="step-icon">1</div>
                        <span>بيانات الحساب</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-icon">2</div>
                        <span>تأكيد البيانات</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="auth-form-side">
            <div class="form-header">
                <h3>{{ trans_db('frontend.Register') }}</h3>
                <p>{{ trans_db('frontend.Join our community today') }}</p>
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

            <form method="POST" action="{{ route('register') }}" class="premium-form">
                @csrf
                
                <div class="form-row">
                    <div class="premium-input-group">
                        <label for="name">{{ trans_db('frontend.Name') }}</label>
                        <div class="input-container">
                            <i class="fa-regular fa-user"></i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="{{ trans_db('frontend.Enter your full name') }}">
                        </div>
                    </div>

                    <div class="premium-input-group">
                        <label for="email">{{ trans_db('frontend.Email Address') }}</label>
                        <div class="input-container">
                            <i class="fa-regular fa-envelope"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="{{ trans_db('frontend.Enter your email') }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="premium-input-group">
                        <label for="country_id">{{ trans_db('frontend.Country') }}</label>
                        <div class="input-container">
                            <i class="fa-solid fa-globe"></i>
                            <select id="country_id" name="country_id" required>
                                <option value="">{{ trans_db('frontend.Select Country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" data-phone-code="{{ $country->phone_code }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->translation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="premium-input-group">
                        <label for="phone">{{ trans_db('frontend.Phone') }}</label>
                        <div class="input-container">
                            <i class="fa-solid fa-phone"></i>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="{{ trans_db('frontend.Enter your phone number') }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="premium-input-group">
                        <label for="password">{{ trans_db('frontend.Password') }}</label>
                        <div class="input-container">
                            <i class="fa-solid fa-lock"></i>
                            <input id="password" type="password" name="password" required placeholder="{{ trans_db('frontend.Create a strong password') }}">
                            <i class="fa-regular fa-eye toggle-password"></i>
                        </div>
                    </div>

                    <div class="premium-input-group">
                        <label for="password-confirm">{{ trans_db('frontend.Confirm Password') }}</label>
                        <div class="input-container">
                            <i class="fa-solid fa-lock"></i>
                            <input id="password-confirm" type="password" name="password_confirmation" required placeholder="{{ trans_db('frontend.Repeat your password') }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="premium-btn">
                    <span>{{ trans_db('frontend.Register') }}</span>
                    <i class="fa-solid fa-user-plus"></i>
                </button>
                
                <div class="form-footer">
                    <p>{{ trans_db('frontend.Already have an account?') }} <a href="{{ route('login') }}">{{ trans_db('frontend.Login') }}</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Premium Redesign for Registration */
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
        max-width: 1100px;
        background: #fff;
        border-radius: 32px;
        display: flex;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        min-height: 700px;
    }

    .auth-visual {
        flex: 1;
        background: var(--primary-gradient);
        position: relative;
        padding: 60px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .visual-content { position: relative; z-index: 2; text-align: center; width: 100%; }

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

    .auth-visual h1 { font-size: 38px; font-weight: 800; margin-bottom: 20px; }
    .auth-visual p { font-size: 16px; opacity: 0.9; margin-bottom: 40px; line-height: 1.8; }

    .visual-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .step-item { display: flex; flex-direction: column; align-items: center; gap: 8px; opacity: 0.5; transition: 0.3s; }
    .step-item.active { opacity: 1; }
    .step-icon { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border: 2px solid #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }
    .step-line { width: 60px; height: 2px; background: rgba(255, 255, 255, 0.2); margin-bottom: 25px; }

    .auth-form-side { flex: 1.4; padding: 60px; display: flex; flex-direction: column; justify-content: center; }

    .form-header h3 { font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .form-header p { color: #64748b; font-size: 15px; }

    .premium-form { display: flex; flex-direction: column; gap: 24px; margin-top: 30px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    @media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } }

    .premium-input-group { display: flex; flex-direction: column; gap: 8px; }
    .premium-input-group label { font-size: 14px; font-weight: 700; color: #475569; }

    .input-container { position: relative; display: flex; align-items: center; }
    .input-container i { position: absolute; right: 16px; color: #94a3b8; transition: 0.3s; z-index: 2; }
    
    .input-container input, .input-container select {
        width: 100%;
        padding: 14px 48px 14px 16px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        font-size: 16px;
        background: #f8fafc;
        transition: all 0.3s;
        color: #1e293b;
        appearance: none;
    }

    .input-container select { cursor: pointer; }

    .input-container input:focus, .input-container select:focus {
        border-color: var(--primary-color);
        background: #fff;
        outline: none;
    }

    .input-container input:focus + i { color: var(--primary-color); }

    .input-container i.toggle-password { right: auto; left: 16px; cursor: pointer; }

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
        margin-top: 10px;
    }

    .premium-btn:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15); }

    .form-footer { text-align: center; margin-top: 10px; font-size: 14px; color: #64748b; }
    .form-footer a { color: var(--primary-color); text-decoration: none; font-weight: 700; }

    .premium-alert { padding: 16px; border-radius: 16px; background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; display: flex; gap: 12px; font-size: 14px; font-weight: 600; }
    .premium-alert ul { margin: 0; padding: 0; list-style: none; }

    @media (max-width: 992px) {
        .auth-container { flex-direction: column; max-width: 550px; }
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

        const countrySelector = document.querySelector('#country_id');
        const phoneInput = document.querySelector('#phone');
        
        if (countrySelector && phoneInput) {
            countrySelector.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const phoneCode = selectedOption.getAttribute('data-phone-code');
                if (phoneCode && !phoneInput.value.startsWith(phoneCode)) {
                    phoneInput.value = phoneCode + phoneInput.value.replace(/^\+\d+/, '');
                }
            });
        }
    });
</script>
@endsection
