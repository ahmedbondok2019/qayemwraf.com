@extends('admin.layouts.app')

@section('content')

    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.mytextarea'
        });
    </script>


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">{{ trans_db('dashboard.OrderDetailss') }} </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
{{--                        <div class="card-header">--}}
{{--                            <h3 class="card-title" style="float: right;"> {{ trans_db('dashboard.OrderDetailss') }} </h3>--}}
{{--                        </div>--}}
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('admin-1029/Reports/user_order_details_update') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            @if (session('msg'))
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ session('msg') }}
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="card-body">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.Total') }} </label>
                                                <input type="text" class="form-control" name="order_total" value="{{ $order->order_total }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.PromoCod') }} </label>
                                                @php($promoCode = \App\promoCode::where('id' ,$order->order_promo_code)->first())
                                                <input type="text" class="form-control" name="order_promo_code" value="@if(isset($promoCode)) % {{ $promoCode->promoValue }}@else -- @endif">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.CityPrice') }}</label>
                                                <input type="text" class="form-control" name="order_delivery_fees" value="{{ $order->order_delivery_fees }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.Total_to_pay') }}</label>
                                                <input type="text" class="form-control" name="order_total_toPay" value="{{ $order->order_total_toPay }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.DeliveryLocation') }}</label>
                                                @php( $address = \App\users_address::where('id', $order->order_delivery_place)->first())
                                                @if(isset($address) && $address != '')
                                                    <?php $area = \App\Area::where('id',$address->area_id)->first(); ?>
                                                    <?php $city = \App\cities::where('id',$address->city_id)->first(); ?>
                                                    <?php $branch = \App\branches::where('id' ,$order->order_delivery_place)->first(); ?>
                                                    <?php $address1 = $address->street.','.$address->building.','.$address->floor.','. isset($area) && $area != null ? $area->area_ar : "" .','. isset($city) && $city != null ? $city->city_ar : ""; $address2 = isset($branch) && $branch != null ? $branch->name_ar : ""; ?>
                                                @else
                                                    <?php $address1 = "";  $address2 = ""; ?>
                                                @endif
                                                <input type="text" class="form-control" name="order_delivery_place" value="{{ $order->order_delivery_type == 1 ? $address1 : $address2 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.Delivery') }}</label>
                                                <input type="text" class="form-control" name="order_delivery_type" value="{{ $order->order_delivery_type == 1 ? $delivery_type = 'توصيل الى عنوان العميل' : $delivery_type = 'من المطعم' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.Payment') }}</label>
                                                <input type="text" class="form-control" name="payment_method" value="{{ $order->payment_method == 1 ? $delivery_type = 'نقدى عند الاستلام' : $delivery_type = 'بطاقة دفع' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans_db('dashboard.Date') }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="{{ date('Y-m-d', strtotime($order->created_at)) }}" data-inputmask-alias="datetime" placeholder="{{ date('yyyy-mm-dd', strtotime($order->created_at)) }}" data-inputmask-inputformat="yyyy-mm-dd" data-mask="" im-insert="false" style="text-align: left;direction: ltr;" name="created_at">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>{{ trans_db('dashboard.Notes') }}</label>
                                                <textarea name="notes" class="mytextarea"  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $order->notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="color: red;font-weight: 600">{{ trans_db('dashboard.Status') }}</label>
                                                <select name="order_status" class="form-control select2" style="width: 100%;">
                                                    <option value="{{ $order->order_status }}" {{ $order->order_status == $order->order_status ? 'selected' : '' }}> {{ \App\Http\Controllers\admin\ReportsController::orderStatus($order->order_status) }} </option>
                                                    <option value="0">{{ trans_db('dashboard.Confirmation') }}</option>
                                                    <option value="1">{{ trans_db('dashboard.Ready') }} </option>
                                                    <option value="2">{{ trans_db('dashboard.Arrive') }}</option>
                                                    <option value="3">{{ trans_db('dashboard.Receive') }}</option>
                                                    <hr>
                                                    <option value="4">{{ trans_db('dashboard.Refused') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title" style="float: right;color: red;font-weight: 600">{{ trans_db('dashboard.Meals') }}</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body p-0">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>{{ trans_db('dashboard.Meal') }}</th>
                                                    <th style="width: 40px">{{ trans_db('dashboard.Price') }}</th>
                                                    <th style="width: 40px">{{ trans_db('dashboard.Quantity') }}</th>
                                                    <th style="width: 10px">{{ trans_db('dashboard.Size') }}</th>
                                                    <th>{{ trans_db('dashboard.Additions') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order['order_details'] as $details)
                                                    <?php
                                                    if (isset($order['order_additions']) && $order['order_additions'] !='')
                                                    {
                                                        $add_id = [];
                                                        foreach ($order['order_additions'] as $additions)
                                                        {
                                                            if ($additions->meal_id == $details->meal_id)
                                                            {
                                                                $add_id[] = $additions->food_additions_id;
                                                            }
                                                        }
                                                        $addIDS = collect($add_id);
                                                        $addition_value = \App\food_additions::whereIn('id' ,$addIDS)->sum('Additions_price');
                                                    }
                                                    else{
                                                        $addition_value = 0;
                                                    }
                                                    //                                                    dd($details->meal_price);
                                                    ?>
                                                    <tr>
                                                        <td style="width: 10px">{{ $details->id }}</td>
                                                        <td>{{ \App\meals::where('id',$details->meal_id)->first()->meal_ar }}</td>
                                                        <td style="width: 40px">{{ $details->meal_price + $addition_value }}</td>
                                                        <td style="width: 40px">{{ $details->quantity }}</td>
                                                        <td style="width: 10px">
                                                            @if(\Illuminate\Support\Facades\App::isLocale('en'))
                                                                @php($size = \App\meals_prices::where('id' ,$details->meal_size)->first())
                                                                @if ($size)
                                                                    {{ $size->meal_size_en }}
                                                                @endif
                                                            @else
                                                                @php($size = \App\meals_prices::where('id' ,$details->meal_size)->first())
                                                                @if ($size)
                                                                    {{ $size->meal_size_ar }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        @php($order_additions = \App\order_additions::where('order_id', $details->id)->where('meal_id', $details->meal_id)->get())
                                                        <td>
                                                            @if (isset($order['order_additions']) && $order['order_additions'] !='')
                                                                @foreach($order['order_additions'] as $additions)
                                                                    @if(\Illuminate\Support\Facades\App::isLocale('en'))
                                                                        {{ $addi = \App\food_additions::where('id',$additions->food_additions_id)->first()->Additions_name_en.' , ' }}
                                                                    @else
                                                                        {{ $addi = \App\food_additions::where('id',$additions->food_additions_id)->first()->Additions_name_ar.' , ' }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

{{--@extends('admin.layouts.app')--}}

{{--@section('content')--}}

{{--    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>--}}
{{--    <script>--}}
{{--        tinymce.init({--}}
{{--            selector: '.mytextarea'--}}
{{--        });--}}
{{--    </script>--}}


{{--    <!-- Content Header (Page header) -->--}}
{{--    <section class="content-header">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row mb-2">--}}
{{--                <div class="col-sm-6">--}}
{{--                    <h1 style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};"> {{ trans_db('dashboard.OrderDetailss') }} </h1>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </section>--}}

{{--    <!-- Main content -->--}}
{{--    <section class="content">--}}

{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <!-- left column -->--}}
{{--                <div class="col-md-12">--}}
{{--                    <!-- general form elements -->--}}
{{--                    <div class="card card-info" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">--}}
{{--                        <div class="card-header">--}}
{{--                            <h3 class="card-title" style="float: right;"> {{ trans_db('dashboard.OrderDetailss') }} </h3>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-header -->--}}
{{--                        <!-- form start -->--}}
{{--                        <form action="{{ url('admin-1029/Reports/user_order_details_update') }}" method="post" enctype="multipart/form-data">--}}
{{--                            @csrf--}}

{{--                            @if (session('msg'))--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="alert alert-success alert-dismissible">--}}
{{--                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                                        {{ session('msg') }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if ($errors->any())--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="alert alert-danger alert-dismissible">--}}
{{--                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                                        <ul>--}}
{{--                                            @foreach ($errors->all() as $error)--}}
{{--                                                <li>{{ $error }}</li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            <div class="col-md-12">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <input type="hidden" name="id" value="{{ $order->id }}">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.Total') }} </label>--}}
{{--                                                <input type="text" class="form-control" name="order_total" value="{{ $order->order_total }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.PromoCod') }} </label>--}}
{{--                                                <input type="text" class="form-control" name="order_promo_code" value="{{ $order->order_promo_code }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.CityPrice') }} </label>--}}
{{--                                                <input type="text" class="form-control" name="order_delivery_fees" value="{{ $order->order_delivery_fees }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.Total_to_pay') }}</label>--}}
{{--                                                <input type="text" class="form-control" name="order_total_toPay" value="{{ $order->order_total_toPay }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.DeliveryLocation') }}</label>--}}
{{--                                                @php( $address = \App\users_address::where('id', $order->order_delivery_place)->first())--}}
{{--                                                <input type="text" class="form-control" name="order_delivery_place" value="{{ $order->order_delivery_type == 1 ? $address->street.','.$address->building.','.$address->floor.','.\App\Area::where('id',$address->area_id)->first()->area_ar.','.\App\cities::where('id',$address->city_id)->first()->city_ar : $address = \App\branches::where('id' ,$order->order_delivery_place)->first()->name_ar }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.Delivery') }} </label>--}}
{{--                                                <input type="text" class="form-control" name="order_delivery_type" value="{{ $order->order_delivery_type == 1 ? $delivery_type = trans_db('dashboard.DeliveryType1') : $delivery_type = trans_db('dashboard.DeliveryType2') }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>{{ trans_db('dashboard.Payment') }}</label>--}}
{{--                                                <input type="text" class="form-control" name="payment_method" value="{{ $order->payment_method == 1 ? $delivery_type = trans_db('dashboard.PaymentCash') : $delivery_type = trans_db('dashboard.PaymentCard') }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label> {{ trans_db('dashboard.Date') }}</label>--}}
{{--                                                <div class="input-group">--}}
{{--                                                    <input type="text" class="form-control" value="{{ date('yyyy-mm-dd', strtotime($order->created_at)) }}" data-inputmask-alias="datetime" placeholder="{{ date('yyyy-mm-dd', strtotime($order->created_at)) }}" data-inputmask-inputformat="yyyy-mm-dd" data-mask="" im-insert="false" style="text-align: left;direction: ltr;" name="created_at">--}}
{{--                                                    <div class="input-group-prepend">--}}
{{--                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!-- /.input group -->--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label>{{ trans_db('dashboard.Notes') }}</label>--}}
{{--                                                <textarea name="notes" class="mytextarea"  style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $order->notes }}</textarea>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label style="color: red;font-weight: 600">{{ trans_db('dashboard.Status') }} </label>--}}
{{--                                                <select name="order_status" class="form-control select2" style="width: 100%;">--}}
{{--                                                    <option value="{{ $order->order_status }}" {{ $order->order_status == $order->order_status ? 'selected' : '' }}> {{ \App\Http\Controllers\admin\ReportsController::orderStatus($order->order_status) }} </option>--}}
{{--                                                    <option value="0">{{ trans_db('dashboard.Confirmation') }}</option>--}}
{{--                                                    <option value="1">{{ trans_db('dashboard.Ready') }} </option>--}}
{{--                                                    <option value="2">{{ trans_db('dashboard.Arrive') }}</option>--}}
{{--                                                    <option value="3">{{ trans_db('dashboard.Receive') }}</option>--}}
{{--                                                    <hr>--}}
{{--                                                    <option value="4">{{ trans_db('dashboard.Refused') }}</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="card">--}}
{{--                                        <div class="card-header">--}}
{{--                                            <h3 class="card-title" style="float: right;color: red;font-weight: 600">{{ trans_db('dashboard.Meals') }}</h3>--}}
{{--                                        </div>--}}
{{--                                        <!-- /.card-header -->--}}
{{--                                        <div class="card-body p-0">--}}
{{--                                            <table class="table table-striped">--}}
{{--                                                <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th style="width: 10px">#</th>--}}
{{--                                                    <th>{{ trans_db('dashboard.Meal') }}</th>--}}
{{--                                                    <th style="width: 40px">{{ trans_db('dashboard.Price') }}</th>--}}
{{--                                                    <th style="width: 40px">{{ trans_db('dashboard.Quantity') }}</th>--}}
{{--                                                    <th style="width: 10px">{{ trans_db('dashboard.Size') }}</th>--}}
{{--                                                    <th>{{ trans_db('dashboard.Additions') }}</th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @foreach($order['order_details'] as $details)--}}
{{--                                                    <tr>--}}
{{--                                                        <td style="width: 10px">{{ $details->id }}</td>--}}
{{--                                                        <td>{{ \App\meals::where('id',$details->meal_id)->first()->meal_ar }}</td>--}}
{{--                                                        <td style="width: 40px">{{ $details->meal_price }}</td>--}}
{{--                                                        <td style="width: 40px">{{ $details->quantity }}</td>--}}
{{--                                                        <td style="width: 10px">{{ $details->meal_size }}</td>--}}
{{--                                                        @php($order_additions = \App\order_additions::where('order_id', $order->id)->where('meal_id', $details->meal_id)->get())--}}
{{--                                                        <td>@foreach($order_additions as $additions) {{ $addi = \App\food_additions::where('id',$additions->food_additions_id)->first()->Additions_name_ar.' , ' }} @endforeach</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                        <!-- /.card-body -->--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-body -->--}}

{{--                            <div class="card-footer">--}}
{{--                                <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Update') }} </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- /.row -->--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </section>--}}
{{--    <!-- /.content -->--}}

{{--@endsection--}}
