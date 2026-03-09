@extends('frontend.layouts.master')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            @include('frontend.profile.sidebar')

            <!-- Content -->
            <div class="profile-content">
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1">{{ trans_db('frontend.Order Details') }} #{{ $order->id }}</h3>
                        <p class="text-muted mb-0">{{ $order->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <a href="{{ route('frontend.user.orders.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> {{ trans_db('frontend.Back to Orders') }}
                    </a>
                </div>

                <!-- Order Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ trans_db('frontend.Current Status') }}</h5>
                            <span class="badge badge-status {{ $order->status }} px-3 py-2 rounded-pill fs-6">
                                {{ $order->order_status[0] ?? $order->order_status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Order Items -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">{{ trans_db('frontend.Items') }} ({{ $order->order_details->count() }})</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">{{ trans_db('frontend.Product') }}</th>
                                                <th class="text-center">{{ trans_db('frontend.Quantity') }}</th>
                                                <th class="text-end pe-4">{{ trans_db('frontend.Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->order_details as $item)
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            @if($item->product)
                                                                <img src="{{ $item->product->image ?? asset('assets/img/products/product-1.jpg') }}" 
                                                                     alt="{{ $item->product->name }}" 
                                                                     class="rounded me-3" 
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                                <div>
                                                                    <h6 class="mb-0 text-dark">{{ $item->product->name }}</h6>
                                                                    @if($item->option_id)
                                                                        <small class="text-muted">{{ $item->option_name ?? 'Option' }}</small>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <span class="text-danger">{{ trans_db('frontend.Product Unavailable') }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                                    <td class="text-end align-middle pe-4 fw-bold">
                                                        {{ $item->price }} {{ $order->currency }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">{{ trans_db('frontend.Order Summary') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ trans_db('frontend.Subtotal') }}</span>
                                    <span class="fw-bold">{{ $order->subtotal ?? $order->total }} {{ $order->currency }}</span>
                                </div>
                                @if($order->shipping_cost > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">{{ trans_db('frontend.Shipping') }}</span>
                                        <span class="fw-bold">+{{ $order->shipping_cost }} {{ $order->currency }}</span>
                                    </div>
                                @endif
                                @if($order->discount > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">{{ trans_db('frontend.Discount') }}</span>
                                        <span class="text-danger fw-bold">-{{ $order->discount }} {{ $order->currency }}</span>
                                    </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h6 mb-0">{{ trans_db('frontend.Total') }}</span>
                                    <span class="h5 mb-0 text-primary">{{ $order->total }} {{ $order->currency }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0">{{ trans_db('frontend.Shipping Address') }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1 fw-bold">{{ $order->name }}</p>
                                <p class="mb-1 text-muted">{{ $order->address }}</p>
                                <p class="mb-1 text-muted">
                                    {{ $order->city ? ($order->city->translations->first()->name ?? '') : '' }}, 
                                    {{ $order->governorate ? ($order->governorate->translations->first()->name ?? '') : '' }}
                                </p>
                                <p class="mb-0 text-muted"><i class="fa-solid fa-phone me-1 small"></i> {{ $order->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.profile.partials.styles')


@endsection
