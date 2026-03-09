@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

    {!! Html::style('admin/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

    {!! Html::style('admin/app-assets/vendors/css/file-uploaders/dropzone.min.css') !!}
@section('style1')
    {!! Html::style('admin/app-assets/css-rtl/plugins/forms/form-file-uploader.css') !!}
@endsection

@endsection

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-hearder row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.Edit Order') }}</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown" style="display: inline-flex;">
                        <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/orders/invoice_pdf/' . $details->id) }}"
                            class="btn btn-success bg-lighten-2 btn-sm">
                            <svg data-v-4a00de13="" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path data-v-4a00de13="" d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline data-v-4a00de13="" points="7 10 12 15 17 10"></polyline>
                                <line data-v-4a00de13="" x1="12" y1="15" x2="12" y2="3">
                                </line>
                            </svg>
                        </a>
                        &nbsp;
                        &nbsp;

                        <a target="_blank"
                            href="{{ \LaravelLocalization::localizeUrl('admin-2023/orders/print/' . $details->id) }}"
                            class="btn btn-info bg-lighten-2 btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-print">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                </path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="content-body">

            @include('dashboard.admin.component.page_error', ['errors' => $errors])

            <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/orders/update') }}" method="post"
                enctype="multipart/form-data" role="form">

                @csrf

                <input type="hidden" name="id" value="{{ $details->id }}">
                <input type="hidden" name="tanslation_id" value="{{ $details->id }}">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.User Information') }}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @php
                                $user = \App\Models\User::find($details->user_id);
                            @endphp
                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($user)
                                            @php
                                                $keys = array_keys($user->toArray());
                                                $toHide = [
                                                    'id',
                                                    'accept',
                                                    'status',
                                                    'admin',
                                                    'created_at',
                                                    'updated_at',
                                                    'deleted_at',
                                                ];
                                            @endphp

                                            @foreach ($keys as $i => $key)
                                                @if (!in_array($key, $toHide))
                                                    @include('dashboard.admin.orders.fields', [
                                                        'key' => $key,
                                                        'field' => $user[$key],
                                                    ])
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div
                                                class="form-group {{ $errors->has('order_notes') ? 'has-error' : '' }}">
                                                <label
                                                    for="exampleInputEmail1">{{ trans_db('dashboard.order notes') }}</label>
                                                {!! Form::textarea('order_notes', $details->notes, [
                                                    'placeholder' => trans_db('dashboard.order notes'),
                                                    'class' => 'form-control',
                                                    'rows' => 2,
                                                    'id' => 'summernote',
                                                ]) !!}
                                                <span class="text-danger">{{ $errors->first('order_notes') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Delivery Information') }}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @php
                                            $keys = [
                                                'address' => $details->address,
                                                'Name' => $details->name,
                                                'Email' => $details->email,
                                                'Phone' => $details->phone,
                                                'area' => optional(
                                                    \App\Models\AreaTranslation::where('area_id', $details->area)
                                                        ->where('lang_id', app()->getLocale())
                                                        ->first(),
                                                )->title,
                                                'city' => optional(
                                                    \App\Models\CityTranslation::where('city_id', $details->city)
                                                        ->where('lang_id', app()->getLocale())
                                                        ->first(),
                                                )->title,
                                            ];
                                        @endphp

                                        @foreach ($keys as $i => $key)
                                            @include('dashboard.admin.orders.fields', [
                                                'key' => $i,
                                                'detail' => $key,
                                            ])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Total') }}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @php
                                            if ($details->discount_type == null) {
                                                $discount = '';
                                            } else {
                                                $details->discount_type == 1
                                                    ? ($discount = trans_db('dashboard.percentage'))
                                                    : ($discount = trans_db('dashboard.fixed'));
                                            }

                                            $keys = [
                                                'sum' => $details->sum,
                                                'tax' => $details->tax,
                                                'Total' => $details->total,
                                                'Status' => $details->status,
                                                'payment_status' => $details->payment_status,
                                                'payment_method' => $details->payment_method,
                                                'transaction_ref' => $details->transaction_ref,
                                                'payment_by' => $details->payment_by,
                                                'paid_actual' => $details->paid_actual,
                                                'rate' => $details->rate,
                                                'currency' => $details->currency,
                                                'discount_amount' => $details->discount_amount,
                                                'discount_type' => $discount,
                                                'coupon_code' => $details->coupon_code,
                                            ];
                                        @endphp
                                        @foreach ($keys as $i => $key)
                                            @include('dashboard.admin.orders.fields', [
                                                'key' => $i,
                                                'detail' => $key,
                                            ])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Shipping Information') }}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @php
                                            $keys = [
                                                'shipping_method_id' => $details->shipping_method_id,
                                                'shipping_cost' => $details->shipping_cost,
                                                'delivery_man_id' => $details->delivery_man_id,
                                                'deliveryman_charge' => $details->deliveryman_charge,
                                                'expected_delivery_date' => $details->expected_delivery_date,
                                                'delivery_type' => $details->delivery_type,
                                                'delivery_service_name' => $details->delivery_service_name,
                                                'third_party_delivery_tracking_id' =>
                                                    $details->third_party_delivery_tracking_id,
                                            ];
                                        @endphp
                                        @foreach ($keys as $i => $key)
                                            @include('dashboard.admin.orders.fields', [
                                                'key' => $i,
                                                'detail' => $key,
                                            ])
                                        @endforeach

                                        <x-admin.setting.input :col="'12'" :field="'shipping_cost'" :value="$details->shipping_cost"
                                            :trans="trans_db('dashboard.shipping_cost')" />
                                        <div class="col-12 d-flex flex-sm-row flex-column">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                {{ trans_db('dashboard.Save') }} </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ trans_db('dashboard.products') }}</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg"
                                            width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-content collapse show" style="">
                        <div class="card-body">
                            {{-- استخدام @forelse بدل @foreach --}}
                            @forelse ($details->order_details ?? [] as $order_details)
                                @include('dashboard.admin.orders.order_details', [
                                    'order_details' => $order_details,
                                ])
                            @empty
                                <div class="alert alert-info mb-2">
                                    {{ trans_db('dashboard.no_products_found') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Order Statuses') }}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="card">
                                        @livewire('dashboard.admin.order-statuses', ['order_id' => $details->id])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        @livewire('dashboard.admin.add-order-status', ['user_id' => $details->user_id, 'order_id' => $details->id])
                    </div>
                </div>

            </form>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Include Bootstrap JS (Summernote dependency) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Include Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });
        });
    </script>

    <script>
        $('select[name=shipping_method_id]').on('change', function() {
            var order_id = $(this).data('id');
            var shipping_method_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ \LaravelLocalization::localizeUrl('admin-2023/orders/updateOrder') }}',
                method: 'POST',
                data: {
                    order_id: order_id,
                    shipping_method_id: shipping_method_id
                },
                success: function(data) {
                    swal({
                        text: data.msg,
                        icon: data.status === true ? 'success' : 'warning',
                        dangerMode: false,
                    })
                }
            });
        });
    </script>

    <script>
        // $('select[name=shipping_method_id]').on('change' , function () {
        //     var shipping_method_id = $(this).val();
        //     var order_id = $("input[name=id]").val();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url:'{{ \LaravelLocalization::localizeUrl('admin-2023/orders/updateOrder') }}',
        //         method:'POST',
        //         data:{order_id:order_id,shipping_method_id:shipping_method_id},
        //         success:function(data)
        //         {
        //             swal({
        //                 text: data.msg,
        //                 icon: 'success',
        //                 dangerMode: false,
        //             })
        //         }
        //     });        
        // });
    </script>
@endsection
