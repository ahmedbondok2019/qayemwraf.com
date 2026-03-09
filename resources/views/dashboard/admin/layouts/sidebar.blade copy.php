

    <?php

        if (auth()->check()) {
            $user_pers = \App\Models\GroupPermission::where('group_id', \Illuminate\Support\Facades\Auth::user()->permission_group)->pluck('permission_id');
            $permissionss = \App\Models\Permission::whereIn('id', $user_pers)->get();
            $groups = $permissionss->groupBy('parent_permission');

            $permissions = [];
            $permissionNames = [];

            foreach ($groups as $key => $group) {
                echo '<h1>'.$key.'</h1>';
                foreach ($group as $i => $items) {
                    $permissions[] = $items['name'];

                    if (str_contains($items['name'], '_read')) {
                        $fullNames = str_replace('_read', '', $items['name']);
                    }
                    if (str_contains($items['name'], '_create')) {
                        $fullNames = str_replace('_create', '', $items['name']);
                    }
                    if (str_contains($items['name'], '_update')) {
                        $fullNames = str_replace('_update', '', $items['name']);
                    }
                    if (str_contains($items['name'], '_delete')) {
                        $fullNames = str_replace('_delete', '', $items['name']);
                    }
                    if (! in_array($fullNames, $permissionNames)) {
                        $permissionNames[] = $fullNames;
                        echo '<h4>'.$fullNames.'</h4>';
                    }
                }
            }

        }

    if (auth()->check()) {
        $user_per = \App\Models\GroupPermission::where('group_id', \Illuminate\Support\Facades\Auth::user()->permission_group)->get();
        $permission = [];
        $permissionName = [];

        if (isset($user_per)) {
            foreach ($user_per as $per) {
                $permissions = \App\Models\Permission::where('id', $per->permission_id)->pluck('id');
                if (isset($permissions[0])) {
                    $permission[] = $permissions[0];
                    $Names = \App\Models\Permission::where('id', $per->permission_id)->select('name')->first();

                    if (str_contains($Names->name, '_read')) {
                        $fullName = str_replace('_read', '', $Names->name);
                    }
                    if (str_contains($Names->name, '_create')) {
                        $fullName = str_replace('_create', '', $Names->name);
                    }
                    if (str_contains($Names->name, '_update')) {
                        $fullName = str_replace('_update', '', $Names->name);
                    }
                    if (str_contains($Names->name, '_delete')) {
                        $fullName = str_replace('_delete', '', $Names->name);
                    }

                    if (! in_array($fullName, $permissionName)) {
                        $permissionName[] = $fullName;
                    }

                    // $fullName = explode('_', $Names->name);
                    // if(isset($fullName[2]) && !in_array($fullName[0] . '_' . $fullName[1] , $permissionName)){
                    //     $permissionName[] = $fullName[0] . '_' . $fullName[1];
                    // }
                    // else if ($fullName[0] != null && !in_array($fullName[0] , $permissionName)) {
                    //     $permissionName[] = $fullName[0];
                    // }
                }
            }
        }

        $url = Request::fullUrl();
        $admin = explode('admin-2023', $url);
        if (isset($admin[1])) {
            $permissionUrl = explode('/', $admin[1]);
        }
    } else {
        $permission = [];
    }

    ?>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">{{ trans_db('dashboard.Dashboard') }}</span><i data-feather="more-horizontal"></i></li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/home') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Home">{{ trans_db('website.home') }}</span></a></li>

            @foreach ($permissionName as $key => $value)
                @if ($value == 'languages')
                    <li class="@if(request()->is("en/admin-2023/languages")) active @endif nav-item">
                        <a class="d-flex align-items-center" href="{{ url("ar/admin-2023/languages") }}" target="_blank">
                            <i data-feather="target"></i>
                            <span class="menu-title text-truncate" data-i18n="Chat">{{ trans_db('dashboard.' . $value) }}</span>
                        </a>
                    </li>
                @else
                    <li class="@if(request()->is(\LaravelLocalization::localizeUrl('/admin-2023/' . $value . '/all'))) active @endif nav-item">
                        <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('/admin-2023/' . $value . '/all') }}">
                            <i data-feather="target"></i>
                            <span class="menu-title text-truncate">{{ trans_db('dashboard.' . $value) }}</span>
                        </a>
                    </li>
                @endif
                
            @endforeach

            {{-- @if (in_array('10', $permission) || in_array('11', $permission) || in_array('12', $permission) || in_array('13', $permission))
                @php
                    $urlToOpen = array(
                        request()->is(app()->getLocale() . '/admin-2023/users/admin'),
                        request()->is(app()->getLocale() . '/admin-2023/users/customer'),
                        request()->is(app()->getLocale() . '/admin-2023/vendors/all'),
                        request()->is(app()->getLocale() . '/admin-2023/users/permission')
                    );
                @endphp

            <li class="nav-item has-sub @if(in_array(request() , $urlToOpen)) open @endif">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="user"></i>
                    <span class="menu-title text-truncate" data-i18n="User">{{ trans_db('dashboard.accounts') }}</span>
                </a>
                <ul class="menu-content">
                    <li class="@if(request()->is(app()->getLocale() . '/admin-2023/users/admin')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/users/admin') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">{{ trans_db('dashboard.users') }}</span></a></li>
                    <li class="@if(request()->is(app()->getLocale() . '/admin-2023/users/customer')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/users/customer') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">{{ trans_db('dashboard.Customer') }}</span></a></li>
                    <li class="@if(request()->is(app()->getLocale() . '/admin-2023/vendors/all')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/all') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">{{ trans_db('dashboard.Vendors') }}</span></a></li>
                    <li class="@if(request()->is(app()->getLocale() . '/admin-2023/users/permission')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/users/permission') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">{{ trans_db('dashboard.Permission') }}</span></a></li>
                </ul>
            </li>
            @endif


            @if (in_array('40', $permission) || in_array('41', $permission) || in_array('42', $permission) || in_array('43', $permission))
            <li class="@if(request()->is(app()->getLocale() . '/admin-2023/category/all')) active @endif nav-item">
                <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/category/all') }}">
                    <i data-feather="target"></i>
                    <span class="menu-title text-truncate" data-i18n="Chat">{{ trans_db('dashboard.Category') }}</span>
                </a>
            </li>
            @endif

            @if (in_array('20', $permission) || in_array('21', $permission) || in_array('22', $permission) || in_array('23', $permission))
            <li class="@if(request()->is(app()->getLocale() . '/admin-2023/products/all')) active @endif nav-item">
                <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/products/all') }}">
                    <i data-feather='shopping-cart'></i>
                    <span class="menu-title text-truncate" data-i18n="Chat">{{ trans_db('dashboard.Products') }}</span>
                </a>
            </li>
            @endif

            @if (in_array('24', $permission) || in_array('25', $permission) || in_array('26', $permission) || in_array('27', $permission))
                @php
                    $urlToOpen = array(
                        request()->is(app()->getLocale() . '/admin-2023/balance/users'),
                        request()->is(app()->getLocale() . '/admin-2023/balance/vendors')
                    );
                @endphp

                <li class="nav-item has-sub @if(in_array(request() , $urlToOpen)) open @endif">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='credit-card'></i>
                        <span class="menu-title text-truncate" data-i18n="Card">{{ trans_db('dashboard.balance') }}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="@if(request()->is(app()->getLocale() . '/admin-2023/balance/users')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/balance/users') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">{{ trans_db('dashboard.Customer') }}</span></a></li>
                        <li class="@if(request()->is(app()->getLocale() . '/admin-2023/balance/vendors')) active @endif"><a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/balance/vendors') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">{{ trans_db('dashboard.Vendors') }}</span></a></li>
                    </ul>
                </li>
            @endif

            @if (in_array('28', $permission) || in_array('29', $permission) || in_array('30', $permission) || in_array('31', $permission))
            <li class="@if(request()->is(app()->getLocale() . '/admin-2023/sliders/all')) active @endif nav-item">
                <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/sliders/all') }}">
                    <i data-feather="layers"></i>
                    <span class="menu-title text-truncate" data-i18n="Todo">{{ trans_db('dashboard.sliders') }}</span>
                </a>
            </li>
            @endif --}}




