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
    {{-- Top Bar --}}
    <div class="elegant-top-bar" style="background: var(--primary-color); color: #fff; padding: 5px 0; font-size: 12px;">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-phone"></i>
                <span>{{ __('frontend.Customer Service') }}: {{ $Setting->phone ?? '01203036736' }}</span>
            </div>
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-truck-fast"></i>
                <span>{{ __('frontend.Shipping to all governorates') }}</span>
            </div>
            <div class="top-bar-item d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>{{ __('frontend.Real guarantee on all products') }}</span>
            </div>
        </div>
    </div>

    <header class="elegant-header">
        <div class="container d-flex align-items-center justify-content-between py-1">

            {{-- Logo Right --}}
            <div class="header-right d-flex align-items-center gap-3">
                <div class="elegant-logo">
                    <a href="{{ route('frontend.index') }}">
                        @if(isset($Setting) && $Setting->logo)
                            <img src="{{ asset($Setting->logo) }}" alt="{{ $Setting->translate('app_name') }}" style="height: 40px; width: auto">
                        @else
                            <img src="/website/images/logo/logo.png" alt="Logo" style="height: 40px; width: auto">
                        @endif
                    </a>
                </div>
            </div>

            {{-- Search and Nav Center --}}
            <div class="header-center d-flex align-items-center flex-grow-1 mx-4 gap-4">
                <nav class="elegant-main-nav d-none d-lg-block">
                    <ul class="d-flex align-items-center gap-4 list-unstyled m-0">
                        <li>
                            <a href="{{ route('frontend.index') }}" class="nav-link-custom {{ request()->routeIs('frontend.index') ? 'active' : '' }}">{{ __('frontend.Home') }}</a>
                        </li>
                        <li class="position-relative category-dropdown mega-dropdown">
                            <a href="javascript:void(0)" class="nav-link-custom d-flex align-items-center gap-1">
                                {{ __('frontend.Products') }}
                                <i class="fa-solid fa-chevron-down" style="font-size: 10px"></i>
                            </a>
                            <div class="elegant-dropdown-menu mega-menu">
                                <div class="mega-menu-container">
                                    @foreach($categories as $category)
                                    <div class="mega-column">
                                        <a href="{{ url(app()->getLocale() . '/products/' . ($category->translation->slug ?? '')) }}" class="mega-title">
                                            <i class="fa-solid fa-layer-group"></i>
                                            {{ $category->name }}
                                        </a>
                                        <ul class="mega-links">
                                            @foreach($category->children ?? [] as $sub)
                                            <li>
                                                <a href="{{ url(app()->getLocale() . '/products/' . ($sub->translation->slug ?? '')) }}">
                                                    {{ $sub->name }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mega-menu-footer">
                                    <a href="{{ route('frontend.products.index') }}" class="btn-all-categories">
                                        <i class="fa-solid fa-th-large"></i>
                                        {{ __('frontend.Show all products') }}
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('frontend.brands') }}" class="nav-link-custom">{{ __('frontend.Brands') }}</a>
                        </li>
                        <li>
                            <a href="{{ url(app()->getLocale() . '/blogs') }}" class="nav-link-custom">{{ __('frontend.Blog') }}</a>
                        </li>
                        <li>
                            <a href="{{ url(app()->getLocale() . '/about-us') }}" class="nav-link-custom">{{ __('frontend.About Us') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.contact') }}" class="nav-link-custom">{{ __('frontend.Contact Us') }}</a>
                        </li>
                    </ul>
                </nav>

                <form action="{{ route('frontend.products.index') }}" method="get"
                    class="elegant-search-form position-relative flex-grow-1" style="max-width: 400px">
                    <input type="search" name="search" id="headerSearch" class="elegant-search-input"
                        placeholder="{{ __('frontend.Search here...') }}"
                        autocomplete="off" required
                        style="padding-left: 40px; border-radius: 8px; background: #f8f9fa; border: 1px solid #eee; height: 36px; font-size: 13px;" />
                    <button type="submit" class="elegant-search-btn"
                        style="left: 0; background: transparent; color: var(--primary-color); position: absolute; height: 100%; padding: 0 12px; border: none;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div id="liveSearchResults" class="search-results-dropdown"></div>
                </form>
            </div>

            {{-- Actions Left --}}
            <div class="header-left d-flex align-items-center gap-3">
                @guest
                    <a href="{{ route('frontend.login') }}" class="elegant-action-item p-2"
                        style="background: #f8f9fa; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                        <i class="fa-regular fa-user" style="font-size: 16px"></i>
                    </a>
                @else
                    <div class="elegant-dropdown">
                        <a href="javascript:void(0)" class="elegant-action-item p-2 dropdown-toggle"
                            style="background: #f8f9fa; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                            <i class="fa-regular fa-user" style="font-size: 16px"></i>
                        </a>
                        <div class="elegant-dropdown-menu">
                            <a href="{{ route('frontend.user.home') }}" class="elegant-dropdown-item">
                                <i class="fa-regular fa-user"></i> {{ __('frontend.Profile') }}
                            </a>
                            <a href="{{ route('frontend.logout') }}" class="elegant-dropdown-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ __('frontend.Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest

                <a href="{{ route('frontend.wishlist.index') }}" class="elegant-action-item wishlist-toggle p-2 position-relative"
                    style="background: #f8f9fa; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                    <i class="fa-regular fa-heart" style="font-size: 16px"></i>
                    <span class="elegant-badge wishlist-count" style="top: -5px; right: -5px">
                        @php
                            $w_user = \Illuminate\Support\Facades\Auth::user();
                            $w_userId = $w_user ? $w_user->id : null;
                            $w_tempId = \Illuminate\Support\Facades\Cookie::get('temp_user_id');
                            $w_count = 0;
                            if ($w_userId) {
                                $w_count = \App\Models\Wishlist::where('user_id', $w_userId)->count();
                            } elseif ($w_tempId) {
                                $w_count = \App\Models\Wishlist::where('temp_user_id', $w_tempId)->count();
                            }
                        @endphp
                        {{ $w_count }}
                    </span>
                </a>

                <a href="{{ route('frontend.cart.index') }}" class="elegant-action-item cart-toggle position-relative p-2"
                    style="background: #f8f9fa; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: var(--primary-color);">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 16px"></i>
                    <span class="elegant-badge cart-count" style="top: -5px; right: -5px">
                        @php
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
                        {{ $c_count }}
                    </span>
                </a>

                <button class="elegant-mobile-toggle d-lg-none" id="elegantMobileToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- Mobile Menu --}}
    <div class="elegant-mobile-overlay" id="elegantMobileOverlay"></div>
    <div class="elegant-mobile-menu" id="elegantMobileMenu">
        <div class="elegant-mobile-header">
            <span class="mobile-logo-text">{{ $Setting->translate('app_name') ?? 'Egi Medical' }}</span>
            <button class="elegant-mobile-close" id="elegantMobileClose">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="elegant-mobile-body">
            <div class="elegant-mobile-actions">
                @guest
                    <a href="{{ route('frontend.login') }}" class="mobile-action-item">
                        <i class="fa-regular fa-user"></i> {{ __('frontend.Login') }}
                    </a>
                @else
                    <div class="mobile-user-info">
                        <i class="fa-regular fa-user-circle"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('frontend.user.home') }}" class="mobile-action-item">
                        <i class="fa-solid fa-gauge-high"></i> {{ __('frontend.Profile') }}
                    </a>
                    <a href="{{ route('frontend.logout') }}" class="mobile-action-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ __('frontend.Logout') }}
                    </a>
                    <form id="logout-form-mobile" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest

                <a href="{{ route('frontend.wishlist.index') }}" class="mobile-action-item">
                    <i class="fa-regular fa-heart"></i> {{ __('website.Favorite') }}
                    <span class="mobile-badge">{{ $w_count ?? 0 }}</span>
                </a>
                <a href="{{ route('frontend.cart.index') }}" class="mobile-action-item">
                    <i class="fa-solid fa-bag-shopping"></i> {{ __('frontend.Cart') }}
                    <span class="mobile-badge">{{ $c_count ?? 0 }}</span>
                </a>
            </div>

            <hr class="mobile-divider">

            <ul class="elegant-mobile-nav">
                <li><a href="{{ route('frontend.index') }}"><i class="fa-solid fa-house"></i> {{ __('frontend.Home') }}</a></li>
                <li><a href="{{ route('frontend.products.index') }}"><i class="fa-solid fa-bag-shopping"></i> {{ __('frontend.Products') }}</a></li>
                <li><a href="{{ route('frontend.brands') }}"><i class="fa-solid fa-layer-group"></i> {{ __('frontend.Brands') }}</a></li>
                <li><a href="{{ url(app()->getLocale() . '/blogs') }}"><i class="fa-solid fa-newspaper"></i> {{ __('frontend.Blog') }}</a></li>
                <li><a href="{{ url(app()->getLocale() . '/about-us') }}"><i class="fa-solid fa-info-circle"></i> {{ __('frontend.About Us') }}</a></li>
                <li><a href="{{ route('frontend.contact') }}"><i class="fa-solid fa-phone"></i> {{ __('frontend.Contact Us') }}</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
    .nav-link-custom {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        padding: 5px 0;
        position: relative;
    }
    .nav-link-custom:hover,
    .nav-link-custom.active {
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
    .nav-link-custom:hover::after,
    .nav-link-custom.active::after {
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