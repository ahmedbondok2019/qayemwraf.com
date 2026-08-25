
@php($arabic = ['ar'])

<div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item mr-auto">
            <a class="navbar-brand" href="{{ \LaravelLocalization::localizeUrl('admin-2026/home') }}">
                @if(isset($Setting) && $Setting->logo)
                    <img src="{{ asset($Setting->logo) }}" class="img-fluid admin-logo-img" style="max-height: 65px; width: auto; max-width: 175px; object-fit: contain;" alt="{{ $Setting->translate('app_name') }}" />
                @else
                    <img src="{{ asset('_fixed/logo.png') }}" class="img-fluid admin-logo-img" style="max-height: 65px; width: auto; max-width: 175px; object-fit: contain;" alt="QayemWraf" />
                @endif
            </a>
        </li>
        <li class="nav-item nav-toggle">
            <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
            </a>
        </li>
    </ul>
</div>