{{--            @if (in_array('36', $permission) || in_array('37', $permission) || in_array('38', $permission) || in_array('39', $permission))--}}
{{--                <li class=" nav-item">--}}
{{--                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/coupons/all') }}">--}}
{{--                        <i data-feather="percent"></i>--}}
{{--                        <span class="menu-title text-truncate" data-i18n="Todo">Coupons</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

            {{-- @if (in_array('7', $permission))
                <li class="@if(request()->is(app()->getLocale() . '/admin-2023/settings/index')) active @endif nav-item">
                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/settings/index') }}">
                        <i data-feather="settings"></i>
                        <span class="menu-title text-truncate" data-i18n="File Manager">{{ trans_db('dashboard.Setting') }}</span>
                    </a>
                </li>
            @endif --}}



{{--            @if (in_array('32', $permission) || in_array('33', $permission) || in_array('34', $permission) || in_array('35', $permission) || \Illuminate\Support\Facades\Auth::user()->admin_type == '2')--}}
{{--                <li class=" nav-item">--}}
{{--                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/appointments/all') }}">--}}
{{--                        <i data-feather="calendar"></i>--}}
{{--                        <span class="menu-title text-truncate" data-i18n="Calendar">Appointment System </span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            @if (in_array('44', $permission) || in_array('45', $permission) || in_array('46', $permission) || in_array('47', $permission))--}}
{{--                <li class=" nav-item">--}}
{{--                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/invoices/all') }}">--}}
{{--                        <i data-feather="printer"></i>--}}
{{--                        <span class="menu-title text-truncate" data-i18n="Calendar">Invoices System </span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

            {{-- @if (in_array('52', $permission) || in_array('53', $permission) || in_array('54', $permission) || in_array('55', $permission))
                <li class="@if(request()->is(app()->getLocale() . '/admin-2023/page/all')) active @endif nav-item">
                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/page/all') }}">
                        <i data-feather='file-text'></i>
                        <span class="menu-title text-truncate" data-i18n="Pages">{{ trans_db('dashboard.Page') }} </span>
                    </a>
                </li>
            @endif

            @if (in_array('6', $permission))
                <li class="@if(request()->is(app()->getLocale() . '/admin-2023/Customer/all')) active @endif nav-item">
                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/Customer/all') }}">
                        <i data-feather='users'></i>
                        <span class="menu-title text-truncate" data-i18n="Pages">{{ trans_db('dashboard.Support') }} </span>
                    </a>
                </li>
            @endif

            @if (in_array('48', $permission))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/languages') }}">
                        <i data-feather="printer"></i>
                        <span class="menu-title text-truncate" data-i18n="Calendar">{{ trans_db('dashboard.languages') }} </span>
                    </a>
                </li>
            @endif --}}

            {{-- @if (in_array('8', $permission))
                @php
                    $urlToOpen = array(
                        request()->is(app()->getLocale() . '/admin-2023/reports/orders'),
                    );
                @endphp

                <li class="nav-item has-sub @if(in_array(request() , $urlToOpen)) open @endif">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="file-text"></i>
                        <span class="menu-title text-truncate" data-i18n="Pages">{{ trans_db('dashboard.reports') }}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="@if(request()->is(app()->getLocale() . '/admin-2023/reports/orders')) active @endif nav-item">
                            <a class="d-flex align-items-center" href="{{ \LaravelLocalization::localizeUrl('admin-2023/reports/orders') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 576 512" fill="currentColor"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 24V80H168c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h56v56c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V176h56c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H320V24c0-13.3-10.7-24-24-24H248c-13.3 0-24 10.7-24 24zM559.7 392.2c17.8-13.1 21.6-38.1 8.5-55.9s-38.1-21.6-55.9-8.5L392.6 416H272c-8.8 0-16-7.2-16-16s7.2-16 16-16h16 64c17.7 0 32-14.3 32-32s-14.3-32-32-32H288 272 193.7c-29.1 0-57.3 9.9-80 28L68.8 384H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H192 352.5c29 0 57.3-9.3 80.7-26.5l126.6-93.3zm-367-8.2l.9 0 0 0c-.3 0-.6 0-.9 0z"/></svg>
                                <span class="menu-item text-truncate" data-i18n="Account Settings">
                                {{ trans_db('dashboard.Orders') }}
                            </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif --}}

            <br>
            <br>
            <br>
            <br>
        </ul>
    </div>
