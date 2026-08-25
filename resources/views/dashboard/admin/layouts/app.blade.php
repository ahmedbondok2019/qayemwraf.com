
<!DOCTYPE html>

<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="">
        <title>{{ trans_db('dashboard.Dashboard Title', 'Dashboard') }}</title>
        <link rel="apple-touch-icon" href="{{ asset('admin/app-assets/images/ico/apple-icon-120.png') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://unpkg.com/feather-icons"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @yield('style')

        <style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap');

            body,a{
  font-family: "Noto Kufi Arabic", sans-serif;

            }
            .navbar-header {
                height: 85px !important;
            }
            .navbar-header .admin_logo {
                width: 136px;
                position: relative;
                top: 0px;
                left: 0px;
            }
            .brand-login {
                width: 190px;
            }
           
            .main-menu.menu-light .navigation > li.active > a {
                background: #1f553f  !important;
                color: #ffffff !important;
                /* box-shadow: 0 0 10px 1px rgba(197, 160, 89, 0.7); */
            }
                .main-menu.menu-light .navigation > li.active > a span{
                    color:#fff !important;
                }
                  .main-menu.menu-light .navigation>li ul .active{
           background: linear-gradient(-118deg, #1c4dad, #1c4dad) !important;
           box-shadow: none;
        }
          .main-menu.menu-light .navigation>li ul .active span{
           color:#fff !important;
          }
          a.btn-primary{
            border-color: #1c4dad !important;
            background-color: #1c4dad !important;
          }
          .main-menu.menu-light .navigation > li.active > a{
                background: #1c4dad !important;
          }
        </style>
        @include('dashboard.admin.layouts.style')

        @livewireStyles

    </head>

    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

        @include('dashboard.admin.layouts.nav')

        <!-- BEGIN: Main Menu-->
        <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">

            @include('dashboard.admin.layouts.header')

            @include('dashboard.admin.layouts.sidebar')
        </div>
        <!-- END: Main Menu-->

        @yield('content')

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
        <!-- END: Footer-->


        @include('dashboard.admin.layouts.script')
        @yield('script')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @include('sweetalert::alert')

    </body>
</html>

