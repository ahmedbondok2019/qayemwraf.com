@php
    $main_categories = \App\Models\Category::whereNull('parent_id')
        ->active()
        ->with(['children' => function($q) {
            $q->active()->with('translation');
        }])
        ->take(10)
        ->get();
@endphp

<div class="elegant-fixed-top">
    <header class="elegant-header">
        <div class="container">
            <div class="elegant-logo">
                <a href="{{ route('frontend.index') }}">
                    @if(isset($Setting) && $Setting?->logo)
                        <img src="{{ asset($Setting->logo) }}" alt="{{ $Setting?->translate('app_name') }}">
                    @else
                        <img src="https://souqelmlabes.com/website/images/logo/souqelmlabes2024-08-31-19-55-37.png"
                            alt="Logo">
                    @endif
                </a>
            </div>

            <form action="{{ route('frontend.products.index') }}" method="get"
                class="elegant-search-form position-relative">
                <input type="search" name="search" id="headerSearch" class="elegant-search-input"
                    placeholder="ابحث عن منتجاتك {{ trans_db('website.Favorite') }}..." autocomplete="off" required>
                <button type="submit" class="elegant-search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <div id="liveSearchResults" class="search-results-dropdown"></div>
            </form>

            <div class="elegant-actions">
                @guest
                    <a href="{{ route('frontend.login') }}" class="elegant-action-item">
                        <svg data-testid="UserInverse" viewBox="0 0 24 24">
                            <g stroke-width="2" transform="translate(0, 0)">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M19,20.486v-0.745 c0-1.077-0.577-2.071-1.512-2.605l-3.219-1.842"></path>
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M9.727,15.292l-3.215,1.844 C5.577,17.67,5,18.664,5,19.741v0.745"></path>
                                <circle fill="none" stroke="currentColor" stroke-width="2" cx="12" cy="10" r="4"></circle>
                                <circle fill="none" stroke="currentColor" stroke-width="2" cx="12" cy="12" r="11"></circle>
                            </g>
                        </svg>
                        <span>{{ trans_db('frontend.Login') }}</span>
                    </a>
                @else
                    <div class="elegant-dropdown">
                        <a href="javascript:void(0)" class="elegant-action-item dropdown-toggle">
                            <svg data-testid="UserInverse" viewBox="0 0 24 24">
                                <g stroke-width="2" transform="translate(0, 0)">
                                    <path fill="none" stroke="currentColor" stroke-width="2"
                                        d="M19,20.486v-0.745 c0-1.077-0.577-2.071-1.512-2.605l-3.219-1.842"></path>
                                    <path fill="none" stroke="currentColor" stroke-width="2"
                                        d="M9.727,15.292l-3.215,1.844 C5.577,17.67,5,18.664,5,19.741v0.745"></path>
                                    <circle fill="none" stroke="currentColor" stroke-width="2" cx="12" cy="10" r="4">
                                    </circle>
                                    <circle fill="none" stroke="currentColor" stroke-width="2" cx="12" cy="12" r="11">
                                    </circle>
                                </g>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
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


                <a href="{{ route('frontend.wishlist.index') }}" class="elegant-action-item wishlist-toggle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                        </path>
                    </svg>
                    <span class="elegant-badge wishlist-count">
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
                    <span>{{ trans_db('website.Favorite') }}</span>
                </a>

                <a href="{{ route('frontend.cart.index') }}" class="elegant-action-item cart-toggle">
                    <svg data-testid="CartInverse" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5.75 20C6.7165 20 7.5 20.7835 7.5 21.75C7.5 22.7165 6.7165 23.5 5.75 23.5C4.7835 23.5 4 22.7165 4 21.75C4 20.7835 4.7835 20 5.75 20ZM19.75 20C20.7165 20 21.5 20.7835 21.5 21.75C21.5 22.7165 20.7165 23.5 19.75 23.5C18.7835 23.5 18 22.7165 18 21.75C18 20.7835 18.7835 20 19.75 20ZM4.5 0V4H21.7106L19.3356 13.5H4.5V14.75C4.5 15.3972 4.99187 15.9295 5.62219 15.9935L5.75 16H22.5V17.5H5.75C4.28747 17.5 3.0916 16.3583 3.00502 14.9175L3 14.75V1.5H0V0H4.5ZM19.789 5.5H4.5V12H18.164L19.789 5.5Z">
                        </path>
                    </svg>
                    <span class="elegant-badge cart-count">
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
                    <span>السلة</span>
                </a>
            </div>
            <button class="elegant-mobile-toggle" id="elegantMobileToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="elegant-mobile-overlay" id="elegantMobileOverlay"></div>

            <div class="elegant-mobile-menu" id="elegantMobileMenu">
                <div class="elegant-mobile-header">
                    <span class="mobile-logo-text">{{ $Setting?->translate('app_name') ?? 'Mushaf Home' }}</span>
                    <button class="elegant-mobile-close" id="elegantMobileClose">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="elegant-mobile-body">
                    <div class="elegant-mobile-actions">
                        @guest
                            <a href="{{ route('frontend.login') }}" class="mobile-action-item">
                                <i class="fa-regular fa-user"></i> {{ trans_db('frontend.Login') }}
                            </a>
                        @else
                            <div class="mobile-user-info">
                                <i class="fa-regular fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <a href="{{ route('frontend.user.home') }}" class="mobile-action-item">
                                <i class="fa-solid fa-gauge-high"></i> {{ trans_db('frontend.Profile') }}
                            </a>
                            <a href="{{ route('frontend.logout') }}" class="mobile-action-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ trans_db('frontend.Logout') }}
                            </a>
                            <form id="logout-form-mobile" action="{{ route('frontend.logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        @endguest

                        <a href="{{ route('frontend.wishlist.index') }}" class="mobile-action-item">
                            <i class="fa-regular fa-heart"></i> {{ trans_db('website.Favorite') }}
                            <span class="mobile-badge">{{ $w_count ?? 0 }}</span>
                        </a>

                        <a href="{{ route('frontend.cart.index') }}" class="mobile-action-item">
                            <i class="fa-solid fa-bag-shopping"></i> السلة
                            <span class="mobile-badge">{{ $c_count ?? 0 }}</span>
                        </a>
                    </div>

                    <hr class="mobile-divider">

                    <ul class="elegant-mobile-nav">
                        <li><a href="{{ route('frontend.index') }}"><i class="fa-solid fa-house-chimney"></i>
                                الرئيسية</a></li>
                        
                        <li class="mobile-has-submenu">
                            <a href="javascript:void(0)" class="mobile-submenu-toggle"><i class="fa-solid fa-list-ul"></i>
                                الفئات <i class="fa-solid fa-chevron-down ms-auto arrow-icon"></i></a>
                            <ul class="mobile-submenu" style="display: none; list-style: none; padding-right: 20px; background: #f9f9f9;">
                                @foreach($main_categories ?? [] as $cat)
                                    <li class="{{ $cat->children->count() > 0 ? 'mobile-has-inner-submenu' : '' }}">
                                        <a href="{{ route('frontend.products.index', ['category' => $cat->translation->slug ?? 'category']) }}" class="{{ $cat->children->count() > 0 ? 'mobile-inner-toggle' : '' }}" style="padding: 10px; font-size: 13px; display: flex; align-items: center;">
                                            {{ $cat->name }}
                                            @if($cat->children->count() > 0)
                                                <i class="fa-solid fa-chevron-down ms-auto" style="font-size: 10px; transition: transform 0.3s;"></i>
                                            @endif
                                        </a>
                                        @if($cat->children->count() > 0)
                                            <ul class="mobile-inner-submenu" style="display: none; list-style: none; padding-right: 15px; border-right: 1px solid #eee;">
                                                @foreach($cat->children as $child)
                                                    <li><a href="{{ route('frontend.products.index', ['category' => $child->translation->slug ?? 'category']) }}" style="padding: 8px; font-size: 12px; color: #777;">{{ $child->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li><a href="{{ route('frontend.products.index') }}"><i class="fa-solid fa-bag-shopping"></i>
                                المنتجات</a></li>
                        <li><a
                                href="{{ route('frontend.products.index', ['best_seller' => 1, 'sort' => 'best_seller']) }}"><i
                                    class="fa-solid fa-fire-flame-curved"></i> {{ trans_db('website.Best Seller') }}</a></li>
                        <li><a href="{{ route('frontend.products.index', ['sort' => 'latest']) }}"><i
                                    class="fa-solid fa-bolt"></i> {{ trans_db('website.New arrivals') }}</a></li>
                        <li><a href="{{ route('frontend.products.index', ['flash_sale' => 1]) }}"><i
                                    class="fa-solid fa-stopwatch"></i> عروض فلاش</a></li>
                        <li><a href="{{ route('frontend.brands') }}"><i class="fa-solid fa-award"></i> العلامات
                                التجارية</a></li>
                        <li><a href="{{ route('frontend.contact') }}"><i class="fa-solid fa-headset"></i> اتصل بنا</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <nav class="elegant-nav-bar">
        <div class="container">
            <ul class="elegant-nav-list">
                <li><a href="{{ route('frontend.index') }}" class="elegant-nav-link"><i
                            class="fa-solid fa-house-chimney"></i> الرئيسية</a></li>
                
                <li class="elegant-dropdown category-dropdown">
                    <a href="javascript:void(0)" class="elegant-nav-link dropdown-toggle">
                        <i class="fa-solid fa-list-ul"></i> الفئات <i class="fa-solid fa-chevron-down ms-1" style="font-size: 10px;"></i>
                    </a>
                    <div class="elegant-dropdown-menu">
                        @foreach($main_categories as $cat)
                            <div class="elegant-dropdown-item-wrapper">
                                <a href="{{ route('frontend.products.index', ['category' => $cat->translation->slug ?? 'category']) }}" class="elegant-dropdown-item {{ $cat->children->count() > 0 ? 'has-children' : '' }}">
                                    <i class="fa-solid fa-angle-left"></i> {{ $cat->name }}
                                    @if($cat->children->count() > 0)
                                        <i class="fa-solid fa-chevron-left ms-auto child-arrow"></i>
                                    @endif
                                </a>
                                @if($cat->children->count() > 0)
                                    <div class="elegant-child-menu">
                                        <div class="elegant-child-menu-header">{{ $cat->name }}</div>
                                        @foreach($cat->children as $child)
                                            <a href="{{ route('frontend.products.index', ['category' => $child->translation->slug ?? 'category']) }}" class="elegant-child-item">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <hr class="dropdown-divider">
                        <a href="{{ route('frontend.products.index') }}" class="elegant-dropdown-item text-primary fw-bold">
                            <i class="fa-solid fa-grid-2"></i> عرض كل الأقسام
                        </a>
                    </div>
                </li>

                <li><a href="{{ route('frontend.products.index') }}" class="elegant-nav-link"><i
                            class="fa-solid fa-bag-shopping"></i> المنتجات</a></li>
                <li><a href="{{ route('frontend.products.index', ['best_seller' => 1, 'sort' => 'best_seller']) }}"
                        class="elegant-nav-link"><i class="fa-solid fa-fire-flame-curved"></i> {{ trans_db('website.Best Seller') }}</a></li>
                <li><a href="{{ route('frontend.products.index', ['sort' => 'latest']) }}" class="elegant-nav-link"><i
                            class="fa-solid fa-bolt"></i> {{ trans_db('website.New arrivals') }}</a></li>
                <li><a href="{{ route('frontend.products.index', ['flash_sale' => 1]) }}" class="elegant-nav-link"><i
                            class="fa-solid fa-stopwatch"></i> عروض فلاش</a></li>
                <li><a href="{{ route('frontend.brands') }}" class="elegant-nav-link"><i class="fa-solid fa-award"></i>
                        {{ trans_db('website.Brands') }}</a></li>
                <li><a href="{{ route('frontend.contact') }}" class="elegant-nav-link"><i
                            class="fa-solid fa-headset"></i> اتصل بنا</a></li>
            </ul>
        </div>
    </nav>
</div>