@extends('frontend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/cart_wishlist.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/home_sections.css') }}">
@endpush

@section('content')
<div class="wishlist-page">
    <div class="premium-page-header">
        <div class="container">
            <h1>{{ trans_db('website.Favorite') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans_db('website.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans_db('website.Favorite') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="cart-wishlist-container">
        @if($wishlistItems->count() > 0)
        <div class="premium-card">
            <div class="items-list">
                @foreach($wishlistItems as $item)
                <div class="item-row" data-id="{{ $item->product_id }}">
                    <div class="item-image">
                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->translation->name ?? 'Product' }}">
                    </div>
                    <div class="item-details">
                        <a href="{{ url('ar/product/' . $item->product_id . '/' . ($item->product->translation->slug ?? '')) }}" class="item-title">
                            {{ $item->product->translation->name ?? trans_db('website.Untitled product') }}
                        </a>
                        <div class="item-meta">
                            <span>{{ trans_db('website.Brand:') }} {{ $item->product->brand->translation->title ?? trans_db('website.Unknown') }}</span>
                            @include('frontend.products.partials.rating_display', ['product' => $item->product])
                        </div>
                    </div>
                    <div class="item-price-col">
                        <div class="item-price">
                            @php
                                [$flashPrice, $flashId, $validFrom, $validTo, $flashName] = \App\Services\OrderService::getFlashSaleValue($item->product_id);
                                $finalPrice = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                            @endphp
                            {{ format_price($finalPrice) }}
                            @if($flashPrice > 0)
                                <div style="margin-top: 4px;">
                                    <span class="badge badge-danger" style="font-size: 11px; background-color: #e74c3c; padding: 5px 8px;">
                                        <i class="fa-solid fa-bolt"></i> عرض فلاش
                                        @if($flashName)
                                            <span style="font-size: 9px; opacity: 0.9; margin-right: 3px;">({{ $flashName }})</span>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="item-qty-col">
                         @if(isset($cartProducts[$item->product_id]))
                             <div class="text-success font-weight-bold" style="font-size: 9px;">
                                 <i class="fa-solid fa-check"></i> {{ trans_db('website.Added to Cart') }} <a href="{{ route('frontend.cart.index') }}" style="font-size: 11px; text-decoration: underline;">({{ trans_db('website.View Cart') }})</a>
                             </div>
                         @else
                             <button class="btn-shop-now v-add-btn" data-id="{{ $item->product_id }}" style="padding: 10px 20px; width: auto; border-radius: 8px;">
                                 {{ trans_db('website.Add to Cart') }}
                             </button>
                         @endif
                    </div>
                    <div class="item-remove-col">
                        <button class="btn-remove v-wishlist-btn active" data-id="{{ $item->product_id }}" title="حذف من {{ trans_db('website.Favorite') }}">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="empty-state premium-card">
            <i class="fa-regular fa-heart"></i>
            <h2>قائمة {{ trans_db('website.Favorite') }} فارغة</h2>
            <p>{{ trans_db('website.empty_wishlist_msg') }}</p>
            <a href="{{ url('/') }}" class="btn-shop-now">{{ trans_db('website.Discover Products') }}</a>
        </div>
        @endif
    </div>
</div>
@endsection
