@php
    $app_name = $Setting?->translate('app_name') ?? 'Mushaf Home';
    $meta_title = !empty($__env->yieldContent('meta_title')) ? $__env->yieldContent('meta_title') : (!empty($__env->yieldContent('title')) ? $__env->yieldContent('title') : $app_name);
    $meta_description = !empty($__env->yieldContent('meta_description')) ? $__env->yieldContent('meta_description') : ($Setting?->translate('app_description') ?? '');
    $meta_image = !empty($__env->yieldContent('meta_image')) ? $__env->yieldContent('meta_image') : (isset($Setting) && $Setting->logo ? asset($Setting->logo) : asset('/website/logo-to-share.png'));
    $current_url = url()->current();
@endphp

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $meta_description }}">
<link rel="canonical" href="{{ $current_url }}">

<!-- Favicons -->
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset($Setting->fav_icon ?? '') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset($Setting->fav_icon ?? '') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset($Setting->fav_icon ?? '') }}">
<meta name="theme-color" content="#ffffff">
<meta name="robots" content="index,follow">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta property="og:title" content="{{ $meta_title }}">
<meta property="og:description" content="{{ $meta_description }}">
<meta property="og:image" content="{{ $meta_image }}">
<meta property="og:url" content="{{ $current_url }}">
<meta property="og:type" content="website">

<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<meta name="twitter:image" content="{{ $meta_image }}">
<meta name="twitter:url" content="{{ $current_url }}">
<meta name="twitter:card" content="summary_large_image">

<link rel="shortcut icon" href="{{ asset($Setting->fav_icon ?? '') }}" type="image/x-icon">
<link rel="icon" href="{{ asset($Setting->fav_icon ?? '') }}" type="image/x-icon">

<title>@hasSection('title') @yield('title') | @endif {{ $app_name }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/website/css/ar/normalize.css?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="/website/css/ar/all.min.css?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="/website/css/ar/swiper.css?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="/website/css/ar/main.css?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="{{ asset('css/elegant-header.css') }}?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="{{ asset('css/home-vibe.css') }}?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="{{ asset('css/elegant-dropdown.css') }}?v={{ $v ?? '1.0.3' }}">
<link rel="stylesheet" href="{{ asset('website/css/home_sections.css') }}?v={{ $v ?? '1.0.3' }}">

<link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ $v ?? '1.0.3' }}">
<!-- Font Awesome -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />


<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<style>
    /* Dynamic Theme Overrides */
    :root {
        --primary-color: {{ $Setting->primary_color ?? '#1c4dad' }};
        --primary-color-to: {{ $Setting->primary_color_to ?? '#3066d1' }};
        --primary-gradient: linear-gradient(135deg, {{ $Setting->primary_color ?? '#1c4dad' }} 0%, {{ $Setting->primary_color_to ?? '#3066d1' }} 100%) !important;
        --secondary-color: #e98939; /* Orange */
    }

    .modal .close {
        background: var(--primary-color) !important;
        border: none;
        padding: 10px 20px;
        margin-bottom: 10px;
        color: #fff;
        font-weight: bold;
        font-size: 24px;
        border-radius: 5px;
    }

    /* Override categories and other elements to ensure they use the dynamic gradient */
    .vibe-cat-card, .vibe-subcat-card, .vibe-slider-btn, .vibe-offer-image {
        background: var(--primary-gradient) !important;
    }

    /* Override some specific hardcoded colors */
    .elegant-search-btn:hover {
        background: color-mix(in srgb, var(--primary-color), black 20%) !important;
    }

    /* Mega Menu Styling */
    .category-dropdown.mega-dropdown {
        position: static !important;
    }

    .mega-menu {
        width: 100vw !important;
        max-width: 1200px;
        left: 50% !important;
        right: auto !important;
        transform: translateX(-50%) !important;
        padding: 30px !important;
        border-radius: 0 0 25px 25px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(0,0,0,0.05) !important;
        margin-top: 0 !important;
        overflow: hidden;
    }

    .mega-menu-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 30px;
        padding-bottom: 20px;
    }

    .mega-column {
        border-right: 1px solid #f1f5f9;
        padding-right: 20px;
    }

    html[dir="rtl"] .mega-column {
        border-right: none;
        border-left: 1px solid #f1f5f9;
        padding-right: 0;
        padding-left: 20px;
    }

    .mega-column:last-child {
        border: none !important;
    }

    .mega-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 10px;
        transition: all 0.3s ease;
    }

    .mega-title i {
        font-size: 12px;
        color: var(--secondary-color);
    }

    .mega-title:hover {
        color: var(--secondary-color);
        border-bottom-color: var(--secondary-color);
    }

    .mega-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mega-links li {
        margin-bottom: 8px;
    }

    .mega-links li a {
        color: #64748b;
        text-decoration: none;
        font-size: 13.5px;
        transition: all 0.2s ease;
        display: block;
        font-weight: 500;
    }

    .mega-links li a:hover {
        color: var(--primary-color);
        padding-right: 8px;
    }

    html[dir="ltr"] .mega-links li a:hover {
        padding-right: 0;
        padding-left: 8px;
    }

    .mega-links li a.view-more {
        color: var(--secondary-color);
        font-weight: 700;
        font-size: 12px;
        margin-top: 5px;
    }

    .mega-menu-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        text-align: center;
    }

    .btn-all-categories {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        color: var(--primary-color);
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }

    .btn-all-categories:hover {
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 1200px) {
        .mega-menu {
            max-width: 95vw;
        }
    }
</style>
<!-- Primary: {{ $Setting->primary_color }} | Gradient To: {{ $Setting->primary_color_to }} -->
@stack('css')