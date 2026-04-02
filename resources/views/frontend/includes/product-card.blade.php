@props(['product'])

@php
    $wishlistIds = $wishlistIds ?? [];
    $cartProducts = $cartProducts ?? [];
    $productName = $product->translation->name ?? $product->name ?? 'Product';
    $productSlug = $product->translation->slug ?? $product->slug ?? '';
    // Ensure we have a valid route parameter
    $routeParams = ['id' => $product->id, 'slug' => $productSlug ?: 'product']; 
@endphp

<div class="v-card">
    <!-- Status Indicators (Always visible) -->
    <div class="v-status-indicators">
        @if(isset($cartProducts[$product->id]))
            <span class="v-status-dot cart-dot" title="{{ trans_db('frontend.In Cart') }}"><i class="fa-solid fa-check"></i></span>
        @endif
        @if(in_array($product->id, $wishlistIds))
            <span class="v-status-dot wish-dot" title="{{ trans_db('frontend.In Wishlist') }}"><i class="fa-solid fa-heart"></i></span>
        @endif
        
        @if($product->is_gift)
            <span class="v-status-dot gift-dot" title="{{ trans_db('frontend.Gift') }}" style="background-color: #f39c12; color: white;">
                <i class="fa-solid fa-gift"></i>
            </span>
        @endif
    </div>

    <a href="{{ route('frontend.products.show', $routeParams) }}" class="v-card-img-link">
        <img src="{{ asset($product->image) }}" alt="{{ $productName }}" onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
        @if($product->has_special_price)
            <span class="v-discount-badge-overlay">{{ round((($product->price - $product->special_price) / $product->price) * 100) }}% {{ trans_db('frontend.OFF') }}</span>
        @endif
    </a>

    <div class="v-card-content">
        <a href="{{ route('frontend.products.show', $routeParams) }}" class="v-card-title" title="{{ $productName }}">
            {{ $productName }}
        </a>
        
        @if($product->brand)
        <div class="v-card-author">
            <i class="fa-solid fa-pen-nib" style="color: #95a5a6; font-size: 11px;"></i> {{ $brandName = $product->brand->translation->title ?? $product->brand->name ?? '' }}
        </div>
        @endif

        <div class="v-card-price-box">
            @if($product->has_special_price)
                <span class="v-current-price">{{ format_price($product->special_price) }}</span>
                <span class="v-old-price">{{ format_price($product->price) }}</span>
            @else
                <span class="v-current-price">{{ format_price($product->price) }}</span>
            @endif
        </div>
        
        @include('frontend.products.partials.rating_display', ['product' => $product])
    </div>

    <div class="v-card-actions">
        <button class="v-wishlist-btn {{ in_array($product->id, $wishlistIds) ? 'active' : '' }}" 
                data-id="{{ $product->id }}" title="{{ trans_db('frontend.Add to Wishlist') }}">
            <i class="{{ in_array($product->id, $wishlistIds) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
        </button>
        
        @if(isset($cartProducts[$product->id]))
            <div class="qty-control" data-id="{{ $product->id }}">
                <button class="qty-btn plus" data-id="{{ $product->id }}">+</button>
                <span class="qty-display">{{ $cartProducts[$product->id] }}</span>
                <button class="qty-btn minus" data-id="{{ $product->id }}">-</button>
            </div>
        @else
            <button class="v-add-btn" data-id="{{ $product->id }}" title="{{ trans_db('frontend.Add to Cart') }}">
                <i class="fa-solid fa-cart-plus"></i>
            </button>
        @endif
    </div>
</div>
