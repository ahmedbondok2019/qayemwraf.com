@extends('frontend.layouts.master')

@section('title')
    {{ (isset($category) && $category->translation) ? $category->translation->title : (request('search') ? trans_db('website.Search results for:') . ' ' . request('search') : trans_db('website.Book Editions')) }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/products_listing.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/home_sections.css') }}">
@endpush

@section('content')
<div class="products-page">
    <div class="premium-page-header">
        <div class="container">
            <h1>{{ (isset($category) && $category->translation) ? $category->translation->title : trans_db('website.Book Editions') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans_db('website.home') }}</a></li>
                    @if(isset($category))
                        <li class="breadcrumb-item"><a href="{{ route('frontend.products.index') }}">{{ trans_db('website.Books') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->translation->title ?? trans_db('website.Category') }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ trans_db('website.Books') }}</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mt-4">
        <button class="btn btn-shop-now btn-toggle-filters d-lg-none">
            <i class="fa-solid fa-filter"></i> {{ trans_db('website.Filter Products') }}
        </button>

        <form action="{{ (isset($category) && $category->translation) ? route('frontend.products.category', $category->translation->slug) : route('frontend.products.index') }}" method="GET" id="filterForm">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <div class="filter-group">
                            <h4 class="filter-title">{{ trans_db('website.Search by book name') }}</h4>
                            <div class="search-box position-relative">
                                <input type="text" name="search" class="price-input" placeholder="{{ trans_db('website.Type book name...') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn-search-icon" style="position: absolute; left: 10px; top: 10px; border: none; background: none; color: #64748b;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h4 class="filter-title">{{ trans_db('website.Price') }} ({{ session('currency_symbol', 'ج.م') }})</h4>
                            <div class="price-range-inputs">
                                <input type="number" name="min_price" class="price-input" placeholder="{{ trans_db('website.From') }}" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="price-input" placeholder="{{ trans_db('website.To') }}" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <div class="filter-group">
                            <h4 class="filter-title">{{ trans_db('website.Brands') }}</h4>
                            <div class="filter-list">
                                @foreach($brands as $brand)
                                <div class="filter-item">
                                    <label class="filter-checkbox">
                                        <input type="checkbox" name="brands[]" value="{{ $brand->id }}" 
                                            {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        {{ $brand->translation->title ?? trans_db('website.Unknown') }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach($options as $option)
                        <div class="filter-group">
                            <h4 class="filter-title">{{ $option->translation->name }}</h4>
                            <div class="filter-list">
                                @foreach($option->values as $val)
                                <div class="filter-item">
                                    <label class="filter-checkbox">
                                        <input type="checkbox" name="options[{{ $option->id }}][]" value="{{ $val->id }}"
                                            {{ (isset(request('options')[$option->id]) && in_array($val->id, request('options')[$option->id])) ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        {{ $val->translation->value }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                        @if(isset($activeFlashSales) && $activeFlashSales->count() > 0)
                        <div class="filter-group">
                            <h4 class="filter-title">{{ trans_db('website.Current Flash Sales') }}</h4>
                            <div class="filter-list">
                                <div class="filter-item">
                                    <label class="filter-checkbox">
                                        <input type="radio" name="flash_sale_id" value="" {{ !request('flash_sale_id') ? 'checked' : '' }} onchange="this.form.submit()">
                                        {{ trans_db('website.All') }}
                                    </label>
                                </div>
                                @foreach($activeFlashSales as $sale)
                                <div class="filter-item">
                                    <label class="filter-checkbox">
                                        <input type="radio" name="flash_sale_id" value="{{ $sale->id }}" 
                                            {{ request('flash_sale_id') == $sale->id ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        {{ $sale->translation->name ?? $sale->name }}
                                        <small class="text-danger" style="display:block; font-size: 10px;">
                                            {{ trans_db('website.Ends:') }} {{ $sale->end_at->format('Y-m-d') }}
                                        </small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="filter-group">
                            <label class="filter-checkbox">
                                <input type="checkbox" name="best_seller" value="1" {{ request('best_seller') ? 'checked' : '' }} onchange="this.form.submit()">
                                <strong>{{ trans_db('website.Best Seller') }}</strong>
                            </label>
                        </div>

                        <button type="submit" class="btn-checkout w-100">{{ trans_db('website.Apply Filter') }}</button>
                        <a href="{{ route('frontend.products.index') }}" class="btn-reset">{{ trans_db('website.Reset') }}</a>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    
                    {{-- Category Advertisements Slider --}}
                    @if(isset($categoryAds) && $categoryAds->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="swiper-container category-ads-swiper" style="overflow: hidden; border-radius: 8px;">
                                <div class="swiper-wrapper">
                                    @foreach($categoryAds as $ad)
                                        <div class="swiper-slide position-relative">
                                            @if($ad->image)
                                                <a href="{{ $ad->link ?? '#' }}" class="d-block w-100 h-100 text-decoration-none">
                                                    <div style="position: relative; width: 100%; height: 250px;">
                                                        <img src="{{ asset($ad->image) }}" alt="{{ $ad->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        
                                                        @if($ad->title)
                                                        <div class="d-flex align-items-center justify-content-center" style="
                                                            position: absolute;
                                                            bottom: 0;
                                                            left: 0;
                                                            right: 0;
                                                            width: 100%;
                                                            background: rgba(0, 0, 0, 0.6);
                                                            padding: 10px;
                                                            transition: all 0.3s ease;
                                                        ">
                                                            <h4 class="m-0 text-white" style="font-size: 1.2rem; font-weight: 600;">{{ $ad->title }}</h4>
                                                        </div>
                                                        @endif
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

                    <div class="listing-header">
                        <div class="results-count">
                            {{ trans_db('website.View') }} {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} من أصل {{ $products->total() }} {{ trans_db('website.book') }}
                        </div>
                        <div class="sort-box">
                            <select name="sort" class="sort-select" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ trans_db('website.New arrivals') }}</option>
                                <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>{{ trans_db('website.Best Seller') }}</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ trans_db('website.Price') }}: {{ trans_db('website.From') }} الأقل للأعلى</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ trans_db('website.Price') }}: {{ trans_db('website.From') }} الأعلى للأقل</option>
                            </select>
                        </div>
                    </div>

                    <div class="products-grid">
                        @forelse($products as $product)
                            <div class="v-card">
                                <!-- Status Indicators -->
                                <div class="v-status-indicators">
                                    @if(isset($cartProducts[$product->id]))
                                        <span class="v-status-dot cart-dot" title="{{ trans_db('website.In Cart') }}"><i class="fa-solid fa-check"></i></span>
                                    @endif
                                    @if(in_array($product->id, $wishlistIds))
                                        <span class="v-status-dot wish-dot" title="{{ trans_db('website.In Wishlist') }}"><i class="fa-solid fa-heart"></i></span>
                                    @endif
                                </div>

                                <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-img-link">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? 'Book' }}">
                                </a>
                                <div class="v-card-content">
                                    <a href="{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}" class="v-card-title">
                                        {{ $product->translation->name ?? trans_db('website.book') . ' غير معنون' }}
                                    </a>
                                    <div class="v-card-author">
                                        <i class="fa-solid fa-pen-nib"></i> 
                                        @if($product->brand)
                                            <a href="{{ route('frontend.products.index', ['brands[]' => $product->brand->id]) }}" class="text-reset text-decoration-none hover-primary">
                                                {{ $product->brand->translation->title ?? trans_db('website.Author') . ' ' . trans_db('website.Unknown') }}
                                            </a>
                                        @else
                                            {{ trans_db('website.Author') . ' ' . trans_db('website.Unknown') }}
                                        @endif
                                    </div>
                                    <div class="v-card-price-box">
                                        @if(request('flash_sale') && $product->flashSales->isNotEmpty())
                                            @php 
                                                $flashSalePrice = $product->flashSales->first()->pivot->price; 
                                                $originalPrice = $product->price;
                                                $discount = $originalPrice > 0 ? round((($originalPrice - $flashSalePrice) / $originalPrice) * 100) : 0;
                                            @endphp
                                            <span class="v-current-price">{{ format_price($flashSalePrice) }}</span>
                                            <span class="v-old-price">{{ format_price($originalPrice) }}</span>
                                            <span class="v-discount-badge">-{{ $discount }}%</span>
                                        @elseif($product->has_special_price)
                                            <span class="v-current-price">{{ format_price($product->special_price) }}</span>
                                            <span class="v-old-price">{{ format_price($product->price) }}</span>
                                            @php $discount = round((($product->price - $product->special_price) / $product->price) * 100); @endphp
                                            <span class="v-discount-badge">-{{ $discount }}%</span>
                                        @else
                                            <span class="v-current-price">{{ format_price($product->price) }}</span>
                                        @endif
                                    </div>
                                    @include('frontend.products.partials.rating_display', ['product' => $product])
                                </div>
                              
                                <div class="v-card-actions">
                                    @php $qtyInCart = $cartProducts[$product->id] ?? 0; @endphp
                                    
                                    @if($qtyInCart > 0)
                                        <div class="qty-control" data-id="{{ $product->id }}">
                                            <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                                            <span class="qty-display">{{ $qtyInCart }}</span>
                                            <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
                                        </div>
                                    @else
                                        <button class="v-add-btn" data-id="{{ $product->id }}" title="{{ trans_db('website.Add to Cart') }}">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    @endif

                                    <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" data-id="{{ $product->id }}" title="{{ trans_db('website.In Wishlist') }}">
                                        <i class="{{ in_array($product->id, $wishlistIds) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state premium-card w-100">
                                    <i class="fa-solid fa-book-open"></i>
                                    <h2>{{ trans_db('website.No matching results') }}</h2>
                                    <p>جرب تغيير خيارات التصفية أو كلمة البحث.</p>
                                    <a href="{{ route('frontend.products.index') }}" class="btn-shop-now">{{ trans_db('website.View') }} {{ trans_db('website.All') }} {{ trans_db('website.Books') }}</a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.btn-toggle-filters').on('click', function() {
            $('.filter-sidebar').toggleClass('active');
        });

        // Close filters when clicking outside on mobile
        $(document).click(function(event) {
            if (!$(event.target).closest('.filter-sidebar, .btn-toggle-filters').length) {
                $('.filter-sidebar').removeClass('active');
            }
        });

        // Initialize Category Ads Swiper
        if (document.querySelector('.category-ads-swiper')) {
            new Swiper('.category-ads-swiper', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.category-ads-swiper .swiper-pagination',
                    clickable: true,
                },
                slidesPerView: 1,
                spaceBetween: 10,
            });
        }
    });
</script>
@endsection
