@extends('frontend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/cart_wishlist.css') }}">
@endpush

@section('content')
<div class="cart-page">
    <div class="premium-page-header">
        <div class="container">
            <h1>سلة المشتريات</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans_db('website.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">السلة</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="cart-wishlist-container">
        @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="premium-card">
                    <div class="items-list">
                        @foreach($cartItems as $item)
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
                                <div class="qty-control" data-id="{{ $item->product_id }}">
                                    <button class="qty-btn plus" data-id="{{ $item->product_id }}">+</button>
                                    <span class="qty-display">{{ $item->quantity }}</span>
                                    <button class="qty-btn minus" data-id="{{ $item->product_id }}">-</button>
                                </div>
                            </div>
                            <div class="item-remove-col">
                                <button class="btn-remove remove-from-cart" data-id="{{ $item->product_id }}" title="حذف من السلة">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="premium-card cart-summary">
                    <h3 class="summary-title">ملخص الطلب</h3>
                    <div class="summary-row">
                        <span>إجمالي المنتجات</span>
                        <span class="subtotal-display">{{ format_price($total) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>الشحن</span>
                        <span>يحدد لاحقاً</span>
                    </div>
                    <div class="summary-row total">
                        <span>الإجمالي</span>
                        <span class="total-display">{{ format_price($total) }}</span>
                    </div>
                    
                    <a href="{{ route('frontend.user.checkout.index') }}" class="btn-checkout">اتمام الطلب</a>
                </div>
            </div>
        </div>
        @else
        <div class="empty-state premium-card">
            <i class="fa-solid fa-cart-shopping"></i>
            <h2>سلة المشتريات فارغة</h2>
            <p>يبدو أنك لم تضف أي منتجات {{ trans_db('website.To') }} سلتك بعد.</p>
            <a href="{{ url('/') }}" class="btn-shop-now">تسوق الآن</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // We reuse the logic from scripts.blade.php but add more UI updates for this page
        // The plus/minus logic is already handled by delegation in master scripts.
        // We just need to update the subtotals/totals here on success.
        
        // Listen for successful cart updates (from master script responses or local ones)
        // Since we already have delegated listeners in master, we can either tap into them 
        // OR add more specific ones here if we want to update the total display.
        
        // Let's add specific listeners for this page to update the right-side summary.
        $(document).on('click', '.qty-btn', function() {
            // After change, we might want to refresh total via AJAX or just calculated it
            // For now, let's just refresh page if quantity reaches 0 or just update dynamically.
            // A better way is to return the new total in the JSON response of CartController.
        });
    });
</script>
@endpush
