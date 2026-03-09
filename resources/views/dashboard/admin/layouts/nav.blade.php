@php
    $arabic = ['ar'];
    $userData = \App\Models\Admin::find(auth('admin')->id());
    $unreadCount = $userData ? $userData->unreadNotifications->count() : 0;
@endphp


<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="javascript:void(0);">
                        <i class="ficon" data-feather="menu"></i>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav bookmark-icons">
                <li class="nav-item d-none d-lg-block">
                    {{-- <a class="nav-link btn btn-lg btn-warning p-1" href="{{ \LaravelLocalization::localizeUrl('/') }}">{{ trans_db("dashboard.View Store") }}</a> --}}
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-notification me-25">
                <a class="nav-link" id="admin-notification" href="#" data-bs-toggle="dropdown">
                    <i data-feather='bell'></i>
                    <span class="badge rounded-pill bg-danger badge-up">
                        {{ $unreadCount }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end" id="dropdown-menu-media">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">{{ trans_db('dashboard.Notifications') }}</h4>
                            <div class="badge rounded-pill badge-light-primary">&nbsp; {{ $unreadCount }} {{ trans_db('dashboard.New') }} &nbsp;</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        @if($userData && $userData->notifications->count() > 0)
                            @foreach ($userData->notifications as $notification)
                                <a class="d-flex" href="{{ $notification->data['url'] ?? '#' }}" style="{{ $notification->read_at ? 'background-color: #f8f8f8;' : '' }}">
                                    <div class="list-item d-flex align-items-start m-1">
                                        <div class="me-1">
                                            <div class="avatar">
                                                @if(isset($notification->data['image']) && $notification->data['image'])
                                                    <img src="{{ asset('website/images/products/thumb/' . $notification->data['image']) }}" alt="avatar" width="32" height="32">
                                                @else
                                                    <div class="avatar-content"><i class="ficon" data-feather="shopping-cart"></i></div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="list-item-body pr-1 pl-1 flex-grow-1">
                                            <p class="media-heading" style="font-size: 14px; font-weight: {{ $notification->read_at ? 'normal' : 'bold' }}">
                                                {{ $notification->data['title'] ?? "" }}
                                            </p>
                                            <small class="notification-text">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="p-2 text-center text-muted">{{ trans_db('dashboard.No notifications') }}</div>
                        @endif
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown dropdown-language">
                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-{{ \App\Http\Controllers\helper\HelperController::getFlags(app()->getLocale()) }}"></i>
                    <span class="selected-language">{{ \App\Http\Controllers\WelcomeController::getLangWord() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a data-language="{{ \App\Http\Controllers\helper\HelperController::getFlags($localeCode) }}" class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <i class="flag-icon flag-icon-{{ \App\Http\Controllers\helper\HelperController::getFlags($localeCode) }}"></i>
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item d-lg-block">
                <a class="nav-link nav-link-style">
                    {{-- <i class="ficon" data-feather="moon"></i>--}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon ficon">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </a>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">
                           
                        </span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="{{ asset('website/user/User-Profile.png') }}" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="mr-50" data-feather="user"></i> {{ trans_db('dashboard.Profile') }}
                    </a>
              

                    <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="mr-50" data-feather="power"></i> {{ trans_db('dashboard.Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="post" class="d-none">@csrf</form>

                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    const dropdownBtn = document.getElementById("admin-notification");
    const dropdownMenu = document.getElementById("dropdown-menu-media");

    // Function to show or hide the dropdown menu
    function toggleDropdownMenu(show) {
    if (show) {
        dropdownMenu.classList.add("show"); // Add the "show" class for visibility
    } else {
        dropdownMenu.classList.remove("show"); // Remove the "show" class to hide
    }
    }


    // Event listener for click
    if (dropdownBtn) {
        dropdownBtn.addEventListener("click", () => {
            // Toggle the visibility on click
            toggleDropdownMenu(!dropdownMenu.classList.contains("show"));

            // Prepare AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ route('admin.users.mark_as_read') }}"); // Replace with your actual route
            xhr.setRequestHeader('Content-Type', 'application/json'); // Set request header for JSON data

            // Function to handle response
            xhr.onload = function() {
                if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response); // Handle successful response (e.g., display message)
                } else {
                console.error(xhr.statusText); // Handle error
                }
            };

            // Send AJAX request with data
            xhr.send(JSON.stringify({ name: name }));
        });
    }

</script>