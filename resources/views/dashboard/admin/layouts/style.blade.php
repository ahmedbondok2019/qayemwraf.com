


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

    /* ========================================================
       1. GLOBAL SIDEBAR STYLES (Always Dark & Crisp)
       ======================================================== */
    .main-menu,
    .main-menu.menu-dark,
    .main-menu.menu-light {
        background-color: var(--brand-dark-brown) !important;
        border-left: 1px solid rgba(141, 123, 64, 0.25) !important;
    }

    .main-menu .navigation {
        background-color: var(--brand-dark-brown) !important;
    }

    /* Non-active menu items: Bright cream/white text for high contrast */
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a,
    .main-menu.menu-light .navigation li:not(.active):not(.sidebar-group-active) > a,
    .main-menu.menu-dark .navigation li:not(.active):not(.sidebar-group-active) > a {
        color: #f5eedc !important;
        border-radius: 10px !important;
        margin: 4px 12px !important;
        transition: all 0.25s ease-in-out !important;
    }

    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a i,
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a svg,
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a span {
        color: #f5eedc !important;
    }

    /* Hover State */
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a:hover {
        color: var(--brand-yellow-primary) !important;
        background-color: rgba(255, 222, 89, 0.12) !important;
    }

    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a:hover i,
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a:hover svg,
    .main-menu .navigation li:not(.active):not(.sidebar-group-active) > a:hover span {
        color: var(--brand-yellow-primary) !important;
    }

    /* Active Sidebar Item */
    .main-menu .navigation > li.active > a,
    .main-menu .navigation > li.sidebar-group-active > a {
        background: linear-gradient(135deg, var(--brand-yellow-primary), var(--brand-yellow-secondary)) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
        box-shadow: 0 6px 18px rgba(255, 222, 89, 0.4) !important;
        border-radius: 10px !important;
        margin: 4px 12px !important;
    }

    .main-menu .navigation > li.active > a i,
    .main-menu .navigation > li.active > a svg,
    .main-menu .navigation > li.active > a span,
    .main-menu .navigation > li.sidebar-group-active > a i,
    .main-menu .navigation > li.sidebar-group-active > a svg,
    .main-menu .navigation > li.sidebar-group-active > a span {
        color: var(--brand-dark-brown) !important;
    }

    /* Submenu active item */
    .main-menu .navigation li.has-sub .menu-content li.active a {
        background: rgba(255, 222, 89, 0.2) !important;
        color: var(--brand-yellow-primary) !important;
        font-weight: 700 !important;
    }

    /* ========================================================
       2. NAVIGATION TABS & PILLS (Header & Page Tabs)
       ======================================================== */
    .nav-pills .nav-link.active,
    .nav-tabs .nav-link.active,
    .nav .nav-link.active,
    .nav-item .nav-link.active {
        background-color: var(--brand-yellow-primary) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
        border-color: var(--brand-dark-bronze) !important;
        box-shadow: 0 4px 12px rgba(255, 222, 89, 0.3) !important;
    }

    /* ========================================================
       3. LIGHT MODE SPECIFIC STYLES (html:not(.dark-layout))
       ======================================================== */
    html:not(.dark-layout) body {
        background-color: #fcfbfa !important;
        color: var(--brand-dark-brown) !important;
        font-family: 'Tajawal', 'Cairo', sans-serif;
    }

    html:not(.dark-layout) .header-navbar {
        background-color: #ffffff !important;
        border-bottom: 2px solid var(--brand-muted-gold) !important;
        box-shadow: 0 4px 15px rgba(25, 15, 8, 0.04) !important;
    }

    html:not(.dark-layout) .header-navbar .nav-link {
        color: var(--brand-dark-brown) !important;
    }

    html:not(.dark-layout) .card {
        border-radius: 16px !important;
        border: 1px solid var(--brand-muted-gold) !important;
        box-shadow: 0 6px 20px rgba(25, 15, 8, 0.04) !important;
        background: #ffffff !important;
        color: var(--brand-dark-brown) !important;
    }

    html:not(.dark-layout) .card-header {
        border-bottom: 1px solid var(--brand-gold-soft) !important;
        padding: 1.25rem 1.5rem;
        background-color: var(--brand-light-bg) !important;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    html:not(.dark-layout) .card-title,
    html:not(.dark-layout) .card h1,
    html:not(.dark-layout) .card h2,
    html:not(.dark-layout) .card h3,
    html:not(.dark-layout) .card h4,
    html:not(.dark-layout) .card h5,
    html:not(.dark-layout) .card h6 {
        font-weight: 700 !important;
        color: var(--brand-dark-brown) !important;
    }

    html:not(.dark-layout) .card p,
    html:not(.dark-layout) .card span,
    html:not(.dark-layout) .card div,
    html:not(.dark-layout) .card label,
    html:not(.dark-layout) .card td,
    html:not(.dark-layout) .card th {
        color: #2b231d !important;
    }

    html:not(.dark-layout) .text-muted,
    html:not(.dark-layout) small,
    html:not(.dark-layout) .card small {
        color: #706253 !important;
    }

    html:not(.dark-layout) .nav-pills .nav-link:not(.active),
    html:not(.dark-layout) .nav-tabs .nav-link:not(.active) {
        color: #55493d !important;
        font-weight: 600;
    }

    html:not(.dark-layout) .table thead th {
        background-color: var(--brand-light-bg) !important;
        color: var(--brand-dark-brown) !important;
        border-bottom: 2px solid var(--brand-muted-gold) !important;
        font-weight: 700 !important;
    }

    /* ========================================================
       4. DARK MODE SPECIFIC STYLES (html.dark-layout)
       ======================================================== */
    html.dark-layout body {
        background-color: #16100c !important;
        color: #fefdf0 !important;
        font-family: 'Tajawal', 'Cairo', sans-serif;
    }

    html.dark-layout .header-navbar {
        background-color: #241a13 !important;
        border-bottom: 1px solid #3e3023 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
    }

    html.dark-layout .header-navbar .nav-link {
        color: #fefdf0 !important;
    }

    html.dark-layout .card {
        border-radius: 16px !important;
        border: 1px solid #3e3023 !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3) !important;
        background-color: #241a13 !important;
        color: #fefdf0 !important;
    }

    html.dark-layout .card-header {
        border-bottom: 1px solid #3e3023 !important;
        padding: 1.25rem 1.5rem;
        background-color: #1f1610 !important;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    html.dark-layout .card-title,
    html.dark-layout .card h1,
    html.dark-layout .card h2,
    html.dark-layout .card h3,
    html.dark-layout .card h4,
    html.dark-layout .card h5,
    html.dark-layout .card h6 {
        font-weight: 700 !important;
        color: var(--brand-yellow-primary) !important;
    }

    html.dark-layout .card p,
    html.dark-layout .card span,
    html.dark-layout .card div,
    html.dark-layout .card label,
    html.dark-layout .card td,
    html.dark-layout .card th {
        color: #f5eedc !important;
    }

    html.dark-layout .text-muted,
    html.dark-layout small,
    html.dark-layout .card small {
        color: #d6c6b4 !important;
    }

    html.dark-layout .nav-pills .nav-link:not(.active),
    html.dark-layout .nav-tabs .nav-link:not(.active) {
        color: #d6c6b4 !important;
        font-weight: 600;
    }

    html.dark-layout .table thead th {
        background-color: #1f1610 !important;
        color: var(--brand-yellow-primary) !important;
        border-bottom: 2px solid #3e3023 !important;
        font-weight: 700 !important;
    }

    html.dark-layout .apexcharts-text tspan,
    html.dark-layout .apexcharts-legend-text {
        fill: #f5eedc !important;
        color: #f5eedc !important;
    }

    /* ========================================================
       5. GENERAL BUTTONS, FORMS & BADGES
       ======================================================== */
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

    .page-item.active .page-link {
        background-color: var(--brand-yellow-primary) !important;
        border-color: var(--brand-dark-bronze) !important;
        color: var(--brand-dark-brown) !important;
        font-weight: 700 !important;
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

    /* Fix Sidebar Logo & Remove Dark Shadow Halo */
    .shadow-bottom,
    .main-menu .shadow-bottom {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        height: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .main-menu .navbar-header {
        height: 85px !important;
        padding: 0.5rem 1rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }

    .main-menu .navbar-header .navbar-brand {
        margin-right: 0 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .main-menu .navbar-header .navbar-brand img,
    .admin-logo-img {
        max-height: 65px !important;
        width: auto !important;
        max-width: 175px !important;
        object-fit: contain !important;
    }
</style>