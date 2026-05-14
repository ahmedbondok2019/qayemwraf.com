@extends('frontend.layouts.master')

@push('css')
<style>
    /* Medical Theme Design System */
    :root {
        --medical-bg: #f8fbff;
        --medical-card-shadow: 0 10px 30px rgba(138, 149, 158, 0.1);
        --medical-border-radius: 20px;
    }

    .medical-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        direction: rtl;
    }

    .medical-section-header h2, .medical-section-header h3 {
        font-size: 28px;
        font-weight: 800;
        color: #2c3e50;
        position: relative;
        padding-right: 15px;
    }

    .medical-section-header h2::before, .medical-section-header h3::before {
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

    /* Features Bar */
    .medical-features-bar {
        background: #fff;
        padding: 30px 0;
        border-radius: var(--medical-border-radius);
        box-shadow: var(--medical-card-shadow);
        margin: -40px auto 50px;
        position: relative;
        z-index: 10;
        direction: rtl;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0 20px;
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

    /* Category Cards */
    .medical-cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 25px;
        direction: rtl;
    }

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
    }

    .medical-cat-card:hover .medical-cat-icon-wrapper {
        background: var(--primary-color);
        color: #fff;
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

    /* Product Cards */
    .medical-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 30px;
        direction: rtl;
    }

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
        color: #ff9800;
        font-size: 12px;
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
    }

    .btn-add-cart:hover {
        transform: rotate(90deg);
        box-shadow: 0 5px 15px rgba(28, 77, 173, 0.3);
    }

    /* Medical Slider Styles - Full Width Cover */
    .medical-hero {
        padding: 0;
        position: relative;
        overflow: hidden;
    }

    .medical-slider .swiper-slide {
        height: 720px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding-top: 80px; /* Space for fixed header */
    }

    .medical-slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
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

    .slide-title {
        font-size: clamp(32px, 5vw, 56px);
        font-weight: 800;
        color: #fff;
        margin-bottom: 20px;
        line-height: 1.2;
        text-shadow: 0 4px 15px rgba(0,0,0,0.6);
    }

    .slide-subtitle {
        font-size: 22px;
        color: #fff;
        margin-bottom: 40px;
        line-height: 1.6;
        text-shadow: 0 2px 10px rgba(0,0,0,0.8);
    }

    .slide-actions {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn-primary-medical {
        background: var(--primary-gradient);
        color: #fff !important;
        padding: 15px 45px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(28, 77, 173, 0.4);
        transition: all 0.3s ease;
        border: none;
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

    .btn-primary-medical:hover, .btn-outline-medical:hover {
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

    /* Slider Navigation Custom Styles */
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

    .medical-categories-swiper, .medical-products-swiper {
        padding: 20px 5px !important;
        margin: 0 -10px !important;
    }

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
        .medical-slider .swiper-slide {
            height: 520px;
            padding-top: 60px;
        }
        .medical-slider .swiper-pagination {
            bottom: 30px !important;
        }
        .slide-title {
            font-size: 36px;
        }
        .slide-subtitle {
            font-size: 18px;
        }
    }
    /* Why Choose Us Section */
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

    /* Medical Brands Section */
    .medical-brands-section {
        padding: 50px 0;
        background: #f8fbff;
        direction: rtl;
    }

    .brand-item {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        transition: all 0.3s;
        border: 1px solid #f1f1f1;
    }

    .brand-item:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        transform: translateY(-5px);
    }

    .brand-item img {
        max-width: 100%;
        max-height: 100%;
        filter: grayscale(1);
        opacity: 0.6;
        transition: all 0.3s;
    }

    .brand-item:hover img {
        filter: grayscale(0);
        opacity: 1;
    }

    @media (max-width: 991px) {
        .why-us-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-item:nth-child(2) {
            border-left: none;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush



@section('content')

    
    <div class="home-page">
        
        
        <div class="vibe-hero-section medical-hero">
            <div class="vibe-main-slider medical-slider">
                <div class="swiper main-swiper">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                        <div class="swiper-slide">
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->translation->title ?? '' }}" class="medical-slide-bg" />
                            <div class="container position-relative" style="z-index: 10;">
                                <div class="medical-slide-content mx-auto">
                                    @if($slider->translation && $slider->translation->title)
                                        <h2 class="slide-title animate__animated animate__fadeInUp">{{ $slider->translation->title }}</h2>
                                    @endif
                                    
                                    @if($slider->translation && $slider->translation->subtitle)
                                        <p class="slide-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $slider->translation->subtitle }}</p>
                                    @endif
                                    
                                    <div class="slide-actions animate__animated animate__fadeInUp animate__delay-2s">
                                        @if($slider->translation && $slider->translation->button_text)
                                            <a href="{{ $slider->link ?? '#' }}" class="btn-primary-medical">{{ $slider->translation->button_text }}</a>
                                        @endif
                                        <a href="{{ route('frontend.products.index') }}" class="btn-outline-medical">{{ trans_db('frontend.products') }}</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev custom-nav"></div>
                    <div class="swiper-button-next custom-nav"></div>
                </div>
            </div>
        </div>


        <!-- Medical Features Bar -->
        <div class="container">
            <div class="medical-features-bar">
                <div class="row m-0">
                    <div class="col-lg-3 col-md-6 p-0">
                        <div class="feature-item">
                            <div class="feature-icon-box">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="feature-text">
                                <h4>شحن سريع</h4>
                                <p>لكل المحافظات</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <div class="feature-item">
                            <div class="feature-icon-box">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>
                            <div class="feature-text">
                                <h4>ضمان حقيقي</h4>
                                <p>على جميع المنتجات</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <div class="feature-item">
                            <div class="feature-icon-box">
                                <i class="fa-solid fa-medal"></i>
                            </div>
                            <div class="feature-text">
                                <h4>جودة عالية</h4>
                                <p>معايير عالمية</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <div class="feature-item">
                            <div class="feature-icon-box">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="feature-text">
                                <h4>دعم فني</h4>
                                <p>خدمة ما بعد البيع</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($categories) && $categories->count() > 0)
        <!-- Medical Categories Section -->
        <section class="medical-categories-section py-5">
            <div class="container">
                <div class="medical-section-header">
                    <h2>أهم الفئات</h2>
                    <a href="{{ route('frontend.products.index') }}" class="view-all">عرض كل الفئات <i class="fa-solid fa-angle-left"></i></a>
                </div>

                <div class="swiper medical-categories-swiper">
                    <div class="swiper-wrapper">
                        @foreach($categories as $category)
                        <div class="swiper-slide">
                            <a href="{{ url('ar/products/' . ($category->translation->slug ?? '')) }}" class="medical-cat-card">
                                <div class="medical-cat-icon-wrapper">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" />
                                </div>
                                <span class="medical-cat-title">{{ $category->name }}</span>
                                <span class="medical-cat-count">{{ $category->products_count }} منتج</span>
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


        
        
   

        @if(isset($subcategories) && $subcategories->count() > 0)
        <!-- Subcategories Slider Section -->
        <section class="vibe-subcat-section">
            <div class="container">
                <div class="vibe-section-header">
                    <h2>أقسام المنتجات</h2>
                </div>

                <!-- Mobile Subcategory Search -->
                <div class="vibe-mobile-cat-search">
                    <input type="text" id="subcatSearchInput" placeholder="ابحث عن {{ trans_db('website.Category') }}...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="subcat-grid" id="vibeSubcatGrid">
                    <div id="no-subcats-message" class="vibe-no-results" style="display: none;">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>لا توجد أقسام مطابقة للبحث</p>
                    </div>
                    @foreach($subcategories as $subcat)
                    <a href="{{ url('ar/products/' . ($subcat->translation->slug ?? '')) }}" class="vibe-subcat-card">
                        @if($subcat->parent)
                        <span class="vibe-subcat-parent">{{ $subcat->parent->name }}</span>
                        @endif
                        <div class="vibe-subcat-img-wrapper">
                            <img src="{{ asset($subcat->image) }}" alt="{{ $subcat->name }}" />
                        </div>
                        <h4 class="vibe-subcat-title">{{ $subcat->name }}</h4>
                        <span class="vibe-subcat-count">{{ $subcat->products_count }} {{ trans_db('website.book') }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
{{--  --}}
        <!-- Product Slider  -->        @if(isset($bestSellers) && $bestSellers->count() > 0)
        <!-- Medical Best Sellers Section -->
        <section class="medical-best-sellers py-5" style="background: var(--medical-bg);">
            <div class="container">
                <div class="medical-section-header">
                    <h3>الأفضل مبيعاً</h3>
                    <a href="{{ route('frontend.best-sellers') }}" class="view-all">عرض كل المنتجات <i class="fa-solid fa-angle-left"></i></a>
                </div>

                <div class="swiper medical-products-swiper">
                    <div class="swiper-wrapper">
                        @foreach($bestSellers as $product)
                        <div class="swiper-slide">
                            <div class="medical-product-card">
                                @if($product->flashSales->isNotEmpty() || $product->has_special_price)
                                    <span class="product-badge">خصم مميز</span>
                                @else
                                    <span class="product-badge" style="background: var(--primary-color);">الأكثر مبيعاً</span>
                                @endif

                                <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-image-box">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? 'Product' }}">
                                </a>

                                <div class="product-info-box">
                                    <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-title">
                                        {{ $product->translation->name ?? 'منتج طبي' }}
                                    </a>

                                    <div class="product-price-box">
                                        @if($product->has_special_price)
                                            <span class="current-price">{{ format_price($product->special_price) }}</span>
                                            <span class="old-price">{{ format_price($product->price) }}</span>
                                        @else
                                            <span class="current-price">{{ format_price($product->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="product-rating">
                                        @php $rating = $product->ratings_avg_rating ?? 5; @endphp
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="{{ $i < $rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                    </div>

                                    <div class="product-actions">
                                        <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="btn-view-details">عرض التفاصيل</a>
                                        <button class="btn-add-cart add-to-cart" data-id="{{ $product->id }}" {{ !($product->quantity > 0 || $product->ignore_quantity) ? 'disabled title="غير متوفر"' : '' }}>
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
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

        @if(isset($latestProducts) && $latestProducts->count() > 0)
        <!-- Medical Latest Products Section -->
        <section class="medical-latest-products py-5">
            <div class="container">
                <div class="medical-section-header">
                    <h3>أحدث المنتجات</h3>
                    <a href="{{ route('frontend.latest-products') }}" class="view-all">عرض كل المنتجات <i class="fa-solid fa-angle-left"></i></a>
                </div>

                <div class="swiper medical-products-swiper">
                    <div class="swiper-wrapper">
                        @foreach($latestProducts as $product)
                        <div class="swiper-slide">
                            <div class="medical-product-card">
                                <span class="product-badge" style="background: #ff9800;">وصل حديثاً</span>

                                <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-image-box">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? 'Product' }}">
                                </a>

                                <div class="product-info-box">
                                    <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="product-title">
                                        {{ $product->translation->name ?? 'منتج طبي' }}
                                    </a>

                                    <div class="product-price-box">
                                        @if($product->has_special_price)
                                            <span class="current-price">{{ format_price($product->special_price) }}</span>
                                            <span class="old-price">{{ format_price($product->price) }}</span>
                                        @else
                                            <span class="current-price">{{ format_price($product->price) }}</span>
                                        @endif
                                    </div>

                                    <div class="product-rating">
                                        @php $rating = $product->ratings_avg_rating ?? 5; @endphp
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="{{ $i < $rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                        @endfor
                                    </div>

                                    <div class="product-actions">
                                        <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="btn-view-details">عرض التفاصيل</a>
                                        <button class="btn-add-cart add-to-cart" data-id="{{ $product->id }}" {{ !($product->quantity > 0 || $product->ignore_quantity) ? 'disabled title="غير متوفر"' : '' }}>
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
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

              

        
        <!-- Why Choose Us Section -->
        <section class="container">
            <div class="medical-why-us">
                <div class="row m-0 align-items-center">
                    <div class="col-lg-5 p-0 d-none d-lg-block">
                        <div class="why-us-image h-100">
                            <img src="{{ asset('frontend/images/medical_building.png') }}" alt="Medical Center">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="why-us-content">
                            <span class="why-us-tag">لماذا نحن؟</span>
                            <h2 class="why-us-title">إيجي ميديكال مؤسسة رائدة في مجال الأجهزة والمستلزمات الطبية</h2>
                            <p class="why-us-desc">نقدم منتجات عالية الجودة وحلول متكاملة تلبي احتياجات المستشفيات والعيادات في جميع أنحاء مصر، مع الالتزام بأعلى المعايير العالمية في الخدمة والضمان.</p>
                            
                            <div class="why-us-stats">
                                <div class="stat-item">
                                    <i class="fa-solid fa-box-open stat-icon"></i>
                                    <span class="stat-number">+2000</span>
                                    <span class="stat-label">منتج متنوع</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-award stat-icon"></i>
                                    <span class="stat-number">+10</span>
                                    <span class="stat-label">سنين خبرة</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-hospital stat-icon"></i>
                                    <span class="stat-number">+500</span>
                                    <span class="stat-label">مستشفى وعيادة</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-headset stat-icon"></i>
                                    <span class="stat-number">24/7</span>
                                    <span class="stat-label">خدمة عملاء</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if(isset($brands) && $brands->count() > 0)
        <!-- Medical Brands Section -->
        <section class="medical-brands-section py-5">
            <div class="container">
                <div class="medical-section-header">
                    <h3>شركاؤنا في النجاح</h3>
                    <a href="{{ url('ar/brands') }}" class="view-all">عرض كل الشركات <i class="fa-solid fa-angle-left"></i></a>
                </div>

                <div class="swiper medical-brands-swiper">
                    <div class="swiper-wrapper">
                        @foreach($brands as $brand)
                        <div class="swiper-slide">
                            <a href="{{ route('frontend.products.index', ['brands[]' => $brand->id]) }}" class="brand-item">
                                @if($brand->image)
                                    <img src="{{ asset($brand->image) }}" alt="{{ $brand->translation->title ?? 'Brand' }}">
                                @else
                                    <span class="font-weight-bold text-muted">{{ $brand->translation->title ?? 'LOGO' }}</span>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif






@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Categories Swiper
        new Swiper('.medical-categories-swiper', {
            slidesPerView: 2.5,
            spaceBetween: 20,
            rtl: true,
            navigation: {
                nextEl: '.medical-categories-section .swiper-button-next',
                prevEl: '.medical-categories-section .swiper-button-prev',
            },
            breakpoints: {
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 5 },
                1200: { slidesPerView: 6 },
            }
        });

        // Products Swipers
        document.querySelectorAll('.medical-products-swiper').forEach(function(el) {
            const section = el.closest('section');
            new Swiper(el, {
                slidesPerView: 1.5,
                spaceBetween: 20,
                rtl: true,
                navigation: {
                    nextEl: section.querySelector('.swiper-button-next'),
                    prevEl: section.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    480: { slidesPerView: 2.2 },
                    768: { slidesPerView: 3 },
                    1024: { slidesPerView: 4 },
                    1200: { slidesPerView: 5 },
                }
            });
        });

        // Brands Swiper
        new Swiper('.medical-brands-swiper', {
            slidesPerView: 3,
            spaceBetween: 20,
            rtl: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 6 },
            }
        });
    });
</script>
@endpush
