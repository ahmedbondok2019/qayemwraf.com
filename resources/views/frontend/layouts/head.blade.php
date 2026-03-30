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
    .modal .close {
        background: #E91E63;
        border: none;
        padding: 10px 20px;
        margin-bottom: 10px;
        color: #fff;
        font-weight: bold;
        font-size: 24px;
        border-radius: 5px;
    }
</style>
@stack('css')