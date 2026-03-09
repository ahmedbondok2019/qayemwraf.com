@extends('frontend.layouts.master')

@section('content')
<div class="gift-success-page py-5 d-flex align-items-center justify-content-center" style="min-height: 70vh; background-color: #f9fafb;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg text-center p-5 rounded-4" style="background: white;">
                    <div class="mb-4">
                        <div class="success-icon-wrapper">
                            <i class="fa-solid fa-gift fa-3x text-white"></i>
                        </div>
                    </div>
                    
                    <h2 class="display-6 fw-bold mb-3" style="color: #2c3e50;">{{ trans_db('frontend.Gift request submitted successfully!') }}</h2>
                    
                    <p class="lead text-muted mb-5">
                        {{ trans_db('frontend.Thank you! Your gift request has been received and is being processed. We hope you enjoy your gift!') }}
                    </p>
                    
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('frontend.user.home') }}" class="btn btn-outline-primary btn-lg px-4 rounded-pill">
                            <i class="fa-solid fa-user me-2"></i> {{ trans_db('frontend.Go to Profile') }}
                        </a>
                        <a href="{{ route('frontend.index') }}" class="btn btn-primary btn-lg px-4 rounded-pill">
                            <i class="fa-solid fa-house me-2"></i> {{ trans_db('frontend.Back to Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .success-icon-wrapper {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
        animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        80% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); }
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
</style>
@endpush
@endsection
