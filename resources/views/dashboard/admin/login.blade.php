
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans_db('login.Page Title') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            padding: 20px;
        }
        
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background-color: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            min-height: 600px;
        }
        
        /* الجانب الأيسر (التصميم) */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%);
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .library-icon {
            font-size: 70px;
            color: #e74c3c;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-left h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #ecf0f1;
        }
        
        .login-left p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #bdc3c7;
        }
        
        .features {
            margin-top: 30px;
        }
        
        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .feature i {
            color: #e74c3c;
            margin-left: 15px;
            font-size: 20px;
        }
        
        .book-decoration {
            position: absolute;
            bottom: 0;
            right: 0;
            opacity: 0.1;
            font-size: 150px;
            color: #e74c3c;
        }
        
        /* الجانب الأيمن (النموذج) */
        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .logo span {
            color: #e74c3c;
        }
        
        .logo p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .login-form {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 15px;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 45px 15px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: white;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-left: 8px;
        }
        
        .forgot-password {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .forgot-password:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background-color: #c0392b;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .login-footer a {
            color: #3498db;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        /* رسائل الخطأ والنجاح */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: none;
        }
        
        .alert-error {
            background-color: #ffeaea;
            color: #c0392b;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #e8f6ef;
            color: #27ae60;
            border: 1px solid #c3e6cb;
        }
        
        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }
            
            .login-left {
                padding: 30px 25px;
            }
            
            .login-right {
                padding: 40px 30px;
            }
            
            .book-decoration {
                font-size: 100px;
            }
        }
        
        @media (max-width: 480px) {
            .login-left h2 {
                font-size: 26px;
            }
            
            .library-icon {
                font-size: 50px;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .forgot-password {
                margin-top: 10px;
            }
        }
    </style>

    <style>
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- الجانب الأيسر (الرسوم والوصف) -->
        <div class="login-left">
            <div class="library-icon">
                <i class="fas fa-book-reader"></i>
            </div>
            <h2>{{ trans_db('login.Sidebar Welcome Header') }}</h2>
            <p>{{ trans_db('login.Sidebar Welcome Desc') }}</p>
            
            <div class="features">
                <div class="feature">
                    <i class="fas fa-book"></i>
                    <span>{{ trans_db('login.Feature 1') }}</span>
                </div>
                <div class="feature">
                    <i class="fas fa-users"></i>
                    <span>{{ trans_db('login.Feature 2') }}</span>
                </div>
                <div class="feature">
                    <i class="fas fa-exchange-alt"></i>
                    <span>{{ trans_db('login.Feature 3') }}</span>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-bar"></i>
                    <span>{{ trans_db('login.Feature 4') }}</span>
                </div>
            </div>
            
            <div class="book-decoration">
                <i class="fas fa-book-open"></i>
            </div>
        </div>
        
        <!-- الجانب الأيمن (نموذج تسجيل الدخول) -->
        <div class="login-right">
            <div class="logo">
                <h1>{{ trans_db('login.Right Header') }}</h1>
                <p>{{ trans_db('login.Right Subheader') }}</p>
            </div>
            
            <!-- رسالة الخطأ (تظهر فقط عند وجود خطأ) -->
            @if(session('failed'))
                <div class="alert alert-error" style="display: block;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('failed') }}
                </div>
            @endif

            @if(session('success'))
            <!-- رسالة النجاح (تظهر فقط عند تسجيل الدخول بنجاح في الوضع التجريبي) -->
            <div class="alert alert-success" style="display: block;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            
            <form class="login-form" id="loginForm" method="POST" action="{{ route('admin.check') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ trans_db('login.Email Label') }}</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email"  id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ trans_db('login.Email Placeholder') }}" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="text-danger" style="color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                    
                <div class="form-group">
                    <label for="password">{{ trans_db('login.Password Label') }}</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password"  name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ trans_db('login.Password Placeholder') }}" required>
                    </div>
                    @error('password')
                        <span class="text-danger" style="color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">{{ trans_db('login.Remember Me') }}</label>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">{{ trans_db('login.Login Button') }}</button>
            </form>
            
            <div class="login-footer">
                <p>{!! trans_db('login.Footer Text') !!}</p>
                <p>{{ trans_db('login.Footer Contact Part 1') }} <a href="#">{{ trans_db('login.Footer Contact Part 2') }}</a></p>
            </div>
        </div>
    </div>

</body>
</html>