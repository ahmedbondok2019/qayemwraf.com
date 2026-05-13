@php
    $main_categories = \App\Models\Category::whereNull('parent_id')
        ->active()
        ->with(['children' => function($q) {
            $q->active()->with('translation');
        }])
        ->take(10)
        ->get();

    $c_user = \Illuminate\Support\Facades\Auth::user();
    $c_userId = $c_user ? $c_user->id : null;
    $c_tempId = \Illuminate\Support\Facades\Cookie::get('temp_user_id');
    $c_count = 0;
    if ($c_userId) {
        $c_count = \App\Models\Cart::where('user_id', $c_userId)->sum('quantity');
    } elseif ($c_tempId) {
        $c_count = \App\Models\Cart::where('temp_user_id', $c_tempId)->sum('quantity');
    }
@endphp


<div class="elegant-fixed-top">
    <!-- Top Bar -->
    <div class="elegant-top-bar" style="background: var(--primary-color); color: #fff; padding: 8px 0; font-size: 13px;">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-phone"></i>
                <span>{{ trans_db('frontend.Customer Care') }}: {{ $Setting->phone ?? '01061734557' }}</span>
            </div>
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-truck-fast"></i>
                <span>{{ trans_db('frontend.Shipping') }} لجميع المحافظات</span>
            </div>
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>ضمان حقيقي على جميع المنتجات</span>
            </div>

        </div>
    </div>

    <header class="elegant-header">
        <div class="container d-flex align-items-center justify-content-between py-2">
            
            <!-- Logo Right -->
            <div class="header-right d-flex align-items-center gap-3">
                <div class="elegant-logo">
                    <a href="{{ route('frontend.index') }}">
                        @if(isset($Setting) && $Setting?->logo)
                            <img src="{{ asset($Setting->logo) }}" alt="{{ $Setting?->translate('app_name') }}" style="height: 65px; width: auto;">
                        @else
                            <img src="https://souqelmlabes.com/website/images/logo/souqelmlabes2024-08-31-19-55-37.png" alt="Logo" style="height: 65px; width: auto;">
                        @endif
                    </a>
                </div>
            </div>

            <!-- Search and Nav Center -->
            <div class="header-center d-flex align-items-center flex-grow-1 mx-4 gap-4">
                <nav class="elegant-main-nav d-none d-lg-block">
                    <ul class="d-flex align-items-center gap-4 list-unstyled m-0">
                        <li><a href="{{ route('frontend.index') }}" class="nav-link-custom active">{{ trans_db('frontend.Home') }}</a></li>
                        <li class="position-relative category-dropdown mega-dropdown">
                            <a href="javascript:void(0)" class="nav-link-custom d-flex align-items-center gap-1">
                                {{ trans_db('frontend.products') }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
                            </a>
                            <div class="elegant-dropdown-menu mega-menu">
                                <div class="mega-menu-container">
                                    @foreach($main_categories as $cat)
                                        <div class="mega-column">
                                            <a href="{{ route('frontend.products.index', ['category' => $cat->translation->slug ?? 'category']) }}" class="mega-title">
                                                <i class="fa-solid fa-layer-group"></i> {{ $cat->name }}
                                            </a>
                                            <ul class="mega-links">
                                                @foreach($cat->children->take(8) as $child)
                                                    <li>
                                                        <a href="{{ route('frontend.products.index', ['category' => $child->translation->slug ?? 'category']) }}">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li><a href="{{ route('frontend.brands') }}" class="nav-link-custom">{{ trans_db('frontend.categories') }}</a></li>
                        <li><a href="{{ url('blogs') }}" class="nav-link-custom">{{ trans_db('frontend.Blog') }}</a></li>
                        <li><a href="{{ route('frontend.about-us') }}" class="nav-link-custom">{{ trans_db('website.About us') }}</a></li>
                        <li><a href="{{ route('frontend.contact') }}" class="nav-link-custom">{{ trans_db('frontend.Contact Us') }}</a></li>

                    </ul>
                </nav>

                <form action="{{ route('frontend.products.index') }}" method="get" class="elegant-search-form position-relative flex-grow-1" style="max-width: 250px;">
                    <input type="search" name="search" id="headerSearch" class="elegant-search-input"
                        placeholder="ابحث هنا..." autocomplete="off" required 
                        style="padding-left: 40px; border-radius: 8px; background: #f8f9fa; border: 1px solid #eee; height: 40px; font-size: 13px;">
                    <button type="submit" class="elegant-search-btn" style="left: 0; background: transparent; color: var(--primary-color); position: absolute; height: 100%; padding: 0 12px; border: none;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div id="liveSearchResults" class="search-results-dropdown"></div>
                </form>
            </div>

            <!-- Actions Left -->
            <div class="header-left d-flex align-items-center gap-3">
                @guest
                    <a href="{{ route('frontend.login') }}" class="elegant-action-item p-2" style="background: #f8f9fa; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                        <i class="fa-regular fa-user" style="font-size: 18px;"></i>
                    </a>
                @else
                    <div class="elegant-dropdown">
                        <a href="javascript:void(0)" class="elegant-action-item p-2" style="background: #f8f9fa; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                            <i class="fa-regular fa-user" style="font-size: 18px;"></i>
                        </a>
                        <div class="elegant-dropdown-menu">
                            <a href="{{ route('frontend.user.home') }}" class="elegant-dropdown-item">
                                <i class="fa-regular fa-user"></i> {{ trans_db('frontend.Profile') }}
                            </a>
                            <a href="{{ route('frontend.logout') }}" class="elegant-dropdown-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ trans_db('frontend.Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest

                <a href="{{ route('frontend.cart.index') }}" class="elegant-action-item position-relative p-2" style="background: #f8f9fa; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 18px;"></i>
                    <span class="elegant-badge cart-count" style="top: -5px; right: -5px;">
                        {{ $c_count ?? 0 }}
                    </span>
                </a>

                <button class="elegant-mobile-toggle d-lg-none" id="elegantMobileToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>


    <!-- Mobile Menu -->
    <div class="elegant-mobile-overlay" id="elegantMobileOverlay"></div>
    <div class="elegant-mobile-menu" id="elegantMobileMenu">
        <div class="elegant-mobile-header">
            <span class="mobile-logo-text">{{ $Setting?->translate('app_name') ?? 'Egi Medical' }}</span>
            <button class="elegant-mobile-close" id="elegantMobileClose">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="elegant-mobile-body">
            <ul class="elegant-mobile-nav">
                <li><a href="{{ route('frontend.index') }}"><i class="fa-solid fa-house"></i> الرئيسية</a></li>
                <li><a href="{{ route('frontend.products.index') }}"><i class="fa-solid fa-bag-shopping"></i> المنتجات</a></li>
                <li><a href="{{ route('frontend.brands') }}"><i class="fa-solid fa-layer-group"></i> الأقسام</a></li>
                <li><a href="{{ url('blogs') }}"><i class="fa-solid fa-newspaper"></i> المدونة</a></li>
                <li><a href="{{ route('frontend.about-us') }}"><i class="fa-solid fa-info-circle"></i> من نحن</a></li>
                <li><a href="{{ route('frontend.contact') }}"><i class="fa-solid fa-phone"></i> تواصل معنا</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
    .nav-link-custom {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        padding: 10px 0;
        position: relative;
    }
    .nav-link-custom:hover, .nav-link-custom.active {
        color: var(--primary-color);
    }
    .nav-link-custom::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 0;
        height: 2px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }
    .nav-link-custom:hover::after, .nav-link-custom.active::after {
        width: 100%;
    }
    .elegant-header {
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }
    @media (max-width: 991px) {
        .header-center {
            display: none !important;
        }
    }
</style>