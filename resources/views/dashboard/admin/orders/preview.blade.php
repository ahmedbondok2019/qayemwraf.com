@extends('dashboard.admin.layouts.app_preview')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-invoice.css') !!}

    <style>
        .select2-container--classic .select2-selection--single .select2-selection__arrow b, .select2-container--default .select2-selection--single .select2-selection__arrow b{
            padding-right: 0;
        }
        .invoice-number-date > .d-flex:nth-child(2),
        .invoice-number-date > .d-flex:nth-child(3) {
            align-items: flex-start !important;
            margin-bottom: 0 !important;
        }
        .invoice-edit .invoice-preview-card .invoice-title, .invoice-add .invoice-preview-card .invoice-title,
        .invoice-preview .invoice-number-date .title, .invoice-edit .invoice-number-date .title, .invoice-add .invoice-number-date .title {
            width: auto !important;
            margin-right: 5px;
            font-weight: 600;
        }
        .row-bill-to .col-xl-4 {
            max-width: none;
        }
        @media screen and (min-width:1200px) {
            .invoice-number-date > .d-flex:nth-child(2),
            .invoice-number-date > .d-flex:nth-child(3) {
                justify-content: flex-end;
            }
        }
        @media screen and (min-width:1200px) {
            /*.invoice-add .col-xl-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
            }
            .invoice-add .col-xl-3 {
                display: none !important;
            }*/
            .row-bill-to,
            .source-item > .row,
            .product-details-border > .row,
            .invoice-sales-total-wrapper,
            .invoice-preview-card > .card-body:first-child > div {
                display: grid !important;
                grid-template-columns: 2fr 1fr !important;
            }
            .invoice-number-date {
                padding-left: 15px !important;
            }
            /*.row-bill-to .col-xl-4 {
                position: relative !important;
                top: -20px !important;
            }*/
            .source-item > .row > div:first-child {
                padding: 0 !important;
            }
            .product-details-border > .row > div:last-child {
                position: relative !important;
                left: 10px !important;
            }
            .invoice-sales-total-wrapper .col-md-8 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
            .invoice-total-wrapper {
                max-width: none !important;
            }
        }
        @media print {
            .invoice-add .col-xl-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
            }
            .invoice-add .col-xl-3 {
                display: none !important;
            }
            .row-bill-to,
            .source-item > .row,
            .product-details-border > .row,
            .invoice-sales-total-wrapper,
            .invoice-preview-card > .card-body:first-child > div {
                display: grid !important;
                grid-template-columns: 2fr 1fr !important;
            }
            .invoice-number-date {
                padding-left: 15px !important;
            }
            .invoice-title {
                position: relative !important;
                left: -20px !important;
            }
            .row-bill-to .col-xl-4 {
                position: relative !important;
                top: -20px !important;
            }
            .source-item > .row > div:first-child {
                padding: 0 !important;
            }
            .product-details-border > .row > div:last-child {
                position: relative !important;
                left: 20px !important;
            }
            .invoice-sales-total-wrapper .col-md-8 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
            .invoice-total-wrapper {
                max-width: none !important;
            }
            .text-xl-right {
                text-align: right !important;
            }
            .invoice-number-date > .d-flex {
                justify-content: flex-end !important;
            }
        }
    </style>
@endsection

@section('content')

@php
    $Setting = \App\Models\Setting::where('lang_id', app()->getLocale())->first();
