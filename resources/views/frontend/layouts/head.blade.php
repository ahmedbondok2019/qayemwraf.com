@php
    $app_name = $Setting?->translate('app_name') ?? 'qayemwraf';
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

    /* Mega Menu Premium Styling */
    .category-dropdown.mega-dropdown {
        position: static !important;
    }

    .elegant-nav-bar {
        position: relative !important;
    }

    .mega-menu {
        position: absolute !important;
        width: 100% !important;
        left: 0 !important;
        right: 0 !important;
        top: 100% !important;
        padding: 45px 0 !important;
        border-radius: 0 0 30px 30px !important;
        box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.2) !important;
        border: none !important;
        border-top: 3px solid var(--primary-color) !important;
        margin-top: 0 !important;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(15px);
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        display: block !important;
        pointer-events: none;
        z-index: 9999;
    }

    .category-dropdown.mega-dropdown:hover .mega-menu {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) !important;
    }

    .mega-menu-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr); /* 5 Columns as requested */
        gap: 25px;
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .mega-column {
        padding: 0 15px;
        transition: all 0.3s ease;
        position: relative;
    }

    .mega-column:not(:last-child):after {
        content: '';
        position: absolute;
        right: 0;
        top: 10%;
        height: 80%;
        width: 1px;
        background: linear-gradient(to bottom, transparent, #eee, transparent);
    }

    html[dir="rtl"] .mega-column:not(:last-child):after {
        right: auto;
        left: 0;
    }

    .mega-title {
        font-size: 16px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        padding-bottom: 12px;
        position: relative;
        transition: all 0.3s ease;
    }

    .mega-title:before {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 30px;
        height: 2px;
        background: var(--primary-gradient);
        transition: width 0.3s ease;
    }

    html[dir="ltr"] .mega-title:before {
        right: auto;
        left: 0;
    }

    .mega-title i {
        font-size: 14px;
        color: var(--primary-color);
        transition: transform 0.3s ease;
    }

    .mega-column:hover .mega-title {
        color: var(--primary-color);
    }

    .mega-column:hover .mega-title:before {
        width: 100%;
    }

    .mega-column:hover .mega-title i {
        transform: translateX(-5px);
    }

    html[dir="ltr"] .mega-column:hover .mega-title i {
        transform: translateX(5px);
    }

    .mega-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mega-links li {
        margin-bottom: 6px;
        overflow: hidden;
    }

    .mega-links li a {
        color: #555;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        font-weight: 500;
        padding: 6px 0;
        position: relative;
    }

    .mega-links li a:hover {
        color: var(--primary-color);
        padding-right: 12px;
    }

    html[dir="ltr"] .mega-links li a:hover {
        padding-right: 0;
        padding-left: 12px;
    }

    .mega-links li a:after {
        content: '←';
        position: absolute;
        right: -20px;
        opacity: 0;
        transition: all 0.3s ease;
        font-weight: bold;
    }

    html[dir="ltr"] .mega-links li a:after {
        content: '→';
        right: auto;
        left: -20px;
    }

    .mega-links li a:hover:after {
        right: 0;
        opacity: 1;
    }

    html[dir="ltr"] .mega-links li a:hover:after {
        left: 0;
    }

    .mega-links li a.view-more {
        color: var(--secondary-color);
        font-weight: 700;
        font-size: 13px;
        margin-top: 10px;
        border-top: 1px dashed #eee;
        padding-top: 12px;
    }

    .mega-menu-footer {
        margin-top: 35px;
        padding-top: 25px;
        text-align: center;
    }

    .btn-all-categories {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--primary-gradient);
        color: #fff !important;
        padding: 12px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.4s ease;
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
    }

    .btn-all-categories:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 30px -8px rgba(0,0,0,0.3);
        color: #fff;
    }

    @media (max-width: 1200px) {
        .mega-menu-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .mega-menu {
            display: none !important;
        }
    }
</style>
<!-- Primary: {{ $Setting->primary_color }} | Gradient To: {{ $Setting->primary_color_to }} -->
@stack('css')