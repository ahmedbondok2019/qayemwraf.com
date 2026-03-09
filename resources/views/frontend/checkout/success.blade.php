@extends('frontend.layouts.master')

@push('css')
<style>
    .success-container {
        padding: 100px 0;
        text-align: center;
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .success-card {
        background: white;
        padding: 50px;
        border-radius: 20px;
        width: 100%;
    }
    .check-circle {
        width: 80px;
        height: 80px;
        background: #4C825D;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: white;
        font-size: 40px;
        box-shadow: 0 10px 20px rgba(76, 130, 93, 0.3);
    }
    .order-number {
        background: #f3f4f6;
        padding: 10px 20px;
        border-radius: 10px;
        display: inline-block;
        margin: 20px 0;
        font-weight: 600;
        color: #374151;
    }
    .buttons-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }
    .btn-primary {
        background: #1E5631;
        border-color: #1E5631;
    }
    .btn-outline {
        border: 2px solid #e5e7eb;
        color: #374151;
        background: transparent;
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="container">
        <div class="success-card">
            <div class="check-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            
            <h1 class="mb-3">{{ trans_db('frontend.Order Placed Successfully') }}</h1>
            <p class="text-muted mb-4">{{ trans_db('frontend.Thank you for your purchase. Your order has been received and is being processed.') }}</p>
            
            <div class="order-number">
                {{ trans_db('frontend.Order Number') }}: #{{ $order->id }}
            </div>

            @if(session('gift_unlocked') || auth()->user()->gift_page_enabled)
             <div class="mt-4 p-4 rounded-3" style="background-color: #fef3c7; border: 2px dashed #f59e0b;">
                <div class="d-flex align-items-center justify-content-center mb-2 text-warning" style="font-size: 2rem;">
                    <i class="fa-solid fa-gift fa-bounce"></i>
                </div>
                <h4 class="text-warning font-weight-bold mb-2">{{ trans_db('frontend.Congratulations! You unlocked the Gift Page') }}</h4>
                <p class="mb-3 text-muted">{{ trans_db('frontend.You can now access exclusive gifts from your profile.') }}</p>
                <a href="{{ route('frontend.user.home') }}" class="btn btn-warning text-white font-weight-bold">
                    <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.Go to Gift Page') }}
                </a>
             </div>
            @endif
            
            <div class="buttons-group">
                <a href="{{ route('frontend.user.home') }}" class="btn btn-outline px-4 py-2 rounded-3">
                    {{ trans_db('frontend.Track Order') }}
                </a>
                <a href="{{ route('frontend.index') }}" class="btn btn-primary text-white px-4 py-2 rounded-3">
                    {{ trans_db('frontend.Continue Shopping') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
