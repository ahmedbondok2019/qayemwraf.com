@extends('frontend.layouts.master')

@section('title', trans_db('website.Home'))

@push('css')
<style>
    /* ==============================
       Medical Theme Design System
    ============================== */
    :root {
        --medical-bg: #f8fbff;
        --medical-card-shadow: 0 10px 30px rgba(138, 149, 158, 0.1);
        --medical-border-radius: 20px;
        --header-offset: 110px;
        --medical-hero-height: calc(100vh - var(--header-offset));
    }

    .home-page {
        padding-top: var(--header-offset);
    }

    /* ==============================
       Section Headers
    ============================== */
    .medical-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        direction: rtl;
    }
    .medical-section-header h2,
    .medical-section-header h3 {
        font-size: 28px;
        font-weight: 800;
        color: #2c3e50;
        position: relative;
        padding-right: 15px;
    }
    .medical-section-header h2::before,
    .medical-section-header h3::before {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: var(--primary-gradient);
        border-radius: 10px;
    }
    .medical-section-header .view-all {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s;
    }
    .medical-section-header .view-all:hover {
        padding-left: 10px;
    }

    /* ==============================
       Hero Slider
    ============================== */
    .medical-hero {
        padding: 0;
        position: relative;
        overflow: hidden;
        min-height: var(--medical-hero-height);
    }
    .medical-slider .swiper-slide {
        height: var(--medical-hero-height);
        min-height: 420px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding-top: 0;
    }
    .medical-slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        opacity: 1;
        z-index: 1;
    }
    .medical-slider .swiper-pagination {
        bottom: 60px !important;
    }
    .medical-slide-content {
        position: relative;
        z-index: 10;
        text-align: center;
        color: #fff;
        max-width: 800px;
        padding: 0 20px;
    }
    .btn-outline-medical {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        color: #fff !important;
        padding: 15px 45px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        border: 2px solid #fff;
        transition: all 0.3s ease;
    }
    .btn-outline-medical:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    .custom-nav {
        color: #fff !important;
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        transition: all 0.3s;
    }
    .custom-nav:hover {
        background: var(--primary-color);
    }

    /* ==============================
       Features Bar
    ============================== */
    .medical-features-bar {
        background: #fff;
        border-radius: var(--medical-border-radius);
        box-shadow: var(--medical-card-shadow);
        margin: -10px auto 50px;
        position: relative;
        z-index: 10;
        direction: rtl;
    }
    .feature-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px 20px;
        border-left: 1px solid #eee;
    }
    .feature-item:last-child {
        border-left: none;
    }
    .feature-icon-box {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 24px;
        flex-shrink: 0;
    }
    .feature-text h4 {
        font-size: 16px;
        font-weight: 800;
        margin: 0;
        color: #2c3e50;
    }
    .feature-text p {
        font-size: 13px;
        color: #7f8c8d;
        margin: 0;
    }

    /* ==============================
       Category Cards (Swiper)
    ============================== */
    .medical-cat-card {
        background: #fff;
        border-radius: var(--medical-border-radius);
        padding: 25px 15px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        border: 1px solid #f1f1f1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .medical-cat-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--medical-card-shadow);
        border-color: var(--primary-color);
    }
    .medical-cat-icon-wrapper {
        width: 100px;
        height: 100px;
        background: #f4f9ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        position: relative;
        transition: all 0.3s;
        overflow: hidden;
    }
    .medical-cat-card:hover .medical-cat-icon-wrapper {
        background: var(--primary-color);
    }
    .medical-cat-icon-wrapper img {
        max-width: 60%;
        max-height: 60%;
        object-fit: contain;
    }
    .medical-cat-title {
        font-size: 16px;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    .medical-cat-count {
        font-size: 12px;
        color: #ff9800;
        background: #fff5e6;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
    }

    /* ==============================
       Product Cards (Swiper)
    ============================== */
    .medical-product-card {
        background: #fff;
        border-radius: var(--medical-border-radius);
        padding: 15px;
        position: relative;
        transition: all 0.4s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        border: 1px solid #f1f1f1;
    }
    .medical-product-card:hover {
        box-shadow: var(--medical-card-shadow);
    }
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ff7e5f;
        color: #fff;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 700;
        z-index: 2;
    }
    .product-image-box {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        overflow: hidden;
        border-radius: 12px;
    }
    .product-image-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s;
    }
    .medical-product-card:hover .product-image-box img {
        transform: scale(1.1);
    }
    .product-info-box {
        text-align: center;
    }
    .product-title {
        font-size: 15px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
        text-decoration: none;
        height: 40px;
        overflow: hidden;
    }
    .product-price-box {
        margin-bottom: 15px;
    }
    .current-price {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary-color);
    }
    .old-price {
        font-size: 14px;
        color: #bdc3c7;
        text-decoration: line-through;
        margin-right: 8px;
    }
    .product-rating {
        margin-bottom: 15px;
    }
    .product-actions {
        display: flex;
        gap: 10px;
    }
    .btn-view-details {
        flex: 1;
        background: #f4f9ff;
        color: var(--primary-color);
        padding: 10px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s;
        text-align: center;
    }
    .btn-view-details:hover {
        background: var(--primary-color);
        color: #fff;
    }
    .btn-add-cart {
        width: 42px;
        height: 42px;
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-add-cart:hover {
        transform: rotate(90deg);
        box-shadow: 0 5px 15px rgba(28, 77, 173, 0.3);
    }
    .btn-add-cart:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Wishlist Button */
    .v-wishlist-btn {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #fff;
        border: 1px solid #eee;
        color: #888;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.3s;
        cursor: pointer;
        z-index: 2;
    }
    .v-wishlist-btn:hover, .v-wishlist-btn.active {
        background: #ff4757;
        color: #fff;
        border-color: #ff4757;
    }

    /* Quantity Controls */
    .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        height: 42px;
        background: #f8f9fa;
    }
    .qty-btn {
        background: none;
        border: none;
        width: 32px;
        height: 100%;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        color: var(--primary-color);
        transition: background 0.2s;
    }
    .qty-btn:hover {
        background: #eee;
    }
    .qty-display {
        padding: 0 10px;
        font-weight: bold;
        font-size: 14px;
        min-width: 24px;
        text-align: center;
    }

    /* ==============================
       Category & Product Swiper Nav
    ============================== */
    .cat-nav, .prod-nav {
        background: #fff !important;
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        color: var(--primary-color) !important;
        transition: all 0.3s !important;
    }
    .cat-nav::after, .prod-nav::after {
        font-size: 18px !important;
        font-weight: bold !important;
    }
    .cat-nav:hover, .prod-nav:hover {
        background: var(--primary-color) !important;
        color: #fff !important;
    }
    .medical-categories-swiper,
    .medical-products-swiper {
    /* ==============================
       Why Choose Us
    ============================== */
    .medical-why-us {
        background: #fff;
        border-radius: 30px;
        padding: 60px 0;
        margin: 50px 0;
        box-shadow: var(--medical-card-shadow);
        direction: rtl;
        overflow: hidden;
    }
    .why-us-content {
        padding: 20px 40px;
    }
    .why-us-tag {
        color: var(--primary-color);
        font-weight: 800;
        font-size: 24px;
        margin-bottom: 15px;
        display: block;
    }
    .why-us-title {
        font-size: 32px;
        font-weight: 900;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    .why-us-desc {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.8;
        margin-bottom: 40px;
    }
    .why-us-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        text-align: center;
    }
    .stat-item {
        padding: 20px 10px;
        border-left: 1px solid #f1f1f1;
    }
    .stat-item:last-child {
        border-left: none;
    }
    .stat-icon {
        font-size: 28px;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: block;
    }
    .stat-number {
        font-size: 24px;
        font-weight: 800;
        color: #2c3e50;
        display: block;
    }
    .stat-label {
        font-size: 13px;
        color: #95a5a6;
    }
    .why-us-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
    }

    /* ==============================
       Responsive
    ============================== */
    @media (max-width: 991px) {
        .feature-item {
            border-left: none;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .feature-item:last-child {
            border-bottom: none;
        }
        .medical-features-bar {
            margin-top: 20px;
        }
        .medical-hero {
            min-height: 0;
        }
        .medical-slider .swiper-slide {
            height: clamp(300px, 78vw, 420px) !important;
            min-height: 300px;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-end;
            background: #fff;
        }
        .medical-slide-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            max-height: none;
            display: block;
        }
        .medical-slide-content {
            position: relative;
            z-index: 10;
            margin: 0 auto 14px;
            padding: 0 16px;
            width: 100%;
            max-width: 260px;
        }
        .medical-slider .swiper-pagination {
            bottom: 12px !important;
        }
        .why-us-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-item:nth-child(2) {
            border-left: none;
        }
        .why-us-content {
            padding: 20px 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="home-page">
    {{-- ===================== Hero Slider ===================== --}}
    <div class="vibe-hero-section medical-hero">
        <div class="vibe-main-slider medical-slider">
            <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                    @forelse($sliders ?? [] as $slider)
                    <div class="swiper-slide">
                        <picture>
                            @if($slider->mobile_image)
                            <source media="(max-width: 768px)" srcset="{{ asset($slider->mobile_image) }}" />
                            @endif
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->translation->title ?? $slider->name }}" class="medical-slide-bg" />
                        </picture>
                        <div class="container position-relative" style="z-index: 10">
                            <div class="medical-slide-content mx-auto">
                                @if(($slider->translation->title ?? null) || ($slider->translation->subtitle ?? null))
                                <div class="slide-actions animate__animated animate__fadeInUp animate__delay-2s">
                                    @if($slider->link)
                                    <a href="{{ $slider->link }}" class="btn-outline-medical">
                                        {{ $slider->translation->button_text ?? $slider->translation->title ?? $slider->name ?? trans_db('website.Products') }}
                                    </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide" style="background: var(--primary-color);">
                        <div class="medical-slide-content mx-auto" style="text-align:center;">
                            <h2 class="slide-title">{{ trans_db('website.app_name') }}</h2>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev custom-nav"></div>
                <div class="swiper-button-next custom-nav"></div>
            </div>
        </div>
    </div>

    {{-- ===================== Features Bar ===================== --}}
    <div class="container">
        <div class="medical-features-bar">
            <div class="row m-0">
                <div class="col-lg-3 col-md-6 p-0">
                    <div class="feature-item">
                        <div class="feature-icon-box"><i class="fa-solid fa-truck-fast"></i></div>
                        <div class="feature-text">
                            <h4>{{ trans_db('frontend.Fast Shipping') }}</h4>
                            <p>{{ trans_db('frontend.To all governorates') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                    <div class="feature-item">
                        <div class="feature-icon-box"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="feature-text">
                            <h4>{{ trans_db('frontend.Real guarantee') }}</h4>
                            <p>{{ trans_db('frontend.On all products') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                    <div class="feature-item">
                        <div class="feature-icon-box"><i class="fa-solid fa-medal"></i></div>
                        <div class="feature-text">
                            <h4>{{ trans_db('frontend.High quality') }}</h4>
                            <p>{{ trans_db('frontend.Global standards') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                    <div class="feature-item">
                        <div class="feature-icon-box"><i class="fa-solid fa-headset"></i></div>
                        <div class="feature-text">
                            <h4>{{ trans_db('frontend.Technical support') }}</h4>
                            <p>{{ trans_db('frontend.After sales service') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== Categories Slider ===================== --}}
    @if(isset($categories) && $categories->count())
    <section class="medical-categories-section py-5">
        <div class="container">
            <div class="medical-section-header">
                <h2>{{ trans_db('frontend.Top Categories') }}</h2>
                <a href="{{ route('frontend.products.index') }}" class="view-all">
                    {{ trans_db('frontend.View all categories') }} <i class="fa-solid fa-angle-left"></i>
                </a>
            </div>

            <div class="swiper medical-categories-swiper">
                <div class="swiper-wrapper">
                    @foreach($categories as $category)
                    <div class="swiper-slide">
                        <a href="{{ url(app()->getLocale() . '/products/' . ($category->translation->slug ?? '')) }}" class="medical-cat-card">
                            <div class="medical-cat-icon-wrapper">
                                @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" />
                                @else
                                <i class="fa-solid fa-layer-group" style="font-size:32px; color: var(--primary-color)"></i>
                                @endif
                            </div>
                            <span class="medical-cat-title">{{ $category->name }}</span>
                            <span class="medical-cat-count">{{ $category->products_count ?? 0 }} {{ trans_db('website.book') }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev cat-nav"></div>
                <div class="swiper-button-next cat-nav"></div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== Best Sellers ===================== --}}
    @if(isset($bestSellers) && $bestSellers->count())
    <section class="medical-best-sellers py-5" style="background: var(--medical-bg)">
        <div class="container">
            <div class="medical-section-header">
                <h3>{{ trans_db('frontend.Best Sellers') }}</h3>
                <a href="{{ url(app()->getLocale() . '/best-sellers') }}" class="view-all">
                    {{ trans_db('frontend.View all products') }} <i class="fa-solid fa-angle-left"></i>
                </a>
            </div>

            <div class="swiper medical-products-swiper {{ $bestSellers->count() === 1 ? 'has-single-card' : '' }}">
                <div class="swiper-wrapper">
                    @foreach($bestSellers as $product)
                    <div class="swiper-slide">
                        <div class="medical-product-card v-card">
                            @if($product->flashSales->isNotEmpty() || ($product->special_price && $product->special_price > 0 && ($product->special_price_start <= now() && $product->special_price_end >= now())))
                            <span class="product-badge">{{ trans_db('frontend.Special Discount') }}</span>
                            @endif

                            {{-- Wishlist Button --}}
                            <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds ?? []) ? 'active' : '' }}" data-id="{{ $product->id }}" title="{{ trans_db('website.Favorite') }}">
                                <i class="fa-{{ in_array($product->id, $wishlistIds ?? []) ? 'solid' : 'regular' }} fa-heart"></i>
                            </button>

                            <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-image-box">
                                <img src="{{ asset($product->image ?? 'website/images/default.png') }}"
                                    alt="{{ $product->name }}" loading="lazy" />
                            </a>

                            <div class="product-info-box">
                                <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-title">
                                    {{ $product->name }}
                                </a>

                                <div class="product-price-box">
                                    @if($product->flashSales->isNotEmpty())
                                        @php 
                                            $flashSale = $product->flashSales->first();
                                            $flashPrice = $flashSale->pivot->price;
                                            $originalPrice = $product->price;
                                        @endphp
                                        <span class="current-price">{{ format_price($flashPrice) }}</span>
                                        <span class="old-price">{{ format_price($originalPrice) }}</span>
                                    @elseif($product->special_price && $product->special_price > 0 && ($product->special_price_start <= now() && $product->special_price_end >= now()))
                                        <span class="current-price">{{ format_price($product->special_price) }}</span>
                                        <span class="old-price">{{ format_price($product->price) }}</span>
                                    @else
                                        <span class="current-price">{{ format_price($product->price) }}</span>
                                    @endif
                                </div>

                                <div class="product-rating">
                                    @include('frontend.products.partials.rating_display', ['product' => $product])
                                </div>

                                <div class="product-actions v-card-actions">
                                    <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="btn-view-details">
                                        {{ trans_db('frontend.View Details') }}
                                    </a>
                                    
                                    @if(isset($cartProducts[$product->id]))
                                        <div class="qty-control" data-id="{{ $product->id }}">
                                            <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
                                            <span class="qty-display">{{ $cartProducts[$product->id] }}</span>
                                            <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                                        </div>
                                    @else
                                        <button class="btn-add-cart v-add-btn" data-id="{{ $product->id }}"
                                            {{ $product->quantity <= 0 ? 'disabled title="غير متوفر"' : '' }}>
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev prod-nav"></div>
                <div class="swiper-button-next prod-nav"></div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== Latest Products ===================== --}}
    @if(isset($latestProducts) && $latestProducts->count())
    <section class="medical-latest-products py-5">
        <div class="container">
            <div class="medical-section-header">
                <h3>{{ trans_db('frontend.Latest Products') }}</h3>
                <a href="{{ url(app()->getLocale() . '/latest-products') }}" class="view-all">
                    {{ trans_db('frontend.View all products') }} <i class="fa-solid fa-angle-left"></i>
                </a>
            </div>

            <div class="swiper medical-products-swiper {{ $latestProducts->count() === 1 ? 'has-single-card' : '' }}">
                <div class="swiper-wrapper">
                    @foreach($latestProducts as $product)
                    <div class="swiper-slide">
                        <div class="medical-product-card v-card">
                            <span class="product-badge" style="background: #ff9800">{{ trans_db('frontend.New Arrival') }}</span>

                            {{-- Wishlist Button --}}
                            <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds ?? []) ? 'active' : '' }}" data-id="{{ $product->id }}" title="{{ trans_db('website.Favorite') }}">
                                <i class="fa-{{ in_array($product->id, $wishlistIds ?? []) ? 'solid' : 'regular' }} fa-heart"></i>
                            </button>

                            <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-image-box">
                                <img src="{{ asset($product->image ?? 'website/images/default.png') }}"
                                    alt="{{ $product->name }}" loading="lazy" />
                            </a>

                            <div class="product-info-box">
                                <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-title">
                                    {{ $product->name }}
                                </a>

                                <div class="product-price-box">
                                    @if($product->flashSales->isNotEmpty())
                                        @php 
                                            $flashSale = $product->flashSales->first();
                                            $flashPrice = $flashSale->pivot->price;
                                            $originalPrice = $product->price;
                                        @endphp
                                        <span class="current-price">{{ format_price($flashPrice) }}</span>
                                        <span class="old-price">{{ format_price($originalPrice) }}</span>
                                    @elseif($product->special_price && $product->special_price > 0 && ($product->special_price_start <= now() && $product->special_price_end >= now()))
                                        <span class="current-price">{{ format_price($product->special_price) }}</span>
                                        <span class="old-price">{{ format_price($product->price) }}</span>
                                    @else
                                        <span class="current-price">{{ format_price($product->price) }}</span>
                                    @endif
                                </div>

                                <div class="product-rating">
                                    @include('frontend.products.partials.rating_display', ['product' => $product])
                                </div>

                                <div class="product-actions v-card-actions">
                                    <a href="{{ url(app()->getLocale() . '/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="btn-view-details">
                                        {{ trans_db('frontend.View Details') }}
                                    </a>
                                    
                                    @if(isset($cartProducts[$product->id]))
                                        <div class="qty-control" data-id="{{ $product->id }}">
                                            <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
                                            <span class="qty-display">{{ $cartProducts[$product->id] }}</span>
                                            <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                                        </div>
                                    @else
                                        <button class="btn-add-cart v-add-btn" data-id="{{ $product->id }}"
                                            {{ $product->quantity <= 0 ? 'disabled title="غير متوفر"' : '' }}>
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev prod-nav"></div>
                <div class="swiper-button-next prod-nav"></div>
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== Why Choose Us Cards ===================== --}}
    @php
        $whyChooseData = isset($Setting) && $Setting ? $Setting->getWhyChooseUsFormatted() : (new \App\Models\Setting())->getWhyChooseUsFormatted();
        $iconMap = [
            'shield_check' => 'fa-shield-halved',
            'award' => 'fa-award',
            'stethoscope' => 'fa-user-doctor',
            'wrench' => 'fa-wrench',
        ];
    @endphp
    @if(isset($whyChooseData['items']) && count($whyChooseData['items']))
    <section class="container py-4">
        <div class="why-choose-cards-section text-center p-4 rounded-4" style="background: linear-gradient(135deg, #0b1a30 0%, #152c4e 100%); color: #fff;">
            <h2 class="fw-bold mb-2 text-white">{{ $whyChooseData['title'] }}</h2>
            <p class="text-white-50 mb-4 mx-auto" style="max-width: 650px;">{{ $whyChooseData['subtitle'] }}</p>
            
            <div class="row g-3">
                @foreach($whyChooseData['items'] as $card)
                @php
                    $faIcon = $iconMap[$card['icon']] ?? $card['icon'];
                    if (!str_contains($faIcon, 'fa-')) {
                        $faIcon = 'fa-circle-check';
                    }
                @endphp
                <div class="col-lg-3 col-md-6">
                    <div class="p-3 rounded-3 h-100 d-flex flex-column align-items-center justify-content-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(230, 81, 0, 0.2); color: #ff8a65; font-size: 22px;">
                            <i class="fa-solid {{ $faIcon }}"></i>
                        </div>
                        <h4 class="h6 fw-bold text-white mb-2">{{ $card['title'] }}</h4>
                        <p class="small text-white-50 m-0">{{ $card['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ===================== Why Choose Us ===================== --}}
    <section class="container">
        <div class="medical-why-us">
            <div class="row m-0 align-items-center">
                <div class="col-lg-5 p-0 d-none d-lg-block">
                    <div class="why-us-image h-100">
                        @if(isset($Setting) && $Setting->why_us_image)
                        <img src="{{ asset($Setting->why_us_image) }}" alt="Medical Center" />
                        @else
                        <img src="{{ asset('website/medical_building.png') }}" alt="Medical Center" />
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="why-us-content">
                        <span class="why-us-tag">{{ trans_db('frontend.Why Us?') }}</span>
                        <h2 class="why-us-title">
                            {{ trans_db('frontend.Egi Medical is a leading enterprise in medical equipment and supplies') }}
                        </h2>
                        <p class="why-us-desc">
                            {{ trans_db('frontend.We offer high-quality products and integrated solutions that meet the needs of hospitals and clinics across Egypt, with a commitment to the highest global standards in service and warranty.') }}
                        </p>
                        <div class="why-us-stats">
                            <div class="stat-item">
                                <i class="fa-solid fa-box-open stat-icon"></i>
                                <span class="stat-number">+2000</span>
                                <span class="stat-label">{{ trans_db('frontend.Diverse products') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fa-solid fa-award stat-icon"></i>
                                <span class="stat-number">+10</span>
                                <span class="stat-label">{{ trans_db('frontend.Years of experience') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fa-solid fa-hospital stat-icon"></i>
                                <span class="stat-number">+500</span>
                                <span class="stat-label">{{ trans_db('frontend.Hospitals and clinics') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="fa-solid fa-headset stat-icon"></i>
                                <span class="stat-number">24/7</span>
                                <span class="stat-label">{{ trans_db('frontend.Customer service') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Hero Slider
    if (document.querySelector('.main-swiper')) {
        new Swiper('.main-swiper', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.main-swiper .swiper-pagination', clickable: true },
            navigation: {
                prevEl: '.main-swiper .swiper-button-prev',
                nextEl: '.main-swiper .swiper-button-next',
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });
    }

    // Categories Swiper
    if (document.querySelector('.medical-categories-swiper')) {
        new Swiper('.medical-categories-swiper', {
            slidesPerView: 2.5,
            spaceBetween: 20,
            loop: true,
            rtl: true,
            navigation: {
                prevEl: '.medical-categories-section .swiper-button-prev',
                nextEl: '.medical-categories-section .swiper-button-next',
            },
            breakpoints: {
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 5 },
                1200: { slidesPerView: 6 },
            },
        });
    }

    // Best Sellers & Latest Products Swipers
    document.querySelectorAll('.medical-products-swiper').forEach(function(el) {
        const section = el.closest('section');
        const slideCount = el.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length;
        const isSingleCard = slideCount <= 1;

        if (isSingleCard) {
            el.classList.add('has-single-card');
        }

        new Swiper(el, {
            slidesPerView: isSingleCard ? 1 : 1.5,
            spaceBetween: isSingleCard ? 0 : 20,
            rtl: true,
            centeredSlides: false,
            watchOverflow: true,
            loop: !isSingleCard,
            navigation: {
                prevEl: section.querySelector('.swiper-button-prev'),
                nextEl: section.querySelector('.swiper-button-next'),
            },
            breakpoints: isSingleCard ? undefined : {
                480: { slidesPerView: 2.2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
                1200: { slidesPerView: 5 },
            },
        });
    });
});
</script>
@endpush
