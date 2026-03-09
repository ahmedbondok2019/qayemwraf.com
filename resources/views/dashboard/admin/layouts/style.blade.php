


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

    /* General Form Styling */
    .form-control {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        /* padding: 25px 15px; */
        transition: all 0.3s ease-in-out;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .form-control:focus {
        border-color: #67f072;
        box-shadow: 0 4px 10px rgba(115, 103, 240, 0.15);
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

    /* Card Styling */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        background: #fff;
    }

    .card-header {
        border-bottom: 1px solid #f2f2f2;
        padding: 1.5rem;
        background-color: transparent;
    }

    .card-title {
        font-weight: 700;
        color: #333;
    }

    /* Tab Styling */
    .nav-tabs .nav-link {
        border-radius: 8px 8px 0 0;
        padding: 12px 20px;
        font-weight: 600;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        color: #000000;
    }

    /* Custom Switch */
    .custom-switch .custom-control-label:before {
        height: 1.8rem;
        width: 3.5rem;
        border-radius: 20px;
    }
    .custom-switch .custom-control-label:after {
        height: 1.4rem;
        width: 1.4rem;
        border-radius: 50%;
        top: 0.2rem;
        left: 0.2rem;
    }
    .custom-switch-success .custom-control-input:checked ~ .custom-control-label::after {
        transform: translateX(1.7rem);
    }
</style>