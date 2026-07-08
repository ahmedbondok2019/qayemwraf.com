@extends('frontend.layouts.master')

@section('content')
<div class="page-contact-us-premium">
    <div class="contact-page-wrapper">
        <div class="contact-container">
            <div class="contact-header">
                <h1 class="font-weight-bold">{{ trans_db('frontend.Contact Us') }}</h1>
                <p class="text-muted">{{ trans_db('frontend.We would love to hear from you') }}</p>
            </div>

            <div class="contact-card">
                <div class="contact-layout">
                    <!-- Contact Information Side -->
                    <div class="contact-sidebar">
                        <div class="contact-info">
                            <div class="info-content">
                                <h3>{{ trans_db('frontend.Get In Touch') }}</h3>
                                <p class="mb-4 text-white-50">{{ trans_db('frontend.Feel free to contact us for any inquiry') }}</p>
                                
                                <div class="info-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <div>
                                        <h5>{{ trans_db('frontend.Address') }}</h5>
                                        <p>{{ $Setting->translate('address') ?? 'Cairo, Egypt' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fa-solid fa-phone"></i>
                                    <div>
                                        <h5>{{ trans_db('frontend.Phone') }}</h5>
                                        <p>{{ $Setting->phone ?? '+20 123 456 7890' }}</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fa-regular fa-envelope"></i>
                                    <div>
                                        <h5>{{ trans_db('frontend.Email') }}</h5>
                                        <p>{{ $Setting->contact_email ?? 'info@mushafhome.com' }}</p>
                                    </div>
                                </div>

                                <div class="social-links mt-5">
                                    @if(isset($Setting->facebook)) <a href="{{ $Setting->facebook }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a> @endif
                                    @if(isset($Setting->twitter)) <a href="{{ $Setting->twitter }}" target="_blank"><i class="fa-brands fa-twitter"></i></a> @endif
                                    @if(isset($Setting->instagram)) <a href="{{ $Setting->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a> @endif
                                    @if(isset($Setting->youtube)) <a href="{{ $Setting->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a> @endif
                                </div>
                            </div>
                            
                            <!-- Decorative circles -->
                            <div class="circle circle-1"></div>
                            <div class="circle circle-2"></div>
                        </div>
                    </div>

                    <!-- Contact Form Side -->
                    <div class="contact-content">
                        <div class="contact-form-wrapper">
                            <h3>{{ trans_db('frontend.Send Message') }}</h3>
                            
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('frontend.contact.store') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label>{{ trans_db('frontend.Name') }}</label>
                                            <input type="text" name="name" class="custom-input" placeholder="{{ trans_db('frontend.Enter your name') }}" value="{{ old('name') }}" required>
                                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label>{{ trans_db('frontend.Phone') }}</label>
                                            <input type="text" name="phone" class="custom-input" placeholder="{{ trans_db('frontend.Enter your phone') }}" value="{{ old('phone') }}">
                                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>{{ trans_db('frontend.Email Address') }}</label>
                                    <input type="email" name="email" class="custom-input" placeholder="{{ trans_db('frontend.Enter your email') }}" value="{{ old('email') }}" required>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label>{{ trans_db('frontend.Subject') }}</label>
                                    <input type="text" name="subject" class="custom-input" placeholder="{{ trans_db('frontend.Enter subject') }}" value="{{ old('subject') }}" required>
                                    @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label>{{ trans_db('frontend.Message') }}</label>
                                    <textarea name="message" class="custom-input" rows="4" placeholder="{{ trans_db('frontend.Write your message here') }}" required>{{ old('message') }}</textarea>
                                    @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="auth-btn w-auto px-5">
                                    {{ trans_db('frontend.Send Message') }} <i class="fa-solid fa-paper-plane ml-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* Reset and Layout */
    .page-contact-us-premium * {
        box-sizing: border-box;
    }

    .page-contact-us-premium .contact-page-wrapper {
        padding: 4rem 0;
        background-color: #FDFCF5;
        min-height: 100vh;
        width: 100%;
    }

    .page-contact-us-premium .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        width: 100%;
    }

    .page-contact-us-premium .contact-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-contact-us-premium .contact-header h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: #2d3748;
    }

    .page-contact-us-premium .contact-header p {
        font-size: 1.1rem;
        color: #718096;
    }

    /* Card Layout */
    .page-contact-us-premium .contact-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-top: 2rem;
    }

    .page-contact-us-premium .contact-layout {
        display: flex;
        flex-direction: row;
        width: 100%;
    }

    @media (max-width: 900px) {
        .page-contact-us-premium .contact-layout {
            flex-direction: column;
        }
        
        .page-contact-us-premium .contact-sidebar {
            width: 100% !important;
            flex: 0 0 100% !important;
        }
        
        .page-contact-us-premium .contact-content {
            width: 100% !important;
            flex: 0 0 100% !important;
        }
    }

    /* Sidebar Styles */
    .page-contact-us-premium .contact-sidebar {
        width: 40%;
        flex: 0 0 40%;
        background: linear-gradient(135deg, #1c4dac 0%, #4C825D 100%);
        color: #fff;
        position: relative;
    }

    .page-contact-us-premium .contact-info {
        padding: 3rem;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .page-contact-us-premium .info-content {
        position: relative;
        z-index: 2;
    }

    .page-contact-us-premium .contact-info h3 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 2rem;
        color: #fff;
    }

    .page-contact-us-premium .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2rem;
        gap: 1rem;
    }

    .page-contact-us-premium .info-item i {
        font-size: 1.2rem;
        background: rgba(255,255,255,0.2);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
        color: #fff;
    }

    .page-contact-us-premium .info-item h5 {
        font-size: 1.1rem;
        margin-bottom: 0.2rem;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
    }

    .page-contact-us-premium .info-item p {
        margin: 0;
        opacity: 0.8;
        font-size: 0.95rem;
        color: #fff;
    }

    .page-contact-us-premium .social-links {
        margin-top: 2rem;
    }

    .page-contact-us-premium .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        border-radius: 50%;
        margin-right: 10px;
        transition: all 0.3s;
        text-decoration: none;
    }

    /* Content/Form Styles */
    .page-contact-us-premium .contact-content {
        width: 60%;
        flex: 0 0 60%;
        background: #fff;
    }

    .page-contact-us-premium .contact-form-wrapper {
        padding: 3rem;
    }

    .page-contact-us-premium .contact-form-wrapper h3 {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 2rem;
        font-size: 1.8rem;
    }

    /* Form Grid */
    .page-contact-us-premium .form-row {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .page-contact-us-premium .form-col {
        flex: 1;
        width: 50%; /* Fallback */
    }

    @media (max-width: 600px) {
        .page-contact-us-premium .form-row {
            flex-direction: column;
            gap: 0;
        }
        .page-contact-us-premium .form-col {
            width: 100%;
        }
    }

    .page-contact-us-premium .form-group {
        margin-bottom: 1.5rem;
        display: block;
        width: 100%;
    }

    .page-contact-us-premium .form-group label {
        color: #4a5568;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: block;
        width: 100%;
    }

    .page-contact-us-premium .custom-input {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        color: #4a5568;
        font-size: 1rem;
        transition: all 0.3s;
        background-color: #f8fafc;
        display: block;
        box-sizing: border-box;
    }

    .page-contact-us-premium .custom-input:focus {
        border-color: #1c4dac;
        box-shadow: 0 0 0 4px rgba(30, 86, 49, 0.1);
        background-color: #fff;
        outline: none;
    }

    .page-contact-us-premium textarea.custom-input {
        resize: vertical;
        min-height: 120px;
    }

    /* Button */
    .page-contact-us-premium .auth-btn {
        background: linear-gradient(135deg, #1c4dac 0%, #4C825D 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px rgba(30, 86, 49, 0.25);
    }

    .page-contact-us-premium .auth-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(30, 86, 49, 0.3);
    }

    /* Decoration */
    .page-contact-us-premium .circle {
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .page-contact-us-premium .circle-1 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        right: -50px;
    }

    .page-contact-us-premium .circle-2 {
        width: 150px;
        height: 150px;
        top: -30px;
        left: -30px;
    }

    /* Utilities */
    .page-contact-us-premium .text-white-50 {
        color: rgba(255, 255, 255, 0.7);
    }

    .page-contact-us-premium .mb-3 { margin-bottom: 1rem; }
    .page-contact-us-premium .mb-4 { margin-bottom: 1.5rem; }
    .page-contact-us-premium .mb-5 { margin-bottom: 3rem; }
    .page-contact-us-premium .mt-5 { margin-top: 3rem; }

    /* RTL Support */
    html[dir="rtl"] .page-contact-us-premium .social-links a {
        margin-right: 0;
        margin-left: 10px;
    }
    
    html[dir="rtl"] .page-contact-us-premium .ml-2 {
        margin-right: 0.5rem;
        margin-left: 0;
    }
    
    html[dir="ltr"] .page-contact-us-premium .ml-2 {
        margin-left: 0.5rem;
        margin-right: 0;
    }
    
    html[dir="rtl"] .page-contact-us-premium .circle-1 {
        right: auto;
        left: -50px;
    }
    
    html[dir="rtl"] .page-contact-us-premium .circle-2 {
        left: auto;
        right: -30px;
    }
</style>
@endpush