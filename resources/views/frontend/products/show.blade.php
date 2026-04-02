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
        padding-top: 40px;
        padding-bottom: 80px;
        background-color: #f8f9fa;
    }

    /* Breadcrumbs */
    .custom-breadcrumb {
        background-color: #fff;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    .custom-breadcrumb ul {
        display: flex;
        justify-content: flex-start;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .custom-breadcrumb ul li a {
        color: #888;
        font-size: 13px;
        transition: 0.3s;
        text-decoration: none;
    }
    .custom-breadcrumb ul li a:hover {
        color: var(--main-color, #1cbcec);
    }
    .custom-breadcrumb ul li:last-child {
        color: #333;
        font-weight: 600;
        font-size: 13px;
    }
    .custom-breadcrumb ul li:not(:last-child)::after {
        content: "/";
        margin-right: 10px;
        color: #ccc;
    }

    /* Product Image Gallery - PRO Version */
    .product-gallery {
        position: sticky;
        top: 100px;
    }
    .gallery-main-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #f0f0f0;
        margin-bottom: 15px;
        position: relative;
    }
    .main-image-wrapper {
        width: 100%;
        height: 500px; /* FIXED HEIGHT */
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        padding: 20px;
    }
    .main-image-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* CRITICAL: Prevent distortion and overflow */
        transition: opacity 0.4s ease, transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .main-image-wrapper:hover img {
        transform: scale(1.05);
    }

    /* Thumbnails - Professional Grid/Slider */
    .thumbs-slider {
        margin-top: 15px;
    }
    .thumbs-wrapper {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
        scrollbar-width: thin;
    }
    .thumb-item {
        flex: 0 0 80px;
        height: 80px;
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: 0.3s;
        background: #fff;
        padding: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .thumb-item:hover, .thumb-item.active {
        border-color: var(--main-color, #1cbcec);
        box-shadow: 0 5px 15px rgba(28, 188, 236, 0.2);
    }

    /* Product Info Card */
    .product-info-card {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        height: 100%;
    }
    .product-title {
        font-size: 32px;
        font-weight: 800;
        color: #222;
        margin-bottom: 20px;
        line-height: 1.2;
    }
    .price-container {
        display: flex;
        align-items: baseline;
        gap: 15px;
        margin-bottom: 25px;
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 8px;
        width: fit-content;
    }
    .current-price {
        font-size: 30px;
        font-weight: 900;
        color: var(--main-color, #1cbcec);
    }
    .old-price {
        font-size: 18px;
        color: #adb5bd;
        text-decoration: line-through;
    }
    .badge-stock {
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-in-stock { background: #e6fcf5; color: #0ca678; }
    .badge-out-stock { background: #fff5f5; color: #fa5252; }

    /* Action Buttons */
    .qty-selector {
        display: flex;
        align-items: center;
        background: #f1f3f5;
        border-radius: 8px;
        overflow: hidden;
        margin-right: 15px;
    }
    .qty-btn {
        width: 45px;
        height: 45px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
        transition: 0.2s;
    }
    .qty-btn:hover { background: #e9ecef; }
    .input-qty {
        width: 50px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
    }

    .btn-buy-now {
        flex: 1;
        height: 50px;
        background: var(--main-color, #1cbcec);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(28, 188, 236, 0.3);
    }
    .btn-buy-now:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(28, 188, 236, 0.4);
        background: #15a9d6;
    }

    /* Meta Specs */
    .product-specs {
        margin-top: 30px;
        border-top: 1px solid #eee;
        padding-top: 25px;
    }
    .spec-item {
        display: flex;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .spec-label {
        width: 120px;
        font-weight: 700;
        color: #495057;
    }
    .spec-value {
        color: #868e96;
        flex: 1;
    }

    /* Description Content Fix */
    .description-box {
        margin-top: 20px;
        color: #495057;
        line-height: 1.8;
    }
    .description-box h2, .description-box h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #222;
    }

    /* Related Products Grid - Professional Fix */
    .v-card {
        border: none;
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: 0.3s;
        height: 100%;
    }
    .v-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .v-card .product-img {
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        padding: 15px;
    }
    .v-card .product-img img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .v-card-content {
        padding: 20px;
        text-align: center;
    }
    .v-card-content h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
    }
    .v-card-content h3 a {
        color: #222;
        text-decoration: none;
    }

    @media (max-width: 991px) {
        .product-gallery { position: static; margin-bottom: 30px; }
        .main-image-wrapper { height: 400px; }
    }
</style>
<style>
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
            <div class="row">
                <!-- Image Gallery (Left Side) -->
                <div class="col-lg-5">
                    <div class="product-gallery">
                        <div class="gallery-main-container">
                            <div class="main-image-wrapper">
                                @if($product->image)
                                    <img id="zoom_image" src="{{ asset($product->image) }}" alt="{{ $product->translation->name }}"/>
                                @else
                                    <img src="{{ asset('assets/images/product/no-image.jpg') }}" alt="No Image"/>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Thumbnails slider (Native Scroll) -->
                        <div class="thumbs-wrapper">
                            @if($product->image)
                                <div class="thumb-item active" onclick="changeImage('{{ asset($product->image) }}', this)">
                                    <img src="{{ asset($product->image) }}" alt="">
                                </div>
                            @endif
                            @foreach($product->images as $image)
                                <div class="thumb-item" onclick="changeImage('{{ asset($image->image) }}', this)">
                                    <img src="{{ asset($image->image) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Info (Right Side) -->
                <div class="col-lg-7">
                    <div class="product-info-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h1 class="product-title">{{ $product->translation->name }}</h1>
                            <button class="wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" onclick="toggleWishlist({{ $product->id }})" style="border:none; box-shadow:none;">
                                <i class="{{ in_array($product->id, $wishlistIds) ? 'fas' : 'far' }} fa-heart" style="color: #666;"></i>
                            </button>
                        </div>
                        
                        <div class="product-meta-top border-bottom pb-2">
                            @include('frontend.products.partials.rating_display', ['product' => $product])
                        </div>

                        <div class="price-container mt-3">
                           @if($product->special_price && $product->special_price_start <= now() && $product->special_price_end >= now())
                                <span class="current-price">{{ format_price($product->special_price) }}</span>
                                <span class="old-price">{{ format_price($product->price) }}</span>
                            @else
                                <span class="current-price">{{ format_price($product->price) }}</span>
                            @endif
                            
                            <span class="badge-stock {{ ($product->quantity > 0 || $product->ignore_quantity) ? 'badge-in-stock' : 'badge-out-stock' }} ml-3">
                                {{ ($product->quantity > 0 || $product->ignore_quantity) ? trans_db('frontend.in_stock') : trans_db('frontend.out_of_stock') }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="actions-wrapper d-flex align-items-center mt-4">
                            <div class="qty-selector">
                                <button type="button" class="qty-btn" onclick="decreaseQty()">-</button>
                                <input type="text" class="input-qty" name="qtybutton" id="qtyInput" value="1" readonly>
                                <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                            </div>
                            
                            <button class="btn-buy-now" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-basket"></i>
                                <span>{{ isset($cartProducts[$product->id]) ? (trans_db('frontend.in_cart') ?? 'In Cart') : trans_db('frontend.add_to_cart') }}</span>
                            </button>
                        </div>

                        <div class="description-box mt-4 border-top pt-3">
                            <h5 class="text-primary mb-2">{{ trans_db('frontend.description') }}</h5>
                            <div class="product-description">
                                {!! $product->translation->description !!}
                            </div>
                        </div>
                        
                        <!-- Specs -->
                        <div class="product-specs mt-4">
                            <div class="spec-item">
                                <span class="spec-label">{{ trans_db('frontend.brand') }}:</span>
                                <span class="spec-value">{{ $product->brand->name ?? '-' }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">{{ trans_db('frontend.categories') }}:</span>
                                <div class="spec-value">
                                    @foreach($product->categories as $category)
                                        <span class="badge-custom mr-1">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @foreach($product->productOptions as $productOption)
                                <div class="spec-item">
                                    <span class="spec-label">{{ $productOption->option->name ?? '' }}:</span> 
                                    <div class="spec-value">
                                        @foreach($productOption->values as $value)
                                            {{ $value->optionValue->value ?? '' }}@if(!$loop->last), @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
     @if($relatedProducts->count() > 0)
    <div class="related-section pb-5">
        <div class="container">
            <h2 class="section-title">{{ trans_db('frontend.related_products') }}</h2>
            <div class="row">
                @foreach($relatedProducts as $relProduct)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="v-card">
                            <div class="product-img">
                                <a href="{{ route('frontend.products.show', ['id' => $relProduct->id, 'slug' => $relProduct->translation->slug ?? 'product']) }}">
                                    @if($relProduct->image)
                                        <img src="{{ asset($relProduct->image) }}" alt="{{ $relProduct->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/product/no-image.jpg') }}" alt="">
                                    @endif
                                </a>
                            </div>
                            <div class="v-card-content">
                                <h3><a href="{{ route('frontend.products.show', ['id' => $relProduct->id, 'slug' => $relProduct->translation->slug ?? 'product']) }}">{{ $relProduct->name }}</a></h3>
                                <div class="product-price mb-2">
                                    <span style="font-weight:900; font-size: 1.2rem; color:var(--main-color, #1cbcec);">{{ format_price($relProduct->price) }}</span>
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
        var currentThumbIndex = 0;
        var thumbItems;
        var autoChangeInterval;

        function changeImage(src, element) {
            var mainImage = document.getElementById('zoom_image');
            if (!mainImage) return;

            // Fade out
            mainImage.style.opacity = '0.4';
            
            setTimeout(function() {
                mainImage.src = src;
                
                mainImage.onload = function() {
                    mainImage.style.opacity = '1';
                };
                
                if (!thumbItems) thumbItems = document.querySelectorAll('.thumb-item');
                
                // Update active state on thumbnails
                thumbItems.forEach((item, index) => {
                    item.classList.remove('active');
                    if (item === element) {
                        currentThumbIndex = index;
                    }
                });
                
                if(element) {
                    element.classList.add('active');
                    // Smoothly scroll the thumbnail into view
                    element.parentElement.scrollTo({
                        left: element.offsetLeft - (element.parentElement.offsetWidth / 2) + (element.offsetWidth / 2),
                        behavior: 'smooth'
                    });
                }
            }, 150);
        }

        function startAutoChange() {
            if (!thumbItems) thumbItems = document.querySelectorAll('.thumb-item');
            if (thumbItems.length <= 1) return;
            
            clearInterval(autoChangeInterval);
            autoChangeInterval = setInterval(function() {
                currentThumbIndex++;
                if (currentThumbIndex >= thumbItems.length) {
                    currentThumbIndex = 0;
                }
                
                var nextThumb = thumbItems[currentThumbIndex];
                if (nextThumb) {
                    var nextImg = nextThumb.querySelector('img');
                    if (nextImg) {
                        changeImage(nextImg.src, nextThumb);
                    }
                }
            }, 4000); // Change every 4 seconds
        }

        function stopAutoChange() {
            clearInterval(autoChangeInterval);
        }

        // Initialize auto-change
        document.addEventListener('DOMContentLoaded', function() {
            startAutoChange();
            
            // Pause on hover
            const gallery = document.querySelector('.product-gallery');
            if (gallery) {
                gallery.addEventListener('mouseenter', stopAutoChange);
                gallery.addEventListener('mouseleave', startAutoChange);
            }
        });

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
