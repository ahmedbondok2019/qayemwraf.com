            <div class="profile-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        @if(Auth::user()->image)
                        <img src="{{ Auth::user()->image }}" alt="{{ Auth::user()->name }}">
                        @else
                        <div class="avatar-placeholder">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                
                <ul class="profile-menu">
                    <li class="{{ request()->routeIs('frontend.user.home') ? 'active' : '' }}">
                        <a href="{{ route('frontend.user.home') }}">
                            <i class="fa-solid fa-user"></i> {{ trans_db('frontend.Profile') }}
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('frontend.user.orders.index') ? 'active' : '' }}">
                        <a href="{{ route('frontend.user.orders.index') }}">
                            <i class="fa-solid fa-box-open"></i> {{ trans_db('frontend.My Orders') }}
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('frontend.user.addresses.index') ? 'active' : '' }}">
                        <a href="{{ route('frontend.user.addresses.index') }}">
                            <i class="fa-solid fa-location-dot"></i> {{ trans_db('frontend.Addresses') }}
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('frontend.user.notifications.index') ? 'active' : '' }}">
                        <a href="{{ route('frontend.user.notifications.index') }}">
                            <i class="fa-solid fa-bell"></i> {{ trans_db('frontend.Notifications') }}
                        </a>
                    </li>
                    @if(Auth::user()->gift_page_enabled)
                    <li class="{{ request()->routeIs('frontend.user.gifts.index') ? 'active' : '' }}">
                        <a href="{{ route('frontend.user.gifts.index') }}">
                            <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.Gifts') }}
                        </a>
                    </li>
                    @endif
                    <!-- Add more links here later like orders, wishlist etc -->
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> {{ trans_db('frontend.Logout') }}
                        </a>
                    </li>
                </ul>
            </div>
