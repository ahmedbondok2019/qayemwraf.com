


@if (app()->getLocale() == 'en')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
    @yield('style1')
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.min.css') }}"> --}}
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    @yield('style2')
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/charts/chart-apex.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/extensions/ext-component-toastr.css') }}"> --}}

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- END: Custom CSS-->
@else
    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/vendors-rtl.min.css') }}">
    @yield('style1')
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.min.css') }}"> --}}
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/themes/dark-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/themes/bordered-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    @yield('style2')
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/charts/chart-apex.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/extensions/ext-component-toastr.css') }}"> --}}

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/custom-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style-rtl.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/pages/ui-feather.css') }}">
    <!-- END: Custom CSS-->
@endif
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
    @font-face {
        font-family: 'Tajawal', sans-serif;
        src: url('website/Tajwal/Tajawal-Medium') format('ttf');
    }

    :root {
        --brand-yellow-primary: #ffde59;
        --brand-yellow-secondary: #fce150;
        --brand-gold-accent: #f8de69;
        --brand-gold-soft: #f1dd7f;
        --brand-light-bg: #fefdf0;
        --brand-muted-gold: #eddd99;
        --brand-dark-bronze: #8d7b40;
        --brand-dark-brown: #190f08;
    }

    /* Core Admin Theme Overrides */
    body {
        background-color: #fcfbfa !important;
        color: var(--brand-dark-brown) !important;
        font-family: 'Tajawal', 'Cairo', sans-serif;
    }

    /* Navbar & Header */
    .header-navbar {
        background-color: #ffffff !important;
        border-bottom: 2px solid var(--brand-muted-gold) !important;
        box-shadow: 0 4px 15px rgba(25, 15, 8, 0.04) !important;
    }

    .header-navbar .nav-link {
        color: var(--brand-dark-brown) !important;
    }

    .header-navbar .nav-link:hover {
        color: var(--brand-dark-bronze) !important;
    }

    /* Sidebar Navigation */
    .main-menu {
        background-color: var(--brand-dark-brown) !important;
        border-left: 1px solid rgba(141, 123, 64, 0.2);
    }

    .main-menu .navigation {
        background-color: var(--brand-dark-brown) !important;
    }

    .main-menu .navigation li a {
        color: #e2d9cc !important;
        border-radius: 10px !important;
        margin: 4px 12px !important;
        transition: all 0.25s ease-in-out !important;
    }

    .main-menu .navigation li a:hover {
        color: var(--brand-yellow-primary) !important;
        background-color: rgba(255, 222, 89, 0.1) !important;
    }

    .main-menu .navigation > li.active > a,
    .main-menu .navigation > li.sidebar-group-active > a {
        background: linear-gradient(135deg, var(--brand-yellow-primary), var(--brand-yellow-secondary)) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
        box-shadow: 0 6px 18px rgba(255, 222, 89, 0.4) !important;
    }

    .main-menu .navigation > li.active > a i,
    .main-menu .navigation > li.active > a svg,
    .main-menu .navigation > li.sidebar-group-active > a i,
    .main-menu .navigation > li.sidebar-group-active > a svg {
        color: var(--brand-dark-brown) !important;
    }

    .main-menu .navigation li.has-sub .menu-content li.active a {
        background: rgba(255, 222, 89, 0.15) !important;
        color: var(--brand-yellow-primary) !important;
        font-weight: 700 !important;
    }

    /* General Form Styling */
    .form-control {
        border-radius: 12px;
        border: 1px solid var(--brand-muted-gold);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .form-control:focus {
        border-color: var(--brand-dark-bronze) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 222, 89, 0.3) !important;
    }

    /* Buttons Styling */
    .btn {
        border-radius: 10px !important;
        padding: 10px 24px;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.12);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--brand-yellow-primary), var(--brand-yellow-secondary)) !important;
        border-color: var(--brand-dark-bronze) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(255, 222, 89, 0.35) !important;
    }

    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
        background: linear-gradient(135deg, var(--brand-yellow-secondary), var(--brand-gold-accent)) !important;
        border-color: var(--brand-dark-brown) !important;
        color: var(--brand-dark-brown) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 222, 89, 0.5) !important;
    }

    .btn-outline-primary {
        border-color: var(--brand-dark-bronze) !important;
        color: var(--brand-dark-brown) !important;
    }

    .btn-outline-primary:hover {
        background-color: var(--brand-yellow-primary) !important;
        color: var(--brand-dark-brown) !important;
    }

    /* Badges & Text */
    .badge-primary, .bg-primary {
        background-color: var(--brand-yellow-primary) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
    }

    .badge-light-primary {
        background-color: var(--brand-light-bg) !important;
        color: var(--brand-dark-bronze) !important;
        border: 1px solid var(--brand-muted-gold) !important;
    }

    .text-primary {
        color: var(--brand-dark-bronze) !important;
    }

    /* Card Styling */
    .card {
        border-radius: 16px !important;
        border: 1px solid var(--brand-muted-gold) !important;
        box-shadow: 0 6px 20px rgba(25, 15, 8, 0.04) !important;
        background: #ffffff !important;
    }

    .card-header {
        border-bottom: 1px solid var(--brand-gold-soft) !important;
        padding: 1.5rem;
        background-color: var(--brand-light-bg) !important;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .card-title {
        font-weight: 700 !important;
        color: var(--brand-dark-brown) !important;
    }

    .table thead th {
        background-color: var(--brand-light-bg) !important;
        color: var(--brand-dark-brown) !important;
        border-bottom: 2px solid var(--brand-muted-gold) !important;
        font-weight: 700 !important;
    }

    .page-item.active .page-link {
        background-color: var(--brand-yellow-primary) !important;
        border-color: var(--brand-dark-bronze) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
    }

    /* Tab Styling */
    .nav-tabs .nav-link {
        border-radius: 8px 8px 0 0;
        padding: 12px 20px;
        font-weight: 600;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--brand-yellow-primary);
        border-color: var(--brand-dark-bronze) var(--brand-dark-bronze) #fff;
        color: var(--brand-dark-brown);
        font-weight: 700;
    }

    /* Custom Switch */
    .custom-switch .custom-control-label::before {
        height: 1.8rem;
        width: 3.5rem;
        border-radius: 20px;
    }
    .custom-switch .custom-control-label::after {
        height: 1.4rem;
        width: 1.4rem;
        border-radius: 50%;
        top: 0.2rem;
        transition: transform 0.2s ease-in-out, background-color 0.15s ease-in-out;
    }

    @if (app()->getLocale() == 'ar')
        .custom-switch {
            padding-right: 3.5rem;
            padding-left: 0;
        }
        .custom-switch .custom-control-label {
            padding-right: 0;
            padding-left: 0;
        }
        .custom-switch .custom-control-label::before {
            right: -3.5rem;
            left: auto;
        }
        .custom-switch .custom-control-label::after {
            right: calc(-3.5rem + 0.2rem);
            left: auto;
        }
        .custom-switch .custom-control-input:checked ~ .custom-control-label::after,
        .custom-switch-success .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(-1.7rem) !important;
        }
    @else
        .custom-switch .custom-control-label::after {
            left: 0.2rem;
            right: auto;
        }
        .custom-switch .custom-control-input:checked ~ .custom-control-label::after,
        .custom-switch-success .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(1.7rem) !important;
        }
    @endif
</style>