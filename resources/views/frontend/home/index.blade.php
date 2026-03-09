@extends('frontend.layouts.master')
@section('content')

    
    <div class="home-page">
        
        
        <div class="vibe-hero-section">
            <div class="container">
                <!-- Hero Slider -->
                <div class="vibe-main-slider">
                    <div class="swiper main-swiper">
                        <div class="swiper-wrapper">
                            @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <a href="{{ $slider->link ?? url('/') }}" class="vibe-slider-link">
                                    <div class="vibe-slide-image-wrapper">
                                        <img src="{{ asset($slider->image) }}" alt="{{ $slider->translation->title ?? '' }}" />
                                        <div class="vibe-overlay"></div>
                                    </div>
                                    
                                    @if($slider->translation && ($slider->translation->title || $slider->translation->subtitle || $slider->translation->button_text))
                                    <div class="vibe-slider-content">
                                        @if($slider->translation->title)
                                        <h2 class="vibe-slider-title">{{ $slider->translation->title }}</h2>
                                        @endif
                                        
                                        @if($slider->translation->subtitle)
                                        <p class="vibe-slider-subtitle">{{ $slider->translation->subtitle }}</p>
                                        @endif
                                        
                                        @if($slider->translation->button_text)
                                        <span class="vibe-slider-btn">{{ $slider->translation->button_text }} <i class="fa-solid fa-arrow-left"></i></span>
                                        @endif
                                    </div>
                                    @endif
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>

                <!-- Offers Horizontal Scroll -->
                @if(isset($offers) && $offers->count() > 0)
                <div class="vibe-offers-container">
                    <div class="vibe-offers-header">
                        <h3>أقوى العروض</h3>
                        <a href="{{ url('ar/siteMap') }}">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-angle-left"></i></a>
                    </div>
                    <div class="vibe-offers-slider">
                        @foreach($offers as $offer)
                        <div class="vibe-offer-item">
                            <a href="{{ $offer->category_id ? url('ar/products/' . ($offer->category->translation->slug ?? '')) . '?flash_sale=1' : url('ar/products?flash_sale=1') }}">
                                <div class="vibe-offer-image">
                                    <img src="{{ asset($offer->image) }}" alt="{{ $offer->name }}" />
                                </div>
                                <span class="vibe-offer-name">{{ $offer->name }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Home Advertisements Slider --}}
                {{-- Home Advertisements Slider --}}
                @if(isset($homeAds) && $homeAds->count() > 0)
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="swiper-container home-ads-swiper" style="overflow: hidden; border-radius: 8px;">
                            <div class="swiper-wrapper">
                                @foreach($homeAds as $ad)
                                    <div class="swiper-slide position-relative">
                                        @if($ad->image)
                                            <a href="{{ $ad->link ?? '#' }}" class="d-block w-100 h-100 text-decoration-none">
                                                <div style="position: relative; width: 100%; height: 350px;">
                                                    <img src="{{ asset($ad->image) }}" alt="Advertisement" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

                
                @endif
            </div>
        </div>



        <!-- Elegant Categories Section -->
        <section class="vibe-categories-section">
            <div class="container">
                <div class="vibe-section-header">
                    <h2>أهم الفئات</h2>
                    <a href="{{ url('ar/products') }}" class="view-all">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-arrow-left"></i></a>
                </div>

                <!-- Mobile Category Search -->
                <div class="vibe-mobile-cat-search">
                    <input type="text" id="catSearchInput" placeholder="ابحث عن {{ trans_db('website.Category') }}...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="vibe-category-grid" id="vibeCategoryGrid">
                    <div id="no-categories-message" class="vibe-no-results" style="display: none;">
                        <i class="fa-regular fa-folder-open"></i>
                        <p>لا توجد فئات مطابقة للبحث</p>
                    </div>
                    @foreach($categories as $category)
                    <a href="{{ url('ar/products/' . ($category->translation->slug ?? '')) }}" class="vibe-cat-card">
                        <div class="vibe-cat-img-wrapper">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" />
                        </div>
                        <div class="vibe-cat-info">
                            <span class="vibe-cat-title">{{ $category->name }}</span>
                            <span class="vibe-cat-count">{{ $category->products_count }} {{ trans_db('website.book') }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        
        
   

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

        <!-- Product Slider  -->
        <!-- Best Sellers Section -->
        <div class="container">
            <div class="best-seller-section">
                <div class="section-header">
                    <h3>الأفضل مبيعاً</h3>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Mobile View Toggles -->
                        <div class="view-toggles d-md-none" style="display: flex; gap: 5px;">
                           <button class="btn-view-toggle active" data-target=".best-seller-section .products-grid" data-view="grid" title="{{ trans_db('website.View') }} قائمة"><i class="fa-solid fa-list-ul"></i></button>
                           <button class="btn-view-toggle" data-target=".best-seller-section .products-grid" data-view="horizontal" title="{{ trans_db('website.View') }} شريط"><i class="fa-solid fa-arrow-right-arrow-left"></i></button>
                        </div>
                        <a href="{{ url('ar/best-sellers') }}">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="vibe-mobile-cat-search d-md-none" style="display: block; margin-bottom: 15px;">
                    <div class="vibe-cat-search-box">
                        <input type="text" id="bestSellersSearch" class="vibe-cat-search-input" placeholder="بحث...">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </div>
                </div>
                
                <div id="best-sellers-no-results" class="vibe-no-results" style="display: none;">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>لا توجد منتجات مطابقة للبحث</p>
                </div>
                
                <div class="products-grid">
                    @foreach($bestSellers as $product)
                    <div class="v-card">
                        <!-- Status Indicators (Always visible) -->
                        <div class="v-status-indicators">
                            @if(isset($cartProducts[$product->id]))
                                <span class="v-status-dot cart-dot" title="{{ trans_db('website.In Cart') }}"><i class="fa-solid fa-check"></i></span>
                            @endif
                            @if(in_array($product->id, $wishlistIds))
                                <span class="v-status-dot wish-dot" title="{{ trans_db('website.In Wishlist') }}"><i class="fa-solid fa-heart"></i></span>
                            @endif
                        </div>

                        <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-img-link">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? 'Product' }}">
                        </a>
                        <div class="v-card-content">
                            <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-title" title="{{ $product->translation->name ?? '' }}">
                                {{ $product->translation->name ?? trans_db('website.Untitled product') }}
                            </a>
                            
                            @if($product->brand)
                            <div class="v-card-author">
                                <i class="fa-solid fa-pen-nib" style="color: #95a5a6; font-size: 11px;"></i> {{ $product->brand->translation->title ?? '' }}
                            </div>
                            @endif

                            <div class="v-card-price-box">
                                @if($product->flashSales->isNotEmpty())
                                    @php 
                                        $flashSale = $product->flashSales->first();
                                        $flashPrice = $flashSale->pivot->price;
                                        $originalPrice = $product->price;
                                        $discount = $originalPrice > 0 ? round((($originalPrice - $flashPrice) / $originalPrice) * 100) : 0;
                                    @endphp
                                    <span class="v-current-price">{{ format_price($flashPrice) }}</span>
                                    <span class="v-old-price">{{ format_price($originalPrice) }}</span>
                                    <span class="v-discount-badge" style="background-color: #e74c3c; color: #fff;">
                                        <i class="fa-solid fa-bolt"></i> {{ $flashSale->translation->name ?? 'عرض فلاش' }} (-{{ $discount }}%)
                                    </span>
                                @elseif($product->special_price && $product->special_price > 0 && ($product->special_price_start <= now() && $product->special_price_end >= now()))
                                    <span class="v-current-price">{{ format_price($product->special_price) }}</span>
                                    <span class="v-old-price">{{ format_price($product->price) }}</span>
                                    <span class="v-discount-badge">{{ round((($product->price - $product->special_price) / $product->price) * 100) }}% خصم</span>
                                @else
                                    <span class="v-current-price">{{ format_price($product->price) }}</span>
                                @endif
                            </div>
                            @include('frontend.products.partials.rating_display', ['product' => $product])
                        </div>
                        <div class="v-card-actions">
                            <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" 
                                    data-id="{{ $product->id }}" title="{{ trans_db('website.In Wishlist') }}">
                                <i class="{{ in_array($product->id, $wishlistIds) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            
                            @if(isset($cartProducts[$product->id]))
                                <div class="qty-control" data-id="{{ $product->id }}">
                                    <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                                    <span class="qty-display">{{ $cartProducts[$product->id] }}</span>
                                    <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
                                </div>
                            @else
                                <button class="v-add-btn" data-id="{{ $product->id }}" title="{{ trans_db('website.Add to Cart') }}">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
               
                

        <!-- Product Slider  -->
        <!-- Latest Products Section -->
        <div class="container">
            <div class="latest-products-section">
                <div class="section-header">
                    <h3>أحدث المنتجات</h3>
                    <div class="d-flex align-items-center gap-2">
                         <!-- Mobile View Toggles -->
                         <div class="view-toggles d-md-none" style="display: flex; gap: 5px;">
                            <button class="btn-view-toggle active" data-target=".latest-products-section .products-grid" data-view="grid" title="{{ trans_db('website.View') }} قائمة"><i class="fa-solid fa-list-ul"></i></button>
                            <button class="btn-view-toggle" data-target=".latest-products-section .products-grid" data-view="horizontal" title="{{ trans_db('website.View') }} شريط"><i class="fa-solid fa-arrow-right-arrow-left"></i></button>
                         </div>
                        <a href="{{ url('ar/latest-products') }}">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                </div>
                
                <!-- Search Input -->
                <div class="vibe-mobile-cat-search d-md-none" style="display: block; margin-bottom: 15px;">
                    <div class="vibe-cat-search-box">
                        <input type="text" id="latestProductsSearch" class="vibe-cat-search-input" placeholder="بحث...">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </div>
                </div>
                
                <div id="latest-products-no-results" class="vibe-no-results" style="display: none;">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>لا توجد منتجات مطابقة للبحث</p>
                </div>
                
                <div class="products-grid">
                    @foreach($latestProducts as $product)
                    <div class="v-card">
                        <!-- Status Indicators (Always visible) -->
                        <div class="v-status-indicators">
                            @if(isset($cartProducts[$product->id]))
                                <span class="v-status-dot cart-dot" title="{{ trans_db('website.In Cart') }}"><i class="fa-solid fa-check"></i></span>
                            @endif
                            @if(in_array($product->id, $wishlistIds))
                                <span class="v-status-dot wish-dot" title="{{ trans_db('website.In Wishlist') }}"><i class="fa-solid fa-heart"></i></span>
                            @endif
                        </div>
                        
                        <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-img-link">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? 'Product' }}">
                        </a>
                        <div class="v-card-content">
                            <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-title" title="{{ $product->translation->name ?? '' }}">
                                {{ $product->translation->name ?? trans_db('website.Untitled product') }}
                            </a>
                            
                            @if($product->brand)
                            <div class="v-card-author">
                                <i class="fa-solid fa-pen-nib" style="color: #95a5a6; font-size: 11px;"></i> {{ $product->brand->translation->title ?? '' }}
                            </div>
                            @endif

                            <div class="v-card-price-box">
                                @if($product->flashSales->isNotEmpty())
                                    @php 
                                        $flashSale = $product->flashSales->first();
                                        $flashPrice = $flashSale->pivot->price;
                                        $originalPrice = $product->price;
                                        $discount = $originalPrice > 0 ? round((($originalPrice - $flashPrice) / $originalPrice) * 100) : 0;
                                    @endphp
                                    <span class="v-current-price">{{ format_price($flashPrice) }}</span>
                                    <span class="v-old-price">{{ format_price($originalPrice) }}</span>
                                    <span class="v-discount-badge" style="background-color: #e74c3c; color: #fff;">
                                        <i class="fa-solid fa-bolt"></i> {{ $flashSale->translation->name ?? 'عرض فلاش' }} (-{{ $discount }}%)
                                    </span>
                                @elseif($product->special_price && $product->special_price > 0 && ($product->special_price_start <= now() && $product->special_price_end >= now()))
                                    <span class="v-current-price">{{ format_price($product->special_price) }}</span>
                                    <span class="v-old-price">{{ format_price($product->price) }}</span>
                                    <span class="v-discount-badge">{{ round((($product->price - $product->special_price) / $product->price) * 100) }}% خصم</span>
                                @else
                                    <span class="v-current-price">{{ format_price($product->price) }}</span>
                                @endif
                            </div>
                            @include('frontend.products.partials.rating_display', ['product' => $product])
                        </div>
                        <div class="v-card-actions">
                            <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" 
                                    data-id="{{ $product->id }}" title="{{ trans_db('website.In Wishlist') }}">
                                <i class="{{ in_array($product->id, $wishlistIds) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                            </button>
                            
                            @if(isset($cartProducts[$product->id]))
                                <div class="qty-control" data-id="{{ $product->id }}">
                                    <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                                    <span class="qty-display">{{ $cartProducts[$product->id] }}</span>
                                    <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
                                </div>
                            @else
                                <button class="v-add-btn" data-id="{{ $product->id }}" title="{{ trans_db('website.Add to Cart') }}">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
              

        
                <!-- Product Slider  -->
               <!-- Brands Section -->
        <div class="container">
            <div class="vibe-brands-section">
                <div class="vibe-brands-header">
                    <h3>شركاء النجاح</h3>
                    <a href="{{ url('ar/brands') }}">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-arrow-left"></i></a>
                </div>
                <div class="swiper brands-swiper">
                    <div class="swiper-wrapper">
                        @foreach($brands as $brand)
                        <div class="swiper-slide" style="width: auto;">
                            <!-- Using text only as requested -->
                            <a href="{{ route('frontend.products.index', ['brands[]' => $brand->id]) }}" class="vibe-brand-card">
                                <span class="vibe-brand-name">{{ $brand->translation->title ?? 'Brand' }}</span>
                                <span class="vibe-brand-dot"></span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        


        <!-- Blogs Section -->
        <section class="home-blogs-section py-5">
            <div class="container">
                <div class="vibe-section-header mb-4">
                    <h2>أحدث المقالات</h2>
                    <a href="{{ url('ar/blogs') }}" class="view-all">{{ trans_db('website.View') }} {{ trans_db('website.All') }} <i class="fa-solid fa-arrow-left"></i></a>
                </div>
                <div class="row">
                    @foreach($blogs as $blog)
                    <div class="col-6 col-lg-4 col-md-6 mb-4">
                        <div class="blog-card-modern h-100 shadow-sm rounded-20 overflow-hidden bg-white">
                            <div class="blog-img-wrapper position-relative" style="height: 220px;">
                                @if($blog->BlogTranslation && $blog->BlogTranslation->image)
                                    <img src="{{ asset($blog->BlogTranslation->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $blog->BlogTranslation->title }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                        <i class="fa-regular fa-image fa-3x"></i>
                                    </div>
                                @endif
                                <div class="blog-date-badge position-absolute" style="top: 15px; right: 15px; background: rgba(0,0,0,0.6); color: white; padding: 5px 12px; border-radius: 50px; font-size: 0.8rem;">
                                    {{ $blog->created_at->format('d M, Y') }}
                                </div>
                            </div>
                            <div class="blog-content-wrapper p-4">
                                @if($blog->category)
                                <span class="badge mb-2" style="background: #f0f4ff; color: #667eea;">{{ $blog->category->translation->title ?? '' }}</span>
                                @endif
                                <h4 class="blog-title font-weight-bold mb-3" style="line-height: 1.4; font-size: 1.25rem;">
                                    <a href="{{ url('ar/blog/' . $blog->id . '/' . ($blog->BlogTranslation->slug ?? '')) }}" class="text-dark text-decoration-none hover-primary">
                                        {{ $blog->BlogTranslation->title ?? 'بدون عنوان' }}
                                    </a>
                                </h4>
                                <p class="blog-excerpt text-muted mb-4" style="font-size: 0.95rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ strip_tags($blog->BlogTranslation->description ?? '') }}
                                </p>
                                <a href="{{ url('ar/blog/' . $blog->id . '/' . ($blog->BlogTranslation->slug ?? '')) }}" class="read-more-btn font-weight-bold" style="color: #667eea; text-decoration: none;">
                                    إقرأ المزيد <i class="fa-solid fa-arrow-left ml-1" style="font-size: 0.8rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Extra Features -->
  <div class="container features">
    <div class="icon_boxes">
     
      <div class="details">
        <!-- Extra Features: Vibe Style -->
        <div class="container">
            <!-- Desktop Layout -->
            <div class="vibe-features-section d-none d-lg-flex">
                <div class="vibe-feature-card">
                    <div class="vibe-feature-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div class="vibe-feature-info">
                        <h5 class="vibe-feature-title">شحن لحد البيت</h5>
                        <p class="vibe-feature-desc">توصيل سريع وآ{{ trans_db('website.From') }} لباب {{ trans_db('website.From') }}زلك</p>
                    </div>
                </div>
                
                <div class="vibe-feature-card">
                    <div class="vibe-feature-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="vibe-feature-info">
                        <h5 class="vibe-feature-title">مدفوعات مضمونة</h5>
                        <p class="vibe-feature-desc">استرجاع خلال 14 يوم (تطبق الشروط)</p>
                    </div>
                </div>
                
                <div class="vibe-feature-card">
                    <div class="vibe-feature-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="vibe-feature-info">
                        <h5 class="vibe-feature-title">دعم فنى متواصل</h5>
                        <p class="vibe-feature-desc">خدمة عملاء مميزة على مدار الساعة</p>
                    </div>
                </div>
                
                <div class="vibe-feature-card">
                    <div class="vibe-feature-icon">
                        <i class="fa-regular fa-credit-card"></i>
                    </div>
                    <div class="vibe-feature-info">
                        <h5 class="vibe-feature-title">طرق دفع متعددة</h5>
                        <p class="vibe-feature-desc">ادفع كاش أو بالبطاقة أو تقسيط</p>
                    </div>
                </div>
            </div>

            <!-- Mobile Layout (Swiper Ticker) -->
            <div class="vibe-features-section swiper icon-boxes-swiper d-lg-none">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="width: auto;">
                        <div class="vibe-feature-card">
                            <div class="vibe-feature-icon">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="vibe-feature-info">
                                <h5 class="vibe-feature-title">شحن لحد البيت</h5>
                                <p class="vibe-feature-desc">توصيل سريع وآ{{ trans_db('website.From') }} لباب {{ trans_db('website.From') }}زلك</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide" style="width: auto;">
                        <div class="vibe-feature-card">
                            <div class="vibe-feature-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="vibe-feature-info">
                                <h5 class="vibe-feature-title">مدفوعات مضمونة</h5>
                                <p class="vibe-feature-desc">استرجاع خلال 14 يوم (تطبق الشروط)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide" style="width: auto;">
                        <div class="vibe-feature-card">
                            <div class="vibe-feature-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="vibe-feature-info">
                                <h5 class="vibe-feature-title">دعم فنى متواصل</h5>
                                <p class="vibe-feature-desc">خدمة عملاء مميزة على مدار الساعة</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide" style="width: auto;">
                        <div class="vibe-feature-card">
                            <div class="vibe-feature-icon">
                                <i class="fa-regular fa-credit-card"></i>
                            </div>
                            <div class="vibe-feature-info">
                                <h5 class="vibe-feature-title">طرق دفع متعددة</h5>
                                <p class="vibe-feature-desc">ادفع كاش أو بالبطاقة أو تقسيط</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('catSearchInput');
        const grid = document.getElementById('vibeCategoryGrid');
        const cards = grid.querySelectorAll('.vibe-cat-card');
        const noResultsMsg = document.getElementById('no-categories-message');

        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                let hasResults = false;

                cards.forEach(card => {
                    const title = card.querySelector('.vibe-cat-title').textContent.toLowerCase();
                    if(title.includes(term)) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if(noResultsMsg) {
                    noResultsMsg.style.display = hasResults ? 'none' : 'flex';
                }
            });
        }

        // Subcategory Search Logic
        const subcatSearchInput = document.getElementById('subcatSearchInput');
        const subcatGrid = document.getElementById('vibeSubcatGrid');
        
        if(subcatSearchInput && subcatGrid) {
            const subcatCards = subcatGrid.querySelectorAll('.vibe-subcat-card');
            const noSubcatsMsg = document.getElementById('no-subcats-message');

            subcatSearchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                let hasResults = false;

                subcatCards.forEach(card => {
                    const title = card.querySelector('.vibe-subcat-title').textContent.toLowerCase();
                    if(title.includes(term)) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if(noSubcatsMsg) {
                    noSubcatsMsg.style.display = hasResults ? 'none' : 'flex';
                }
            });
        }
    });
</script>
@endpush
