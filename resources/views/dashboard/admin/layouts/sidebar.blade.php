@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    use App\Models\GroupPermission;
    use App\Models\Permission;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp
<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">{{ trans_db('dashboard.Dashboard') }}</span><i
                data-feather="more-horizontal"></i></li>
         
        <li class="nav-item {{ Request::routeIs('admin.home') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}"><i data-feather="home"></i><span
             class="menu-title text-truncate" data-i18n="Home">{{ trans_db('dashboard.Home') }}</span></a>
        </li>

        <li class="nav-item {{ Request::routeIs('admin.static_translations.*') ? 'active' : '' }}">
            <a href="{{ route('admin.static_translations.index') }}"><i data-feather="type"></i><span
             class="menu-title text-truncate" data-i18n="Translations">{{ trans_db('dashboard.static_translations') }}</span></a>
        </li>

        @if (auth('admin')->check())
            @php
                $user_pers = GroupPermission::where('group_id', auth('admin')->user()->permission_group)->pluck('permission_id');
                $permissionss = Permission::whereIn('id', $user_pers)->where('status', 1)->get();
                $groups = $permissionss->groupBy('group_permission');
                
                $groupIcons = [
                    'UsersManagement' => 'users',
                    'General' => 'layers',
                    'Location' => 'map-pin',
                    'Products' => 'box',
                    'Offers' => 'zap',
                    'Orders' => 'shopping-cart',
                    'Marketing' => 'monitor',
                    'Shipping' => 'truck',
                    'Settings' => 'settings',
                ];
            @endphp

            @foreach ($groups as $groupName => $items)
                @php
                    $isGroupActive = false;
                    foreach($items as $item) {
                        if (Request::segment(3) == $item->parent_permission) {
                            $isGroupActive = true;
                            break;
                        }
                    }
                @endphp
                
                <li class="nav-item has-sub {{ $isGroupActive ? 'sidebar-group-active open' : '' }}">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather="{{ $groupIcons[$groupName] ?? 'grid' }}"></i>
                        <span class="menu-title text-truncate" data-i18n="{{ $groupName }}">
                            {{ trans_db('dashboard.' . $groupName) }}
                        </span>
                    </a>
                    <ul class="menu-content">
                        @php
                            $renderedNames = [];
                        @endphp
                        @foreach ($items as $item)
                            @php
                                $baseName = $item->parent_permission;
                                if (in_array($baseName, $renderedNames)) continue;
                                $renderedNames[] = $baseName;
                                
                                $routeName = 'admin.' . $baseName . '.index';
                                if (!Route::has($routeName)) {
                                    $routeName = 'admin.' . $baseName; // Try without .index
                                }
                                
                                $isActive = Request::segment(3) == $baseName;
                            @endphp
                            
                            @if(Route::has($routeName))
                            <li class="{{ $isActive ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route($routeName) }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{ trans_db('dashboard.' . $baseName) }}</span>
                                </a>
                            </li>
                            @endif
                            
                            @if($baseName == 'products')
                            <li class="{{ Request::routeIs('admin.products.stock.*') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('admin.products.stock.index') }}">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">{{ trans_db('dashboard.Stock Update') }}</span>
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        @endif

        <br><br><br><br>
    </ul>
</div>
