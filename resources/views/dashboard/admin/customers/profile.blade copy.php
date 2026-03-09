@extends('dashboard.admin.layouts.app')

@section('style')
  @include('dashboard.admin.layouts.style')

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
  {{-- @if(app()->getLocale() == 'en')
    {!! Html::style('admin/app-assets/vendors/css/vendors.min.css') !!}
    @yield('style1')
    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}
    {!! Html::style('admin/assets/css/style.css') !!}
  @else
    {!! Html::style('admin/app-assets/vendors/css/vendors-rtl.min.css') !!}
    {!! Html::style('admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') !!}
    {!! Html::style('admin/assets/css/style-rtl.css') !!}
    {!! Html::style('admin/app-assets/css-rtl/pages/ui-feather.css') !!}
  @endif --}}

  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
@endsection

@section('content')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Pills</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
          <div class="container">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">{{ trans_db("website.Account Details") }}</a></li>
              <li><a data-toggle="tab" href="#menu1">{{ trans_db("dashboard.orders") }}</a></li>
              <li><a data-toggle="tab" href="#menu2">{{ trans_db("website.Your Cart") }}</a></li>
              <li><a data-toggle="tab" href="#menu3">{{ trans_db("website.Addresses") }}</a></li>
              <li><a data-toggle="tab" href="#menu4">{{ trans_db("website.Wishlist") }}</a></li>
            </ul>
              
            <div class="tab-content">
              <div id="home" class="tab-pane fade in active">
                <h3>{{ trans_db("website.Account Details") }}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              </div>
              <div id="menu1" class="tab-pane fade">
                <h3>{{ trans_db("dashboard.orders") }}</h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
              <div id="menu2" class="tab-pane fade">
                <h3>{{ trans_db("dashboard.Your Cart") }}</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
              </div>
              <div id="menu3" class="tab-pane fade">
                <h3>{{ trans_db("website.Addresses") }}</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
              </div>
              <div id="menu4" class="tab-pane fade">
                <h3>{{ trans_db("website.Wishlist") }}</h3>
                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- END: Content-->

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/app-assets/js/scripts/components/components-navs.js') !!}
@endsection
