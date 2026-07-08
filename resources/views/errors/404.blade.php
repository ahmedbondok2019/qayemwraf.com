<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Not Found') }} - EgyptVision</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1c4dac;
            --primary-light: #4c7edc;
            --accent: #e74c3c;
            --bg: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', 'Cairo', sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Abstract Background Decor */
        .decoration {
            position: absolute;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.1;
            z-index: -1;
        }
        .dec-1 { width: 500px; height: 500px; top: -100px; left: -100px; }
        .dec-2 { width: 400px; height: 400px; bottom: -100px; right: -100px; }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        .error-code {
            font-size: 10rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            position: relative;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        p {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 0.9rem 2.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 25px rgba(28, 77, 172, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            background: var(--primary-light);
            box-shadow: 0 15px 30px rgba(28, 77, 172, 0.35);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(28, 77, 172, 0.2);
        }

        @media (max-width: 480px) {
            .error-code { font-size: 7rem; }
            h1 { font-size: 1.8rem; }
            .buttons { flex-direction: column; width: 100%; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="decoration dec-1"></div>
    <div class="decoration dec-2"></div>

    <div class="container">
        <div class="error-code">404</div>
        <h1>{{ app()->getLocale() == 'ar' ? 'عذراً، الصفحة غير موجودة' : 'Oops! Page Not Found' }}</h1>
        <p>
            {{ app()->getLocale() == 'ar' 
                ? 'يبدو أن الرابط الذي تحاول الوصول إليه غير موجود، أو ربما تم إغلاقه مؤقتاً.' 
                : 'The link you are trying to reach does not exist or might be temporarily disabled.' 
            }}
        </p>
        
        <div class="buttons">
            <a href="{{ url('/ar') }}" class="btn btn-primary">
                {{ app()->getLocale() == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
            </a>
            <a href="javascript:history.back()" class="btn btn-outline">
                {{ app()->getLocale() == 'ar' ? 'الرجوع للخلف' : 'Go Back' }}
            </a>
        </div>
    </div>
</body>
</html>