@endphp

    <style>
        .table th, .table td{
            padding: 10px !important;
        }
    </style>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="invoice-add-wrapper">
                        <div class="row invoice-add">
                            <!-- Invoice Add Left starts -->
                            <div class="col-xl-9 col-md-8 col-12">
                                <div class="card invoice-preview-card">
                                    <!-- Header starts -->
                                    <div class="card-body invoice-padding pb-0">
                                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0 align-items-xl-center" style="margin-bottom: 0 !important;">
                                            <div>
                                                <div class="logo-wrapper" style="margin-bottom: 0 !important;">
                                                    <img src="{{ asset('website/images/logo/souqelmlabes.png') }}" class="invoice_logo" style="width:160px;" alt="Store Logo">
                                                </div>
                                            </div>
                                            <div class="invoice-number-date mt-md-0 mt-2">
                                                <div class="d-flex align-items-center justify-content-md-end" style="margin-bottom: 3px !important">
                                                    <span class="title">{{ trans_db("dashboard.Invoice") }} :</span>
                                                    {{ $details->id }}
                                                </div>
                                                <div class="d-flex align-items-center" style="margin-bottom: 3px !important">
                                                    <span style="font-weight: 350px !important;width:auto !important;margin:0 5px">{{ trans_db("dashboard.Due Date") }}:</span>
                                                    <p class="invoice-date" style="margin-bottom:0">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $details->created_at)->format('Y-m-d') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->

                                    <hr class="invoice-spacing" />

                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing">
                                            <div class="col-xl-8 mb-lg-1 col-bill-to pl-0">
                                                <h6 class="invoice-to-title" style="margin-bottom: 22px;"><b>{{ trans_db("dashboard.Invoice To") }}:</b></h6>
                                                @php
                                                    $user = \App\Models\User::find($details->user_id);
                                                @endphp
                                                <h6 class="mb-25" style="margin-bottom: 6px !important;"><b>{{ trans_db("dashboard.Name") }}:</b> {{ $details->name == null ? $user->name : $details->name }}</h6>
                                                <p class="card-text mb-25"><b>{{ trans_db("dashboard.Phone") }}:</b> {{ $details->phone == null ? $user->phone : $details->phone }}</p>
                                                <p class="card-text mb-25"><b>{{ trans_db("dashboard.Email") }}:</b> {{ $details->email == null ? $user->email : $details->email }}</p>
                                                <p class="card-text mb-25"><b>{{ trans_db("dashboard.address") }}:</b> {{ $details->address }}</p>
                                                <p class="card-text mb-25"><b>{{ trans_db("dashboard.area") }}:</b> {{ optional(\App\Models\AreaTranslation::where('area_id', $details->area)->where('lang_id', app()->getLocale())->first())->title }}</p>
                                                <p class="card-text mb-25"><b>{{ trans_db("dashboard.city") }}:</b> {{ optional(\App\Models\CityTranslation::where('city_id', $details->city)->where('lang_id', app()->getLocale())->first())->title }}</p>
                                            </div>
                                            <div class="col-xl-4 px-0 mt-xl-0 mt-2 pl-0  text-xl-right">
                                                <div class="text-xl-right">
                                                <p style="margin-bottom: 3px;">
                                                    <span><strong>{{ trans_db("dashboard.Total") }} :</strong></span>
                                                    <span class="result_total_amount">{{ $details->total }} {{ $Currency->currency_sign }}</span>
                                                </p>
                                                <p style="margin-bottom: 3px;">
                                                    <span><strong>{{ trans_db("dashboard.Payment_status") }} :</strong></span>
                                                    <span class="result_total_amount">
                                                        {{ \App\Http\Controllers\Admin\OrdersController::getPaymentStatus($details->payment_status) }}    
                                                    </span>
                                                </p>
                                                <p style="margin-bottom: 3px;">
                                                    <span><strong>{{ trans_db("dashboard.payment_method") }} : </strong></span><span>{{ $details->payment_method }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->

                                    <!-- Product details starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <form class="source-item" role="form" action="" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $details->id }}">
                                            <p class="margin-bottom:15px">
                                            <b>{{ trans_db('dashboard.products') }}</b>
                                            </p>
                                            <div data-repeater-list="group-a">

                                                @foreach ($details->order_details as $order_details)
                                                    @include('dashboard.admin.orders.order_details', ['order_details' => $order_details ])
                                                @endforeach

                                            </div>
                                        </form>
                                    </div>
                                    <!-- Product details ends -->

                                    <!-- Invoice Total starts -->
                                    <div class="card-body invoice-padding" style="margin: 40px 0;">
                                        <div class="row">
                                            
                                            <div class="col-md-12 d-flex justify-content-end order-md-2 order-1">
                                                <div class="invoice-total-wrapper">
                                                    <div id="result"></div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title" style="font-weight: 600">{{ trans_db("dashboard.subtotal") }}:</p>
                                                        <p class="invoice-total-amount" style="font-weight: 400">{{ $details->sum }}</p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title" style="font-weight: 600">{{ trans_db("dashboard.tax") }}:</p>
                                                        <p class="invoice-total-amount" style="font-weight: 400"> {{ $details->tax }}</p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title" style="font-weight: 600">{{ trans_db("dashboard.Discount") }}:</p>
                                                        <p class="invoice-total-discount">{{ $details->discount_amount }}</p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title" style="font-weight: 600">{{ trans_db("dashboard.shipping_cost") }}:</p>
                                                        <p class="invoice-total-discount">{{ $details->shipping_cost }}</p>
                                                    </div>
                                                   
                                                    <hr class="my-50" />
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title" style="font-weight: 600">{{ trans_db('dashboard.Total') }} :</p>
                                                        <p class="invoice-total-total">{{ $details->paid_actual ?? $details->total }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Invoice Total ends -->
                                        {{-- <hr class="invoice-spacing mt-0" /> --}}
                                        {{-- <h2 style="margin: 0 40px;align-self: center;">User By : {{ \Illuminate\Support\Facades\Auth::user()->name }}</h2> --}}
                                        <hr class="invoice-spacing mt-0" />
                                        <p style="text-align:center;font-weight:700 !important">Powered by: souqelmlabes
                                        <p style="text-align:center;font-weight:700 !important">
                                            <img src="{{ env('APP_URL') }} . "website/images/BarCode/Oct-2023/img-1696374724.png" alt="">
                                        </p>

                                </div>
                            </div>
                        </div>

                </section>

            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') !!}
    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') !!}

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>



    <script>
        @if(isset($print) && $print === 'print')
            window.onload = function () {
                window.print();
            }
        @endif
    </script>
@endsection
