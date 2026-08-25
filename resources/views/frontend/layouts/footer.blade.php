<footer class="footer-modern-elegant">
    <!-- Newsletter Section -->
    @if(request()->routeIs('frontend.index'))
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="newsletter-content">
                            <div class="icon-wrapper">
                                <i class="fa-regular fa-paper-plane"></i>
                            </div>
                            <div class="text">
                                <h3>{{ trans_db('frontend.Subscribe to our newsletter') }}</h3>
                                <p>{{ trans_db('frontend.Stay updated with our latest offers and products') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="{{ trans_db('frontend.Enter your email address') }}">
                                <button class="btn btn-subscribe" type="button">{{ trans_db('frontend.Subscribe') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <!-- Brand Info -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-widget brand-widget">
                        <a href="{{ route('frontend.index') }}" class="footer-logo">
                            <img src="{{ isset($Setting) && $Setting?->logo ? asset($Setting->logo) : '/website/images/logo/logo.png' }}" alt="{{ $Setting?->translate('app_name') ?? 'qayemwraf' }}">
                        </a>
                        <p class="mt-4 mb-4 text-white-muted">
                            {{ trans_db('frontend.Explore our trusted partners and publishers') }}. 
                            {{ trans_db('frontend.We strive to provide the best products with high quality service.') }}
                        </p>
                        <div class="social-links-modern">
                            @if(isset($Setting->facebook)) <a href="{{ $Setting->facebook }}" class="social-link"><i class="fa-brands fa-facebook-f"></i></a> @endif
                            @if(isset($Setting->twitter)) <a href="{{ $Setting->twitter }}" class="social-link"><i class="fa-brands fa-twitter"></i></a> @endif
                            @if(isset($Setting->instagram)) <a href="{{ $Setting->instagram }}" class="social-link"><i class="fa-brands fa-instagram"></i></a> @endif
                            @if(isset($Setting->youtube)) <a href="{{ $Setting->youtube }}" class="social-link"><i class="fa-brands fa-youtube"></i></a> @endif
                        </div>
                    </div>
                </div>

                <!-- Links 1 -->
                <div class="col-lg-2 col-md-6 mb-5">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{ trans_db('frontend.Quick Links') }}</h4>
                        <ul class="widget-links">
                            <li><a href="{{ route('frontend.index') }}">{{ trans_db('frontend.Home') }}</a></li>
                            <li><a href="{{ route('frontend.brands') }}">{{ trans_db('frontend.Brands') }}</a></li>
                            <li><a href="{{ route('frontend.contact') }}">{{ trans_db('frontend.Contact Us') }}</a></li>
                            <li><a href="#">{{ trans_db('frontend.Shop') }}</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Links 2 -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{ trans_db('frontend.Customer Care') }}</h4>
                        <ul class="widget-links">
                            @auth
                                <li><a href="{{ route('frontend.user.home') }}">{{ trans_db('frontend.Profile') }}</a></li>
                            @else
                                <li><a href="{{ route('frontend.login') }}">{{ trans_db('frontend.Login') }}</a></li>
                                <li><a href="{{ route('frontend.register') }}">{{ trans_db('frontend.Register') }}</a></li>
                            @endauth
                            @foreach($Pages as $footerPage)
                                <li><a href="{{ route('frontend.page.show', $footerPage->translation->slug ?? '') }}">{{ $footerPage->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="footer-widget">
                        <h4 class="widget-title">{{ trans_db('frontend.Contact Us') }}</h4>
                        <ul class="contact-list">
                            <li>
                                <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="text">{{ $Setting?->translate('address') ?? 'Cairo, Egypt' }}</div>
                            </li>
                            <li>
                                <div class="icon"><i class="fa-solid fa-phone"></i></div>
                                <div class="text" dir="ltr">{{ $Setting->phone ?? '+20 123 456 789' }}</div>
                            </li>
                            <li>
                                <div class="icon"><i class="fa-regular fa-envelope"></i></div>
                                <div class="text">{{ $Setting?->contact_email ?? 'info@qayemwraf.com' }}</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright-text">
                        &copy; {{ date('Y') }} <strong>{{ $Setting?->translate('app_name') ?? 'qayemwraf' }}</strong>. {{ trans_db('frontend.All Rights Reserved') }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="payment-methods">
                        <i class="fa-brands fa-cc-visa"></i>
                        <i class="fa-brands fa-cc-mastercard"></i>
                        <i class="fa-brands fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" class="modern-scroll-top" id="scrollTopBtn">
    <i class="fa-solid fa-arrow-up"></i>
</a>

<style>
    :root {
        --footer-bg: #111827;
        --footer-text: #9ca3af;
        --footer-title: #f3f4f6;
        --primary-gradient: linear-gradient(135deg, #1c4dad 0%, #3066d1 100%); /* New Blue Gradient */
        --hover-color: #e98939; /* Orange */
    }

    .footer-modern-elegant {
        background-color: var(--footer-bg);
        color: var(--footer-text);
        font-family: 'Cairo', sans-serif;
        position: relative;
        margin-top: 100px; /* Space for newsletter overlap */
    }

    /* Newsletter Section - Floating */
    .newsletter-section {
        position: absolute;
        top: -80px;
        left: 0;
        width: 100%;
        z-index: 10;
    }

    .newsletter-wrapper {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem 3rem;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    /* Abstract shapes bg for newsletter */
    .newsletter-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .newsletter-wrapper::after {
        content: '';
        position: absolute;
        bottom: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .newsletter-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        color: white;
        position: relative;
        z-index: 2;
    }

    .newsletter-content .icon-wrapper {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .newsletter-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }
    
    .newsletter-content p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .newsletter-form .input-group {
        background: #fff;
        border-radius: 50px;
        padding: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .newsletter-form .form-control {
        border: none;
        background: transparent;
        padding: 10px 20px;
        height: auto;
        font-size: 1rem;
    }

    .newsletter-form .form-control:focus {
        box-shadow: none;
    }

    .newsletter-form .btn-subscribe {
        background: #111827;
        color: white;
        border-radius: 50px !important; /* Force rounded shape */
        padding: 10px 30px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 48px; /* Fixed height to match input usually */
        margin-left: 0;
        margin-right: auto; /* Push to end if needed */
    }

    html[dir="rtl"] .newsletter-form .btn-subscribe {
        margin-right: 0;
        margin-left: auto;
    }

    .newsletter-form .btn-subscribe:hover {
        background: #374151;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    /* Main Footer */
    .footer-main {
        padding-top: 120px; /* Compensate overlap */
        padding-bottom: 3rem;
    }

    .footer-widget .footer-logo img {
        height: 50px;
        filter: brightness(0) invert(1);
    }

    .text-white-muted {
        color: rgba(255,255,255,0.6);
        line-height: 1.8;
    }

    .widget-title {
        color: var(--footer-title);
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .widget-title::after {
        content: '';
        display: block;
        width: 100%;
        height: 2px;
        background: var(--gold-gradient);
        margin-top: 10px;
        border-radius: 2px;
    }

    .widget-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .widget-links li {
        margin-bottom: 0.8rem;
    }

    .widget-links li a {
        color: var(--footer-text);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .widget-links li a::before {
        content: '\f104'; /* FontAwesome Left Angle */
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-right: 0;
        margin-left: 10px;
        font-size: 0.8rem;
        opacity: 0;
        transform: translateX(10px);
        transition: all 0.3s ease;
        color: var(--hover-color);
    }
    
    html[dir="ltr"] .widget-links li a::before {
        content: '\f105'; /* Right Angle */
        margin-left: 0;
        margin-right: 10px;
        transform: translateX(-10px);
    }

    .widget-links li a:hover {
        color: white;
        padding-right: 5px;
    }
    html[dir="ltr"] .widget-links li a:hover {
        padding-right: 0;
        padding-left: 5px;
    }

    .widget-links li a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    /* Contact List */
    .contact-list {
        list-style: none;
        padding: 0;
    }

    .contact-list li {
        display: flex;
        gap: 15px;
        margin-bottom: 1.2rem;
        align-items: flex-start;
    }

    .contact-list .icon {
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
        flex-shrink: 0;
    }

    /* Social Links Modern */
    .social-links-modern {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255,255,255,0.05);
    }

    .social-link:hover {
        background: var(--primary-gradient);
        transform: translateY(-5px);
        border-color: transparent;
        box-shadow: 0 10px 20px rgba(28, 77, 173, 0.3);
    }

    /* Footer Bottom Show */
    .footer-bottom {
        padding: 2rem 0;
        border-top: 1px solid rgba(255,255,255,0.05);
        background: #0b111d;
    }

    .copyright-text {
        margin: 0;
        font-size: 0.9rem;
    }

    .payment-methods {
        font-size: 2rem;
        color: #fff;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    
    html[dir="rtl"] .payment-methods {
        justify-content: flex-start; /* Or keep aligned end based on design */
    }
    
    @media (max-width: 768px) {
        html[dir="rtl"] .payment-methods {
            justify-content: center;
        }
        html[dir="ltr"] .payment-methods {
            justify-content: center;
        }
        .footer-widget .footer-logo img {
    height: 150px;
        }
    }

    /* Scroll Top Styles */
    .modern-scroll-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--footer-bg);
        border: 2px solid #374151;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }
    
    html[dir="rtl"] .modern-scroll-top {
        right: auto;
        left: 30px;
    }

    .modern-scroll-top.show {
        opacity: 1;
        visibility: visible;
        bottom: 40px;
    }

    .modern-scroll-top:hover {
        background: var(--primary-gradient);
        border-color: transparent;
        transform: translateY(-5px);
    }

    @media (max-width: 991px) {
        .footer-modern-elegant {
            margin-top: 0;
        }
        .newsletter-section {
            position: relative;
            top: 0;
            padding: 2rem 0;
            background: var(--footer-bg);
        }
        .footer-main {
            padding-top: 0;
        }

        .newsletter-wrapper {
            padding: 1rem 1.5rem; /* Reduce padding on mobile */
            text-align: center;
        }

        .newsletter-content {
            flex-direction: column;
            text-align: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        .newsletter-content .icon-wrapper {
            margin: 0 auto;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .newsletter-content h3 {
            font-size: 1.2rem; /* Smaller font for title */
        }

        .newsletter-content p {
            font-size: 0.9rem; /* Smaller font for description */
        }

        html[dir="rtl"] .text-md-start, 
        html[dir="rtl"] .text-md-end {
            text-align: center !important;
        }
        .payment-methods {
            margin-top: 1rem;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var scrollTopBtn = document.getElementById('scrollTopBtn');
        
        if (scrollTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            scrollTopBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        }
    });
</script>
