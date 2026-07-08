@extends('frontend.layouts.master')

@section('content')
<div class="brands-page-wrapper">
    <div class="container">
        <div class="brands-header text-center mb-5">
            <h1 class="display-4 font-weight-bold">{{ trans_db('frontend.Our Brands') }}</h1>
            <p class="lead text-muted">{{ trans_db('frontend.Explore our trusted partners and publishers') }}</p>
        </div>

        <div class="brands-grid mt-4">
            @forelse($brands as $brand)
            <div class="brand-item">
                <div class="brand-card">
                    <div class="brand-logo">
                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}">
                    </div>
                    <div class="brand-info">
                        <h3 class="brand-name">{{ $brand->name }}</h3>
                        {{-- Add a link to filter products by this brand later if needed --}}
                        <a href="{{ route('frontend.products.index', ['brands[]' => $brand->id]) }}" class="view-products-btn">
                            {{ trans_db('frontend.View Products') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>{{ trans_db('frontend.No brands found') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    .brands-page-wrapper {
        padding: 4rem 0;
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
        background-size: 20px 20px;
        min-height: 80vh;
    }

    .brands-header h1 {
        font-size: 2.5rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
        position: relative;
        display: inline-block;
    }
    
    .brands-header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }

    .brands-header p {
        color: #718096;
        margin-top: 1.5rem;
    }

    .brands-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 2.5rem;
        padding-top: 2rem;
    }

    .brand-item {
        opacity: 0;
        animation: fadeUp 0.6s ease-out forwards;
    }

    /* Staggered animation delays */
    .brand-item:nth-child(1) { animation-delay: 0.1s; }
    .brand-item:nth-child(2) { animation-delay: 0.2s; }
    .brand-item:nth-child(3) { animation-delay: 0.3s; }
    .brand-item:nth-child(4) { animation-delay: 0.4s; }
    .brand-item:nth-child(5) { animation-delay: 0.5s; }
    .brand-item:nth-child(6) { animation-delay: 0.6s; }
    .brand-item:nth-child(n+7) { animation-delay: 0.7s; }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .brand-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 2.5rem 2rem;
        position: relative;
        z-index: 1;
        border: 1px solid #edf2f7;
    }

    .brand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transition: transform 0.4s ease;
        transform-origin: left;
    }
    
    html[dir="rtl"] .brand-card::before {
        transform-origin: right;
    }

    .brand-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: transparent;
    }

    .brand-card:hover::before {
        transform: scaleX(1);
    }

    .brand-logo {
        width: 140px;
        height: 140px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.4s ease;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 50%;
    }

    .brand-logo img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: all 0.4s ease;
        opacity: 0.7;
    }

    .brand-card:hover .brand-logo {
        transform: scale(1.05);
        background: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .brand-card:hover .brand-logo img {
        filter: grayscale(0%);
        opacity: 1;
    }

    .brand-name {
        font-size: 1.35rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        font-family: 'Cairo', sans-serif;
    }

    .view-products-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: #4a5568;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.4s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 10px; /* Keep border-radius as it was not explicitly removed */
    }

    .brand-card:hover .view-products-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
    }

    .view-products-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
        color: #fff;
    }
    
    html[dir="rtl"] .ml-2 {
        margin-right: 0.5rem;
        margin-left: 0;
    }
    
    html[dir="ltr"] .ml-2 {
        margin-left: 0.5rem;
        margin-right: 0;
    }
</style>
@endpush
