@extends('frontend.layouts.master')

@push('js')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->translation->name }}",
  "image": [
    "{{ asset($product->image) }}"
    @foreach($product->images as $img)
    ,"{{ asset($img->image) }}"
    @endforeach
  ],
  "description": "{{ strip_tags($product->translation->description) }}",
  "sku": "{{ $product->sku ?? $product->id }}",
  "brand": {
    "@type": "Brand",
    "name": "{{ $product->brand->translation->title ?? 'Mushaf Home' }}"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "{{ session('currency_code', 'EGP') }}",
    "price": "{{ $product->special_price ?: $product->price }}",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/{{ $product->quantity > 0 || $product->ignore_quantity ? 'InStock' : 'OutOfStock' }}"
  }
}
</script>
@endpush

@section('title')
    {{ $product->translation->meta_title ?? $product->translation->name }}
@endsection

@section('meta_title')
    {{ $product->translation->meta_title ?? $product->translation->name }}
@endsection

@section('meta_description')
    {{ $product->translation->meta_description ?? strip_tags($product->translation->description) }}
@endsection

@section('meta_image')
    {{ asset($product->image) }}
@endsection

@push('css')
<style>
    /* Product Details Page Specific Styles */
    .product-page-container {
        padding-top: 50px;
        padding-bottom: 100px;
        background-color: #fcfcfc;
    }

    /* Breadcrumbs */
    .custom-breadcrumb {
        background-color: #fff;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 40px;
    }
    .custom-breadcrumb ul {
        display: flex;
        justify-content: center;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .custom-breadcrumb ul li a {
        color: #777;
        font-size: 14px;
        transition: 0.3s;
    }
    .custom-breadcrumb ul li a:hover {
        color: var(--main-color, #1cbcec);
    }
    .custom-breadcrumb ul li:last-child {
        color: #333;
        font-weight: 600;
        font-size: 14px;
    }
    .custom-breadcrumb ul li:not(:last-child)::after {
        content: "/";
        margin-right: 10px;
        color: #ccc;
    }

    /* Product Image Gallery */
    .product-gallery {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .main-image {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        border: 1px solid #f0f0f0;
    }
    .main-image img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s ease;
    }
    .main-image:hover img {
        transform: scale(1.05);
    }
    .thumbs-slider .swiper-slide {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        overflow: hidden;
    }
    .thumbs-slider .swiper-slide.swiper-slide-thumb-active {
        border-color: var(--main-color, #1cbcec);
    }
    .thumbs-slider img {
        width: 100%;
        display: block;
        border-radius: 3px;
    }

    /* Product Info */
    .product-info-wrapper {
        padding: 10px 20px;
    }
    .product-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    .product-meta-top {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #666;
    }
    .rating-wrap {
        color: #ffc107;
        display: flex;
        gap: 2px;
    }
    .reviews-count {
        color: #999;
        font-size: 13px;
    }
    .price-wrap {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .current-price {
        font-size: 32px;
        font-weight: 800;
        color: var(--main-color, #1cbcec);
    }
    .old-price {
        font-size: 20px;
        color: #999;
        text-decoration: line-through;
    }
    .stock-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 25px;
    }
    .in-stock {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    .out-stock {
        background-color: #ffebee;
        color: #c62828;
    }

    /* Quantity & Actions */
    .actions-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    .quantity-control {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        height: 50px;
    }
    .quantity-control button {
        width: 40px;
        border: none;
        background: #f8f8f8;
        font-weight: bold;
        color: #555;
        cursor: pointer;
        transition: 0.2s;
    }
    .quantity-control button:hover {
        background: #eee;
    }
    .quantity-control input {
        width: 60px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        outline: none;
    }
    .add-to-cart-btn {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 0 40px;
        height: 50px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .add-to-cart-btn:hover {
        background-color: var(--main-color, #1cbcec);
        transform: translateY(-2px);
    }
    .wishlist-btn {
        width: 50px;
        height: 50px;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #555;
        background: #fff;
        transition: 0.3s;
    }
    .wishlist-btn:hover, .wishlist-btn.active {
        border-color: var(--secondary-color, #d31c44);
        color: var(--secondary-color, #d31c44);
        background: #e74c3c;
    }

    /* Meta Info */
    .product-meta-list {
        list-style: none;
        padding: 20px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        margin: 0 0 25px 0;
    }
    .product-meta-list li {
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
        font-size: 15px;
    }
    .product-meta-list li span.label {
        font-weight: 600;
        color: #333;
        min-width: 120px;
    }
    .product-meta-list li a {
        color: #666;
        transition: 0.2s;
    }
    .product-meta-list li a:hover {
        color: var(--main-color, #1cbcec);
        text-decoration: underline;
    }

    /* Description */
    .product-description {
        color: #555;
        line-height: 1.8;
        font-size: 16px;
    }

    /* Related Products (Reuse Card Styles if possible or minimal fallback) */
    .related-section {
        margin-top: 80px;
    }
    .section-title {
        text-align: center;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #333;
    }
    
    /* Vibe Card (Mini recreate if missing) */
    .v-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: 0.3s;
        background: #fff;
    }
    .v-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .v-card img {
        width: 100%;
        height: auto;
    }
    .v-card-content {
        padding: 15px;
        text-align: center;
    }
    .badge-custom {
        display: inline-block;
        padding: 5px 12px;
        font-size: 13px;
        font-weight: 500;
        line-height: 1;
        color: #555;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 4px; /* Rounded corners */
        background-color: #f1f1f1; /* Light gray background */
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        text-decoration: none; /* Remove underline */
        margin-right: 5px; /* Spacing between badges */
        margin-bottom: 5px;
        text-decoration: none !important;
    }
    
    .badge-custom:hover {
        color: #fff !important;
        background-color: var(--main-color, #1cbcec); /* Main color on hover */
        text-decoration: none;
    }
    
    /* Star Rating Input */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        font-size: 25px;
        color: #ccc;
        cursor: pointer;
        padding: 0 5px;
        transition: color 0.2s;
    }
    .rating-input label:hover,
    .rating-input label:hover ~ label,
    .rating-input input:checked ~ label {
        color: #ffc107;
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('frontend.index') }}">{{ trans_db('frontend.home') }}</a></li>
                <li><a href="{{ route('frontend.products.index') }}">{{ trans_db('frontend.products') }}</a></li>
                <li>{{ $product->translation->name }}</li>
            </ul>
        </div>
    </div>

    <!-- Product Details Area -->
    <div class="product-page-container">
        <div class="container">
            <div class="row gy-5">
                <!-- Image Gallery (Left Side) -->
                <div class="col-lg-5">
                    <div class="product-gallery">
                        <div class="main-image">
                            @if($product->image)
                                <img id="zoom_image" src="{{ asset($product->image) }}" alt="{{ $product->translation->name }}"/>
                            @else
                                <img src="{{ asset('assets/images/product/no-image.jpg') }}" alt="No Image"/>
                            @endif
                        </div>
                        
                        <!-- Thumbnails Slider -->
                        <div class="thumbs-slider swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($product->images as $image)
                                    <div class="swiper-slide" onclick="changeImage('{{ asset($image->image) }}')">
                                        <div class="thumb-img-wrap">
                                            <img src="{{ asset($image->image) }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info (Right Side) -->
                <div class="col-lg-7">
                    <div class="product-info-wrapper">
                        <h1 class="product-title">{{ $product->translation->name }}</h1>
                        
                        <div class="product-meta-top">
                            @include('frontend.products.partials.rating_display', ['product' => $product])
                        </div>

                        <div class="price-wrap">
                           @if($product->special_price && $product->special_price_start <= now() && $product->special_price_end >= now())
                                <span class="current-price">{{ format_price($product->special_price) }}</span>
                                <span class="old-price">{{ format_price($product->price) }}</span>
                            @else
                                <span class="current-price">{{ format_price($product->price) }}</span>
                            @endif
                        </div>

                        <div class="stock-status {{ ($product->quantity > 0 || $product->ignore_quantity) ? 'in-stock' : 'out-stock' }}">
                            @if($product->quantity > 0 || $product->ignore_quantity)
                                <i class="fas fa-check-circle"></i> {{ trans_db('frontend.in_stock') }}
                            @else
                                <i class="fas fa-times-circle"></i> {{ trans_db('frontend.out_of_stock') }}
                            @endif
                        </div>

                        <div class="product-description">
                            <p>{!! $product->translation->description !!}</p>
                        </div>
                        
                        <!-- Dynamic Options -->
                        <ul class="product-meta-list">
                            <li>
                                <span class="label">{{ trans_db('frontend.categories') }}:</span> 
                                <div>
                                    @foreach($product->categories as $category)
                                        @php
                                            $catSlug = $category->translation->slug ?? $category->translations->first()->slug ?? null;
                                        @endphp
                                        <a href="{{ $catSlug ? route('frontend.products.category', $catSlug) : '#' }}" class="badge-custom">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                            @if($product->brand)
                            <li>
                                <span class="label">{{ trans_db('frontend.brand') }}:</span> 
                                <a href="{{ route('frontend.products.index', ['brands' => [$product->brand->id]]) }}" class="badge-custom">{{ $product->brand->name }}</a>
                            </li>
                            @endif

                            @foreach($product->productOptions as $productOption)
                                <li>
                                    <span class="label">{{ $productOption->option->translation->name ?? '' }}:</span> 
                                    <div>
                                    @foreach($productOption->values as $value)
                                        {{ $value->optionValue->translation->value ?? '' }}@if(!$loop->last), @endif
                                    @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        <!-- Rating Form & Reviews -->
                        @if($Setting->show_ratings)
                        <div class="rating-section mt-4 mb-4" style="border-top: 1px solid #eee; padding-top: 20px;">
                            <h5>{{ trans_db('frontend.Ratings & Reviews') }}</h5>
                            
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                           @if($Setting->enable_reviews)
                               @auth
                                    <form action="{{ route('frontend.products.rate') }}" method="POST" class="mb-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="form-group mb-2">
                                            <label>{{ trans_db('frontend.Your Rating') }}</label>
                                            <div class="rating-input">
                                                <input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label>{{ trans_db('frontend.Your Review') }}</label>
                                            <textarea name="comment" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm" style="background-color: var(--main-color, #1cbcec); border:none;">{{ trans_db('frontend.Submit Review') }}</button>
                                    </form>
                                @else
                                    <div class="my-3">
                                        <a href="{{ route('frontend.login') }}" class="btn btn-primary" style="background-color: var(--main-color, #1cbcec); border-color: var(--main-color, #1cbcec); color: #fff; padding: 10px 30px; border-radius: 5px; text-decoration: none;">
                                            <i class="fas fa-sign-in-alt"></i> {{ trans_db('frontend.Login to write a review') }}
                                        </a>
                                    </div>
                                @endauth
                            @endif

                            <div class="reviews-list" id="reviews-container">
                                @if($product->ratings->count() > 0)
                                    @include('frontend.products.partials.reviews_list', ['ratings' => $product->ratings()->where('status', 1)->latest()->take(5)->get()])
                                @else
                                    <p class="text-muted text-center">{{ trans_db('frontend.No reviews yet') }}</p>
                                @endif
                            </div>

                            @if($product->ratings()->where('status', 1)->count() > 5)
                                <div class="text-center mt-3">
                                    <button class="btn btn-secondary btn-sm" id="load-more-reviews" onclick="loadMoreReviews({{ $product->id }})">
                                        {{ trans_db('frontend.Load More') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                        @endif

                            <!-- Actions -->
                        <div class="actions-wrapper">
                            @if(isset($cartProducts[$product->id]))
                                <div class="quantity-control">
                                    <button type="button" onclick="decreaseQty()">-</button>
                                    <input type="text" name="qtybutton" id="qtyInput" value="{{ $cartProducts[$product->id] }}" readonly>
                                    <button type="button" onclick="increaseQty()">+</button>
                                </div>
                                <button class="add-to-cart-btn" style="background-color: var(--main-color, #1cbcec);" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-check"></i> {{ trans_db('frontend.in_cart') ?? 'In Cart' }}
                                </button>
                            @else
                                <div class="quantity-control">
                                    <button type="button" onclick="decreaseQty()">-</button>
                                    <input type="text" name="qtybutton" id="qtyInput" value="1" readonly>
                                    <button type="button" onclick="increaseQty()">+</button>
                                </div>
                                <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-shopping-cart"></i> {{ trans_db('frontend.add_to_cart') }}
                                </button>
                            @endif

                            <button class="wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" onclick="toggleWishlist({{ $product->id }})">
                                <i class="{{ in_array($product->id, $wishlistIds) ? 'fas' : 'far' }} fa-heart" style="color: #fff !important;"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
     @if($relatedProducts->count() > 0)
    <div class="related-section">
        <div class="container">
            <h2 class="section-title">{{ trans_db('frontend.related_products') }}</h2>
            <div class="row">
                @foreach($relatedProducts as $relProduct)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="v-card"> <!-- Reusing existing card class if available, or using fallback style -->
                            <div class="product-img">
                                <a href="{{ route('products.show', ['id' => $relProduct->id, 'slug' => $relProduct->translation->slug]) }}">
                                    @if($relProduct->images->count() > 0)
                                    <img src="{{ asset($relProduct->images->first()->image) }}" alt="">
                                    @else
                                    <img src="{{ asset('assets/images/product/no-image.jpg') }}" alt="">
                                    @endif
                                </a>
                            </div>
                            <div class="v-card-content">
                                <h3><a href="{{ route('products.show', ['id' => $relProduct->id, 'slug' => $relProduct->translation->slug]) }}">{{ $relProduct->translation->name }}</a></h3>
                                <div class="product-price">
                                    <span style="font-weight:bold; color:var(--main-color, #1cbcec);">{{ format_price($relProduct->price) }}</span>
                                </div>
                                @include('frontend.products.partials.rating_display', ['product' => $relProduct])
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


    <script>
        function changeImage(src) {
            document.getElementById('zoom_image').src = src;
        }

        function increaseQty() {
            var value = parseInt(document.getElementById('qtyInput').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('qtyInput').value = value;
        }

        function decreaseQty() {
            var value = parseInt(document.getElementById('qtyInput').value, 10);
            value = isNaN(value) ? 0 : value;
            value < 1 ? value = 1 : '';
            value--;
            document.getElementById('qtyInput').value = value;
        }

        function addToCart(productId) {
             var quantity = document.getElementById('qtyInput').value;
             var btn = $('.add-to-cart-btn');
             
             $.ajax({
                url: "{{ route('frontend.cart.add') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    quantity: quantity
                },
                success: function (response) {
                    // Update Button State
                    btn.html('<i class="fas fa-check"></i> {{ trans_db("frontend.in_cart") ?? "In Cart" }}');
                    btn.css('background-color', 'var(--main-color, #1cbcec)');
                    
                    // Update Header Cart Count
                    if(response.cart_count !== undefined) {
                        $('.elegant-badge.cart-count').text(response.cart_count);
                    }
                    
                    // Show success message
                    // alert('Added to Cart'); 
                },
                error: function (response) {
                    alert('Error adding to cart');
                }
            });
        }

        function toggleWishlist(productId) {
             var btn = $('.wishlist-btn');
             var icon = btn.find('i');
             
             $.ajax({
                url: "{{ route('frontend.wishlist.toggle') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function (response) {
                    // Toggle Active Class
                    btn.toggleClass('active');
                    
                    // Toggle Icon
                    if(btn.hasClass('active')) {
                        icon.removeClass('far').addClass('fas');
                    } else {
                        icon.removeClass('fas').addClass('far');
                    }
                    
                    // Update Header Wishlist Count
                    if(response.wishlist_count !== undefined) {
                        $('.elegant-badge.wishlist-count').text(response.wishlist_count);
                    }
                    
                    // alert('Wishlist toggled');
                },
                error: function (response) {
                    alert('Error updating wishlist');
                }
            });
        }

        var reviewsSkip = 5;
        function loadMoreReviews(id) {
            var btn = $('#load-more-reviews');
            btn.prop('disabled', true).text('{{ trans_db("frontend.Loading...") }}');
            
            $.ajax({
                url: "{{ route('frontend.products.reviews.more') }}",
                method: "GET",
                data: {
                    product_id: id,
                    skip: reviewsSkip
                },
                success: function(response) {
                    if(response.html) {
                        $('#reviews-container').append(response.html);
                        reviewsSkip += 5;
                        
                        if (reviewsSkip >= {{ $product->ratings->where('status', 1)->count() }}) {
                            btn.hide();
                        } else {
                            btn.prop('disabled', false).text('{{ trans_db("frontend.Load More") }}');
                        }
                    } else {
                        btn.hide();
                    }
                },
                error: function() {
                    btn.prop('disabled', false).text('{{ trans_db("frontend.Load More") }}');
                    alert('Failed to load reviews');
                }
            });
        }
    </script>
@endsection
