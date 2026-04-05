@extends('frontend.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/cart_wishlist.css') }}">
    <style>
        :root {
            --main-color: #1c4dac;
            --main-color-rgb: 30, 86, 49;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --bg-light: #f8fafc;
        }
        
        .checkout-page {
            padding-bottom: 80px;
            background: var(--bg-light);
            min-height: 100vh;
            font-family: 'Cairo', sans-serif; /* Ensure font consistency */
        }
        
        .premium-page-header {
            background: linear-gradient(135deg, #1c4dac 0%, #4C825D 100%);
            padding: 60px 0 100px;
            color: white;
            margin-bottom: 0;
            position: relative;
        }
        
        .premium-page-header h1 {
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .premium-page-header .breadcrumb {
            background: transparent;
            padding: 0;
        }
        
        .premium-page-header .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .premium-page-header .breadcrumb-item.active {
            color: white;
        }

        .checkout-grid {
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .premium-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .checkout-section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-dark);
        }
        
        .checkout-section-title i {
            color: var(--main-color);
            background: rgba(var(--main-color-rgb), 0.1);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1rem;
        }

        /* Address Cards */
        .address-list {
            display: grid;
            gap: 15px;
        }

        .address-card {
            border: 2px solid #edf2f7;
            border-radius: 12px;
         padding: 16px 50px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: white;
        }
        
        .address-card:hover {
            border-color: var(--main-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(var(--main-color-rgb), 0.1);
        }
        
        .address-card.selected {
            border-color: var(--main-color);
            background: rgba(var(--main-color-rgb), 0.03);
        }
        
        .address-card .check-icon {
            position: absolute;
            top: 20px;
            left: 20px; /* RTL aware later */
            color: var(--main-color);
            font-size: 1.2rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s ease;
        }
        
        html[dir="rtl"] .address-card .check-icon {
            left: auto;
            right: 20px;
        }

        .address-card.selected .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        .address-card strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .address-card p {
            color: var(--text-gray);
            font-size: 0.95rem;
        }

        /* Payment Methods Grid */
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .payment-method-item {
            width: 100%; /* Default mobile width */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 25px 15px;
            border: 2px solid #edf2f7;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        @media (min-width: 992px) {
            .payment-method-item {
                width: calc(33.333% - 10px); /* 3 items per row (2 gaps of 15px = 30px / 3 = 10px) */
            }
            
            .payment-method-item:nth-child(1),
            .payment-method-item:nth-child(2) {
                width: calc(50% - 7.5px); /* 2 items per row (1 gap of 15px / 2 = 7.5px) */
            }
        }

        .payment-method-item:hover {
            border-color: var(--main-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .payment-method-item.selected {
            border-color: var(--main-color);
            background: rgba(var(--main-color-rgb), 0.05);
            box-shadow: 0 0 0 1px var(--main-color);
        }

        .payment-method-item i {
            font-size: 2.5rem;
            margin-bottom: 5px;
            transition: transform 0.3s ease;
        }

        .payment-method-item:hover i {
            transform: scale(1.1);
        }

        .payment-method-item strong {
            display: block;
            color: var(--text-dark);
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .payment-method-item p {
            color: var(--text-gray);
            font-size: 0.8rem;
            line-height: 1.4;
        }

        /* Order Summary */
        .order-summary-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px dashed #edf2f7;
        }
        
        .order-summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #edf2f7;
        }
        
        .summary-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .summary-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 5px;
            line-height: 1.4;
        }
        
        .summary-meta {
            font-size: 0.9rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        .summary-details-box {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: var(--text-gray);
            font-size: 0.95rem;
        }
        
        .summary-row strong {
            color: var(--text-dark);
        }

        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
            margin-bottom: 0;
            font-size: 1.2rem;
        }
        
        .summary-row.total .value {
            color: var(--main-color);
            font-weight: 800;
        }

        .coupon-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
        }

        .coupon-input-group {
            display: flex;
            gap: 10px;
        }

        .coupon-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .coupon-input:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 3px rgba(var(--main-color-rgb), 0.1);
        }

        .btn-apply-coupon {
            padding: 10px 20px;
            background: var(--text-dark);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-apply-coupon:hover {
            background: #000;
        }

        .applied-coupon {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(var(--main-color-rgb), 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .applied-coupon span {
            color: var(--main-color);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .btn-remove-coupon {
            color: #ef4444;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-place-order {
            width: 100%;
            background: linear-gradient(135deg, #1c4dac 0%, #4C825D 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 86, 49, 0.3);
            cursor: pointer;
        }
        .btn-place-order:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 86, 49, 0.4);
            filter: brightness(1.05);
        }

        .sticky-top {
            top: 100px;
            z-index: 5;
        }
    </style>
@endpush

@section('content')
<div class="checkout-page">
    <div class="premium-page-header">
        <div class="container">
            <h1>{{ trans_db('frontend.Checkout') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans_db('frontend.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.cart.index') }}">{{ trans_db('frontend.Cart') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans_db('frontend.Checkout') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container checkout-grid">
        <form action="{{ route('frontend.user.checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <!-- Shipping Address Section -->
                    <div class="premium-card mb-4">
                        <h2 class="checkout-section-title">
                            <i class="fa-solid fa-location-dot"></i> {{ trans_db('frontend.Shipping Address') }}
                        </h2>
                        
                        <div class="address-list">
                            @forelse($addresses as $address)
                            <div class="address-card {{ $loop->first ? 'selected' : '' }}" onclick="selectAddress({{ $address->id }}, this)">
                                <i class="fa-solid fa-circle-check check-icon"></i>
                                <strong>{{ $address->name }}</strong>
                                <p class="mb-1">{{ $address->phone }}</p>
                                <p class="mb-0">{{ $address->address }}, {{ $address->governorate_rel->name ?? '' }}, {{ $address->city_rel->name ?? '' }}</p>
                                <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }} class="d-none">
                            </div>
                            @empty
                            <div class="alert alert-warning">
                                {{ trans_db('frontend.No addresses found') }}. <a href="{{ route('frontend.user.home') }}">{{ trans_db('frontend.Add New Address') }}</a>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Order Services Section -->
                    @if($orderServices->count() > 0)
                    <div class="premium-card mb-4">
                        <h2 class="checkout-section-title">
                            <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.Order Services') }}
                        </h2>
                        
                        <div class="services-list">
                            @foreach($orderServices as $service)
                            <div class="service-item d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                                <div class="form-check">
                                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}" data-price="{{ $service->price }}" onchange="updateTotal()">
                                    <label class="form-check-label ms-2" for="service_{{ $service->id }}">
                                        <strong>{{ $service->name }}</strong>
                                        @if(app()->getLocale() == 'ar')
                                            ({{ $service->name_ar }})
                                        @endif
                                        <p class="mb-0 text-muted small">{{ format_price($service->price) }}</p>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Payment Method Section -->
                    <div class="premium-card mb-4">
                        <h2 class="checkout-section-title">
                            <i class="fa-solid fa-credit-card"></i> {{ trans_db('frontend.Payment Method') }}
                        </h2>
                        
                        <div class="payment-methods">
                            @forelse($paymentMethods as $method)
                                @php
                                    $isCash = $method->keyword == 'cash' || $method->keyword == 'cod';
                                    $isOverLimit = $isCash && $method->cod_limit && $subtotal > $method->cod_limit;
                                    $disabled = $isOverLimit;
                                @endphp
                            <label class="payment-method-item {{ ($loop->first && !$disabled) ? 'selected' : '' }} {{ $disabled ? 'disabled-method' : '' }}" >
                                <input type="radio" name="payment_method" value="{{ $method->id }}" 
                                    data-discount="{{ $method->discount }}" 
                                    data-discount-type="{{ $method->discount_type }}"
                                    {{ ($loop->first && !$disabled) ? 'checked' : '' }} class="d-none" onchange="selectPayment(this)" {{ $disabled ? 'disabled' : '' }}>
                                @if($method->image)
                                    <img src="{{ asset($method->image) }}" alt="{{ $method->name }}" style="height: 40px; margin-bottom: 5px; {{ $disabled ? 'filter: grayscale(100%);' : '' }}">
                                @else
                                    <i class="fa-solid fa-credit-card fa-2x text-primary" style="{{ $disabled ? 'color: #6c757d !important;' : '' }}"></i>
                                @endif
                                <div>
                                    <strong>{{ $method->name }}</strong>
                                    <p class="mb-0 text-muted small">{{ $method->description }}</p>

                                    @if($method->discount > 0)
                                    <div class="mt-1" style="font-size: 11px; color: #000000; font-weight: bold;">
                                        <i class="fa-solid fa-tags" style="font-size: 10px;"></i> 
                                        {{ trans_db('frontend.Discount') }}: {{ $method->discount }} {{ $method->discount_type == 'percentage' ? '%' : '' }}
                                    </div>
                                    @endif

                                    @if($isOverLimit)
                                    <div class="mt-1" style="font-size: 11px; color: #dc3545; font-weight: bold;">
                                        <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i>
                                        {{ trans_db('frontend.Not Available for orders over') }} {{ format_price($method->cod_limit) }}
                                    </div>
                                    @elseif($isCash && $method->cod_limit)
                                    <div class="mt-1" style="font-size: 11px; color: #dc3545;">
                                        <i class="fa-solid fa-circle-exclamation" style="font-size: 10px;"></i>
                                        {{ trans_db('frontend.Maximum Limit') }}: {{ format_price($method->cod_limit) }}
                                    </div>
                                    @endif
                                </div>
                            </label>
                            @empty
                            <div class="alert alert-warning col-12">
                                {{ trans_db('frontend.No payment methods available') }}
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="premium-card sticky-top" style="top: 100px;">
                        <h2 class="checkout-section-title">{{ trans_db('frontend.Order Summary') }}</h2>
                        
                        <div class="order-items-preview mb-4">
                            @foreach($cartItems as $item)
                                @php
                                    [$flashPrice, $flashId, $validFrom, $validTo, $flashName] = \App\Services\OrderService::getFlashSaleValue($item->product_id);
                                    $finalPrice = ($flashPrice > 0) ? $flashPrice : ($item->product->special_price ?: $item->product->price);
                                @endphp
                            <div class="order-summary-item" data-product-id="{{ $item->product_id }}" data-final-price="{{ $finalPrice }}" data-quantity="{{ $item->quantity }}">
                                <img src="{{ asset($item->product->image) }}" class="summary-img" alt="{{ $item->product->translation->name }}">
                                <div class="summary-details">
                                    <span class="summary-title text-truncate" style="max-width: 180px;">{{ $item->product->translation->name }}</span>
                                    <div class="summary-meta">
                                        {{ $item->quantity }} × {{ format_price($finalPrice) }}
                                        
                                        @if($flashPrice > 0)
                                        <div style="margin-top: 4px;">
                                            <span class="badge badge-danger" style="font-size: 10px; background-color: #e74c3c; padding: 3px 6px;">
                                                <i class="fa-solid fa-bolt"></i> عرض فلاش
                                                @if($flashName)
                                                    <span style="font-size: 9px; opacity: 0.9;">({{ $flashName }})</span>
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="coupon-section">
                            <h5 class="mb-3" style="font-weight: 700; font-size: 0.95rem;">{{ trans_db('frontend.Have a coupon?') }}</h5>
                            <div id="coupon-input-container" style="display: {{ $coupon ? 'none' : 'block' }};">
                                <div class="coupon-input-group">
                                    <input type="text" id="coupon-code" class="coupon-input" placeholder="{{ trans_db('frontend.Enter coupon code') }}">
                                    <button type="button" class="btn-apply-coupon" onclick="applyCoupon()">{{ trans_db('frontend.Apply') }}</button>
                                </div>
                                <div id="coupon-error" class="text-danger small mt-2" style="display: none;"></div>
                            </div>
                            
                            <div id="applied-coupon-container" style="display: {{ $coupon ? 'block' : 'none' }};">
                                <div class="applied-coupon">
                                    <span><i class="fa-solid fa-tag"></i> <span id="display-coupon-code">{{ $coupon['code'] ?? '' }}</span></span>
                                    <button type="button" class="btn-remove-coupon" onclick="removeCoupon()">{{ trans_db('frontend.Remove') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="summary-details-box">
                            <div class="summary-row">
                                <span>{{ trans_db('frontend.subtotal') }}</span>
                                <strong>{{ format_price($subtotal) }}</strong>
                            </div>
                            <div class="summary-row">
                                <span>{{ trans_db('frontend.shipping_cost') }}</span>
                                <strong class="text-success" id="shipping-cost-display">{{ format_price(0) }}</strong>
                            </div>
                            <div class="summary-row" id="services-row" style="display: none;">
                                <span>{{ trans_db('frontend.Services') }}</span>
                                <strong id="services-cost">{{ format_price(0) }}</strong>
                            </div>
                            <div class="summary-row text-success" id="discount-row" style="display: none;">
                                <span>{{ trans_db('frontend.Payment Discount') }}</span>
                                <strong id="discount-amount">- {{ format_price(0) }}</strong>
                            </div>
                            <div class="summary-row text-success" id="coupon-discount-row" style="display: {{ $coupon ? 'flex' : 'none' }};">
                                <span>{{ trans_db('frontend.Coupon Discount') }}</span>
                                <strong id="coupon-discount-amount">- {{ format_price(0) }}</strong>
                            </div>
                            <div class="summary-row total">
                                <span class="h5 mb-0">{{ trans_db('frontend.total') }}</span>
                                <span class="value" id="total-display">{{ format_price($subtotal) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-place-order" id="submitOrderBtn" disabled>{{ trans_db('frontend.Place Order') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    const subtotal = {{ $subtotal }};
    let currentShippingCost = 0;

    function selectAddress(id, element) {
        $('.address-card').removeClass('selected');
        $(element).addClass('selected');
        $(element).find('input[type="radio"]').prop('checked', true);
        checkFormValidity();

        // Fetch Shipping Cost
        $.ajax({
            url: '{{ route("frontend.user.shipping.cost") }}',
            type: 'GET',
            data: { address: id },
            success: function(response) {
                currentShippingCost = parseFloat(response);
                $('#shipping-cost-display').text(currentShippingCost.toFixed(2));
                updateTotal();
            },
            error: function(error) {
                console.log(error)
                console.error('Failed to fetch shipping cost');
            }
        });
    }

    function selectPayment(input) {
        $('.payment-method-item').removeClass('selected');
        $(input).closest('.payment-method-item').addClass('selected');
        checkFormValidity();
        updateTotal();
    }

    function checkFormValidity() {
        const addressSelected = $('input[name="address_id"]:checked').length > 0;
        const paymentSelected = $('input[name="payment_method"]:checked').length > 0;
        
        if (addressSelected && paymentSelected) {
            $('#submitOrderBtn').prop('disabled', false).css('opacity', '1').css('cursor', 'pointer');
        } else {
            $('#submitOrderBtn').prop('disabled', true).css('opacity', '0.6').css('cursor', 'not-allowed');
        }
    }

    function updateTotal() {
        let servicesTotal = 0;
        $('.service-checkbox:checked').each(function() {
            servicesTotal += parseFloat($(this).data('price'));
        });

        if (servicesTotal > 0) {
            $('#services-row').show();
            $('#services-cost').text(servicesTotal.toFixed(2)); 
        } else {
            $('#services-row').hide();
        }

        let totalBeforeDiscount = subtotal + servicesTotal + currentShippingCost;
        let paymentDiscountAmount = 0;

        // Calculate Payment Discount
        const selectedPayment = $('input[name="payment_method"]:checked');
        if (selectedPayment.length > 0) {
            const discount = parseFloat(selectedPayment.data('discount') || 0);
            const discountType = selectedPayment.data('discount-type');

            if (discount > 0) {
                if (discountType === 'percentage') {
                    paymentDiscountAmount = (totalBeforeDiscount * discount) / 100;
                } else {
                    paymentDiscountAmount = discount;
                }
            }
        }

        if (paymentDiscountAmount > 0) {
            $('#discount-row').show();
            $('#discount-amount').text('- ' + paymentDiscountAmount.toFixed(2));
        } else {
            $('#discount-row').hide();
        }

        // Calculate Coupon Discount
        let couponDiscountAmount = 0;
        if (currentCoupon) {
            let isAllowedPayment = true;
            if (currentCoupon.payment_method_id && Array.isArray(currentCoupon.payment_method_id) && currentCoupon.payment_method_id.length > 0) {
                const selectedPayment = $('input[name="payment_method"]:checked');
                if (selectedPayment.length > 0) {
                    const selectedPaymentId = selectedPayment.val();
                    if (!currentCoupon.payment_method_id.map(String).includes(String(selectedPaymentId))) {
                        isAllowedPayment = false;
                    }
                } else {
                    // Force payment selection first if coupon has restrictions
                    isAllowedPayment = false;
                }
            }

                if (isAllowedPayment) {
                    // Check for product restrictions
                    let discountableSubtotal = subtotal;
                    if (currentCoupon.product_id && Array.isArray(currentCoupon.product_id) && currentCoupon.product_id.length > 0) {
                        discountableSubtotal = 0;
                        // We need products prices from the DOM to calculate partial discount
                        $('.order-summary-item').each(function() {
                            const pid = $(this).data('product-id');
                            const price = parseFloat($(this).data('final-price'));
                            const qty = parseInt($(this).data('quantity'));
                            if (currentCoupon.product_id.map(String).includes(String(pid))) {
                                discountableSubtotal += price * qty;
                            }
                        });
                    }

                    if (currentCoupon.include_shipping) {
                        discountableSubtotal += currentShippingCost;
                    }
                    if (currentCoupon.include_services) {
                        discountableSubtotal += servicesTotal;
                    }

                    if (currentCoupon.discount_type === 'percentage') {
                        couponDiscountAmount = (discountableSubtotal * currentCoupon.discount_value) / 100;
                        if (currentCoupon.max_discount && couponDiscountAmount > currentCoupon.max_discount) {
                            couponDiscountAmount = currentCoupon.max_discount;
                        }
                    } else {
                        couponDiscountAmount = currentCoupon.discount_value;
                        if (couponDiscountAmount > discountableSubtotal) {
                            couponDiscountAmount = discountableSubtotal;
                        }
                    }
                }
        }

        if (couponDiscountAmount > 0) {
            $('#coupon-discount-row').css('display', 'flex');
            $('#coupon-discount-amount').text('- ' + parseFloat(couponDiscountAmount).toFixed(2));
        } else {
            $('#coupon-discount-row').hide();
        }

        let finalTotal = totalBeforeDiscount - paymentDiscountAmount - couponDiscountAmount;
        if (finalTotal < 0) finalTotal = 0;
        
        $('#total-display').text(finalTotal.toFixed(2));
    }

    let couponData = {!! session('coupon') ? json_encode(session('coupon')) : 'null' !!};
    let currentCoupon = couponData;

    function applyCoupon() {
        const code = $('#coupon-code').val();
        if (!code) return;

        const paymentMethodId = $('input[name="payment_method"]:checked').val();

        $('#coupon-error').hide();
        $('.btn-apply-coupon').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ route("frontend.user.checkout.coupon.apply") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                code: code,
                payment_method: paymentMethodId
            },
            success: function(response) {
                if (response.success) {
                    currentCoupon = response.coupon;
                    $('#display-coupon-code').text(currentCoupon.code);
                    $('#coupon-input-container').hide();
                    $('#applied-coupon-container').show();
                    updateTotal();
                    if(typeof swal !== 'undefined') swal("نجاح", response.message, "success");
                } else {
                    $('#coupon-error').text(response.message).show();
                }
            },
            error: function(xhr) {
                let msg = '{{ trans_db('frontend.something_went_wrong') }}';
                if (xhr.status === 422) {
                    msg = xhr.responseJSON.message;
                }
                $('#coupon-error').text(msg).show();
            },
            complete: function() {
                $('.btn-apply-coupon').prop('disabled', false).html('{{ trans_db('frontend.Apply') }}');
            }
        });
    }

    function removeCoupon() {
        $.ajax({
            url: '{{ route("frontend.user.checkout.coupon.remove") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    currentCoupon = null;
                    $('#coupon-code').val('');
                    $('#coupon-code').prop('disabled', false);
                    $('#coupon-input-container').show();
                    $('#applied-coupon-container').hide();
                    updateTotal();
                }
            }
        });
    }

    $(document).ready(function() {
        // Check if address is already selected on load (e.g. only one address)
        const selectedAddress = $('input[name="address_id"]:checked');
        if (selectedAddress.length > 0) {
           selectAddress(selectedAddress.val(), selectedAddress.closest('.address-card'));
        }

        checkFormValidity();
        updateTotal();
    });
</script>
@endpush
