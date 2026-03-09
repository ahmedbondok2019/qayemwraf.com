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
                        <h2 class="content-header-title float-start mb-0">{{ trans_db("dashboard.profile") }} : {{ $Details->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
          <div class="container">
            <ul class="nav nav-tabs">
              <li><a class="btn btn-md btn-warning m-1 tab-header" id="details">{{ trans_db("website.Account Details") }}</a></li>
              <li><a class="btn btn-md btn-warning m-1 tab-header" id="orders">{{ trans_db("dashboard.orders") }}</a></li>
              <li><a class="btn btn-md btn-warning m-1 tab-header" id="cart">{{ trans_db("website.Your Cart") }}</a></li>
              <li><a class="btn btn-md btn-warning m-1 tab-header" id="addresses">{{ trans_db("website.Addresses") }}</a></li>
              <li><a class="btn btn-md btn-warning m-1 tab-header" id="wishlist">{{ trans_db('website.Favorite') }}</a></li>
            </ul>
            <div class="tab-content">
              <div id="details_content" class="all_content">
                <h3>{{ trans_db("website.Account Details") }}</h3>
                <div class="row pt-2">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ trans_db('website.enter your name') }}</label>
                      <input class="form-control" value="{{ $Details->name }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ trans_db('website.enter your email') }}</label>
                      <input class="form-control" placeholder="{{ trans_db('website.enter your email') }}" name="email" type="email" value="{{ $Details->email }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ trans_db("website.Phone") }}</label>
                      <input class="form-control email" name="phone" type="text" value="{{ $Details->phone }}">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <div class="row">
                        <div class="col-md-9 pb10">
                          <h5 class="title">{{ trans_db("website.SMS") }}</h5>
                          <p>{{ trans_db("website.Messages to be sent by Website to your mobile phone via SMS method") }}</p>
                        </div>
                        <div class="col-md-3 switch shortcode_widget_switch">
                          <div class="ui_kit_whitchbox">
                            <div class="form-check form-switch mb10">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @if($Details->permission_sms == 1) checked @endif value="1" name="permission_sms">
                              <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <div class="row">
                        <div class="col-md-9 pb10">
                          <h5 class="title">{{ trans_db("website.Email") }}</h5>
                          <p>{{ trans_db("website.Messages to be sent by Website to your mobile phone via Email method") }}</p>
                        </div>
                        <div class="col-md-3 switch shortcode_widget_switch">
                          <div class="ui_kit_whitchbox">
                            <div class="form-check form-switch mb10">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2" @if($Details->permission_email == 1) checked @endif value="1" name="permission_email">
                              <label class="form-check-label" for="flexSwitchCheckDefault2"></label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group mb-4">
                      <div class="row">
                        <div class="col-md-9 pb10">
                          <h5 class="title">{{ trans_db("website.Phone Call") }}</h5>
                          <p>{{ trans_db("website.Messages to be sent by Website to your mobile phone via Phone Call method") }}</p>
                        </div>
                        <div class="col-md-3 switch shortcode_widget_switch">
                          <div class="ui_kit_whitchbox">
                            <div class="form-check form-switch mb10">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault3" @if($Details->permission_phone_call == 1) checked @endif value="1" name="permission_phone_call">
                              <label class="form-check-label" for="flexSwitchCheckDefault3"></label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>  
                  </div>
                </div>
              </div>

              <div id="orders_content" class="all_content">
                <h3>{{ trans_db("dashboard.orders") }}</h3>
                <div class="order_table table-responsive">
                  <table class="table">
                    <thead class="table-light">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col"> {{ trans_db('dashboard.Name') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.Total') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.area') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.Status') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.Payment_status') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.Update') }} </th>
                        <th scope="col"> {{ trans_db('dashboard.delete') }} </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)            
                        <tr id="tr{{ $order->id }}">
                          @php
                            $area = \App\Models\Area::where('id' , $order->area)->first();
                          @endphp
                          <td scope="row"><a href="#">{{ $order->id }}</a></td>
                          <td><a href="#">{{ optional(\App\Models\User::find($order->user_id))->name }}</a></td>
                          <td><a href="#">{{ $order->total }}</a></td>
                          <td><a href="#">{{ optional(optional($area)->translations()->first())->title }}</a></td>
                          <td>
                            <a href="#" class="{{ \App\Http\Controllers\helper\HelperController::orderStatus($order->status)[1] }}">
                              {{ \App\Http\Controllers\helper\HelperController::orderStatus($order->status)[0] }}
                            </a>
                          </td>
                          <td><a href="#">{{ $order->payment_status == 1 ? trans_db("dashboard.paid") : trans_db("dashboard.not paid") }}</a></td>
                          <td class="action">
                            <a class="btn btn-sm btn-success" href="{{ \LaravelLocalization::localizeUrl('user/order/' . $order->id) }}">
                              {{ trans_db('dashboard.View') }}
                            </a>
                          </td>
                          <td class=""><span class="flaticon-close delete_order" data-id="{{ $order->id }}"></span></td>
                        </tr>
                      @endforeach                          
                    </tbody>
                  </table>
                </div>
              </div>

              <div id="cart_content" class="all_content">
                <h3>{{ trans_db("website.Your Cart") }}</h3>
                <div class="row mt15">
                    <div class="col-lg-8 col-xl-9">
                      <div class="shopping_cart_table table-responsive">
                        <table class="table table-borderless">
                          <thead>
                            <tr>
                              <th scope="col">{{ trans_db("dashboard.Image") }}</th>
                              <th scope="col">{{ trans_db("dashboard.product Name") }}</th>
                              <th scope="col">{{ trans_db("dashboard.Price") }}</th>
                              {{-- <th scope="col">{{ trans_db("dashboard.tax") }}</th> --}}
                              <th scope="col">{{ trans_db("dashboard.Quantity") }}</th>
                              <th scope="col">{{ trans_db("website.Total") }}</th>
                            </tr>
                          </thead>
                          <tbody class="table_body">
                            @foreach ($cart as $item)
                              @php
                                $optionId = \App\Models\CartOption::where('cart_id', $item->id)->where('product_id', $item->product_id)->first();
                                $cartOption = $optionId == null ? null : $optionId->option_item_id;
                                $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy($item->product_id , $cartOption);
                              @endphp
                              @if ($ProQty != null)
                                <tr id="tr{{ $item->id }}">
                                  <td>
                                    <a href="{{ \LaravelLocalization::localizeUrl('/product/' . intval($item->product_id) . '/' . \App\Http\Controllers\helper\HelperController::make_slug($item->product->translations->title)) }}">
                                      <img src="{{ asset('website/images/products/' . $item->product->translations->primary_image ) }}" alt="{{ $item->product->translations->title }}" style="width: 100px;height: 100px">
                                    </a>
                                  </td>
                                  <td>
                                    <a class="cart_title" href="{{ \LaravelLocalization::localizeUrl('/product/' . intval($item->product_id) . '/' . \App\Http\Controllers\helper\HelperController::make_slug($item->product->translations->title)) }}">
                                        <span class="fz16">{{ $item->product->translations->title }}</span>
                                    </a>
                                  </td>
                                  <td>
                                    <span id="price{{ $item->id }}">{{ $item->price * $rate }}</span>
                                  </td>
                                  <td>
                                  <div class="cart_btn">
                                    <div class="quantity-block">
                                      <input class="quantity-num inner_page" id="quantity-num_{{ $item->id }}" type="number" value="{{ $item->quantity }}" name="quantity{{ $item->id }}" data-id="{{ $item->id }}" disabled/>
                                    </div>
                                  </div>
                                  </td>
                                  <td><span id="subrow{{ $item->id }}">{{ $item->price * $item->quantity * $rate }}</span></td>
                                </tr>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                      <div class="order_sidebar_widget style2">
                        <h4 class="title">{{ trans_db("website.Total") }}</h4>
                        <ul>
                          <li class="subtitle" style="list-style: none">
                            <p>{{ trans_db("dashboard.TotalOrder") }} <span class="float-end subtotal-all">{{ $prices }}</span></p>
                          </li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
              <div id="addresses_content" class="all_content">
                <h3>{{ trans_db("website.Addresses") }}</h3>

                <div class="row">
                  @foreach ($user->address as $address)
                    <div class="col-md-6">
                      <div class="form-group m-2">
                        <h4 class="p-1">{{ $address->address }}</h4>
                        <p>{{ trans_db("website.Name") }} : {{ $address->name }}</p>
                        <p>{{ trans_db("website.Phone") }} : {{ $address->phone }}</p>
                        <p>{{ trans_db("dashboard.area") }} : {{ optional(\App\Models\AreaTranslation::where('area_id', $address->area)->first())->title }}</p>
                        <p>{{ trans_db("dashboard.city") }} : {{ optional(\App\Models\CityTranslation::where('city_id', $address->city)->first())->title }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <div id="wishlist_content" class="all_content">
                <h3>{{ trans_db('website.Favorite') }}</h3>
                <div class="card">
                  <div class="card-header">
                    <h1 class="heading-2 mb-10"></h1>
                  </div>
                  <div class="card-body">
                    <div class="container mb-30 mt-10">
                      <div class="row">
                        <div class="col-xl-12 col-lg-12 m-auto">
                          <div class="table-responsive shopping-summery">
                            <table class="table table-wishlist">
                              <thead>
                              <tr class="main-heading">
                                <th class="custome-checkbox start pl-30"></th>
                                <th scope="col">{{ trans_db('website.word') }}</th>
                                <th scope="col">{{ trans_db('website.Language') }}</th>
                                <th scope="col" class="end">{{ trans_db('website.Remove') }}</th>
                              </tr>
                              </thead>
                              <tbody>
                                @foreach($favorite as $fav)
                                  <tr class="pt-30">
                                    <td class="custome-checkbox pl-30"></td>
                                    <td class="product-des product-name">
                                      <h6>
                                        <a class="product-name mb-10" href="{{ \LaravelLocalization::localizeUrl('dictionary/' . $fav->word  . '/0/' . $fav->lang_id) }}">
                                          {{ $fav->word }}
                                        </a>
                                      </h6>
                                    </td>
                                    <td class="price" data-title="Price">
                                      <h3 class="text-brand">{{ $fav->lang_id }}</h3>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                      <a href="{{ \LaravelLocalization::localizeUrl('user/favorite/delete/' . $fav->id ) }}" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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

    <script>
        $(document).ready(function () {
            var details = $("#details").attr('id'); 
            var orders = $("#orders").attr('id'); 
            var cart = $("#cart").attr('id'); 
            var addresses = $("#addresses").attr('id'); 
            var wishlist = $("#wishlist").attr('id');

            $(".all_content").hide();
            $("#details_content").show();

            $(".tab-header").click(function() {
                var section = $(this).attr('id');
                console.log("#" + section + "_content");
                // alert("#" + section + "_content");
                $(".all_content").hide();
                $("#" + section + "_content").fadeIn();
            });
        });
    </script>
@endsection