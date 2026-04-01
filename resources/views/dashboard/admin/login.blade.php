

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans_db('login.Page Title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary-color: #0f172a;
            --accent-color: #0d9488;
            --bg-gradient: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --shadow-premium: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', 'Inter', sans-serif;
        }
        
        body {
            background: var(--bg-gradient);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
        }
        
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1100px;
            background-color: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--shadow-premium);
            min-height: 680px;
            position: relative;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Left Side - Visuals */
        .login-visual {
            flex: 1.2;
            background: url('{{ asset('admin/medical-login.png') }}') no-repeat center center;
            background-size: cover;
            position: relative;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }
        
        .login-visual::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(14, 165, 233, 0.7) 100%);
            z-index: 1;
        }
        
        .visual-content {
            position: relative;
            z-index: 2;
        }
        
        .medical-icon {
            font-size: 60px;
            color: #fff;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.2);
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .login-visual h2 {
            font-size: 38px;
            margin-bottom: 20px;
            font-weight: 700;
            line-height: 1.3;
        }
        
        .login-visual p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 40px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 450px;
        }
        
        .benefit-list {
            display: grid;
            gap: 24px;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateX(-5px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .benefit-item i {
            font-size: 20px;
            color: var(--primary-color);
            background: white;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        /* Right Side - Form */
        .login-form-container {
            flex: 1;
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            position: relative;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h1 {
            font-size: 32px;
            color: var(--secondary-color);
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .form-header p {
            color: var(--text-muted);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 14px;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s;
        }
        
        .form-control {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f8fafc;
            color: var(--text-main);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .form-control:focus + i {
            color: var(--primary-color);
        }
        
        .remember-wrap {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            cursor: pointer;
        }
        
        .remember-wrap input {
            width: 18px;
            height: 18px;
            margin-left: 10px;
            cursor: pointer;
            accent-color: var(--primary-color);
        }
        
        .remember-wrap label {
            font-size: 14px;
            color: var(--text-muted);
            cursor: pointer;
        }
        
        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3);
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(14, 165, 233, 0.4);
            filter: brightness(1.1);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .form-footer {
            margin-top: 40px;
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            border-top: 1px solid #f1f5f9;
            padding-top: 30px;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        /* Alerts */
        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 14px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; scale: 0.95; }
            to { opacity: 1; scale: 1; }
        }
        
        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
        }

        .error-msg {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 550px;
                min-height: auto;
            }
            
            .login-visual {
                padding: 40px 30px;
            }
            
            .login-visual h2 { font-size: 28px; }
            .login-visual p { font-size: 16px; margin-bottom: 25px; }

            .login-form-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>


    <div class="login-wrapper">
        <!-- Visual Section (Sidebar) -->
        <div class="login-visual">
            <div class="visual-content">
                <div class="medical-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h2>إيجي ميديكال لأسرة المستشفيات</h2>
                <p>نوفر أحدث الأسرة الطبية (الكهربائية واليدوية) وكافة مستلزمات الرعاية المركزة بأعلى معايير الجودة العالمية.</p>
                
                <div class="benefit-list">
                    <div class="benefit-item">
                        <i class="fas fa-bed"></i>
                        <span>أسرة طبية كهربائية ويدوية</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-user-md"></i>
                        <span>تجهيز كامل لغرف العناية المركزة</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-truck-ramp-box"></i>
                        <span>شحن سريع لكافة المحافظات</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-screwdriver-wrench"></i>
                        <span>ضمان حقيقي وصيانة دورية</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Section -->
        <div class="login-form-container">
            <div class="form-header">
                <h1>تسجيل الدخول</h1>
                <p>مرحباً بك في نظام إدارة مستلزمات إيجي ميديكال</p>
            </div>
            
            @if(session('failed'))
                <div class="alert alert-error">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ session('failed') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            <form id="loginForm" method="POST" action="{{ route('admin.check') }}">
                @csrf
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="input-group">
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="example@egimedical.com" 
                               value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                    
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="remember-wrap">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">تذكرني</label>
                </div>
                
                <button type="submit" class="btn-submit">
                    دخول لوحة التحكم
                </button>
            </form>
            
            <div class="form-footer">
                <p>جميع الحقوق محفوظة &copy; إيجي ميديكال - متخصصون في الأسرة الطبية</p>
                <p>
                    تواصل مع الدعم الفني 
                    <a href="#">مركز المساعدة</a>
                </p>
            </div>
        </div>
    </div>


</body>
</html>