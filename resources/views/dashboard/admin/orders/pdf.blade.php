<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>

    <title>{{ trans_db('dashboard.Invoice') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    @include('dashboard.admin.layouts.pdf_style')
</head>

@php
    $Setting = \App\Models\Setting::where('lang_id', app()->getLocale())->first();
@endphp

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview" style="">
                    <!-- Invoice -->
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <table>
                                    <tr>
                                        <td style="width:60%">
                                            <div>
                                                <div class="logo-wrapper" style="margin-bottom:0 !important">
                                                     <img src="{{ isset($Setting) && $Setting->logo ? asset($Setting->logo) : asset('website/images/logo/logo.png') }}" class="invoice_logo" style="width:160px;height:93px;" alt="Logo">
                                                </div>
                                            </div>
                                        </td>
                                        <td >
                                            <table class="inside_table" style="text-align:left;">
                                                <tr style="background-color: #f7f2ea">
                                                    {{-- <td><strong style="font-weight:700 !important">{{ trans_db("dashboard.Invoice") }}:</strong></td> --}}
                                                    <td><strong style="font-weight:700 !important">Invoice</strong></td>
                                                    <td>{{ \Carbon\Carbon::now()->format('ymd') }}-{{ $PdfData->id }}</td>
                                                </tr>
                                                <tr>
                                                    {{-- <td><strong style="font-weight:700 !important">{{ trans_db("dashboard.Due Date") }}:<strong></td> --}}
                                                    <td><strong style="font-weight:700 !important">Due Date<strong></td>
                                                    <td>{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $PdfData->created_at)->format('Y-m-d') }}</td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>
                                </table>
                                <!-- Header ends -->
                            </div>

                            <hr class="invoice-spacing" />
                            <table style="text-align: center">
                                <tr>
                                    <td>
                                        <h1 style="
                            text-align: center;
                            font-size: 70px;
                            color: #11397F;
                            ">
                            {{-- {{ trans_db("dashboard.Invoice") }} --}}
                            Invoice
                        </h1>

                                    </td>
                                </tr>
                            </table>


                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <table>
                                        <tr>
                                            <td style="width:60%; @if(app()->getLocale() == 'ar') direction:rtl;text-align:right @endif">
                                                <div>
                                                    <h3 style="margin-bottom:15px;font-weight:bold"><b>User Information:</b></h3>
                                                    @php
                                                        $user = \App\Models\User::find($PdfData->user_id);
                                                    @endphp
                                                    <p class="card-text mb-25" style="margin-bottom: 6px !important;"><b>Name:</b> {{ $PdfData->name == null ? $user->name : $PdfData->name }}</p>
                                                    <p class="card-text mb-25"><b>Phone:</b> {{ $PdfData->phone == null ? $user->phone : $PdfData->phone }}</p>
                                                    <p class="card-text mb-25"><b>Email:</b> {{ $PdfData->email == null ? $user->email : $PdfData->email }}</p>
                                                    <p class="card-text mb-25"><b>address:</b> {{ $PdfData->address }}</p>
                                                    <p class="card-text mb-25"><b>area:</b> {{ optional(\App\Models\AreaTranslation::where('area_id', $PdfData->area)->where('lang_id', app()->getLocale())->first())->title }}</p>
                                                    <p class="card-text mb-25"><b>city:</b> {{ optional(\App\Models\CityTranslation::where('city_id', $PdfData->city)->where('lang_id', app()->getLocale())->first())->title }}</p>
                                                
                                                </div>
                                            </td>
                                      
                                            @php
                                            $currency = \App\Models\Currency::where('status' , 1)->first();
                                            $rate = $currency->rate;
                                            @endphp

                                            <td style="vertical-align: baseline; @if(app()->getLocale() == 'ar') direction:rtl;text-align:right @endif">
                                                <div>
                                                    <h3 style="margin-bottom:15px;font-weight:bold">Payment status</h3>
                                                    <div>
                                                        <h4 class="mb-25" style="margin-bottom: 3px;font-weight: 400;">
                                                            <span>Total :</span>
                                                            <span class="result_total_amount">{{ $PdfData->total }} {{ $Currency->currency_sign }}</span>
                                                        </h4>
                                                        <h4 class="mb-25"style="margin-bottom: 3px;font-weight: 400;">
                                                            <span>Payment status :</span>
                                                            <span>
                                                                {{ \App\Http\Controllers\Admin\OrdersController::getPaymentStatus($PdfData->payment_status) }}    

                                                            </span>
                                                        </h4>
                                                        <h4 class="mb-25" style="margin-bottom: 3px;font-weight: 400;">
                                                            <span>
                                                                payment method :
                                                            </span>
                                                            <span>{{ $PdfData->payment_method }}</span>
                                                        </h4>
                                                        <h4 class="mb-25" style="margin-bottom: 3px;font-weight: 400;">
                                                            <span>
                                                                coupon code : 
                                                            </span>
                                                            <span>{{ $PdfData->coupon_code_name }}</span>
                                                        </h4>
                                                    </div>
                                                    <br>
                                                    <p class="card-text mb-25"><b>Code: <img src="{{ asset("website/barcode.gif") }}" alt="" style="max-height: 60px"></b></p>

                                                </div>
                                            </td>

                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <div class="card-body invoice-padding pt-0">
                                <p class="margin-bottom:-5px">
                                    <strong style="font-weight:700 !important">options</strong>
                                </p>
                                @foreach ($PdfData->order_details as $order_details)
                                    @include('dashboard.admin.orders.pdf_order_details', ['order_details' => $order_details ])
                                @endforeach
                            </div>

                            <div class="card-body invoice-padding pb-0" style="display: flex;display: flex;">
                                <div class="invoice-total-wrapper" style="max-width: 350px !important;">
                                    <div class="invoice-total-item" style="display: flex;">
                                        <table style="display: flex;">
                                            <tr>
                                                <td style="width: 60%; text-align:center">
                                                    <p style="text-align: center">
                                                        {!! $PdfData->notes !!}
                                                    </p>
                                                </td>
                                                <td style="width: 40%"></td>
                                                    <table class="inside_table" style="text-align:left;">
                                                        <tr style="background-color: #f7f2ea">
                                                            <td><strong style="font-weight:700 !important">subtotal :</strong></td>
                                                            <td><strong style="font-weight:700 !important">{{ $PdfData->sum }} {{ $Currency->currency_sign }}</strong></td>
                                                        </tr>
                                                        <tr style="background-color: #f7f2ea">
                                                            <td><strong style="font-weight:700 !important">tax :</strong></td>
                                                            <td><strong style="font-weight:700 !important">{{ $PdfData->tax }} {{ $Currency->currency_sign }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-weight:700 !important">Discount :</strong></td>
                                                            <td><strong style="font-weight:700 !important">{{ $PdfData->discount_amount }} {{ $Currency->currency_sign }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-weight:700 !important">shipping_cost :</strong></td>
                                                            <td><strong style="font-weight:700 !important">{{ $PdfData->shipping_cost }} {{ $Currency->currency_sign }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-weight:700 !important">Total :</strong></td>
                                                            <td><strong style="font-weight:700 !important">{{ $PdfData->paid_actual ?? $PdfData->total }} {{ $Currency->currency_sign }}</strong></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- <hr class="invoice-spacing mt-0" /> --}}
                                {{-- <h2>User By : {{ optional(\App\Models\Admin::find($PdfData->created_by))->name }}</h2> --}}
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing mt-0" />
                            {{-- <p style="text-align:center;font-weight:700 !important">Powered by: souqelmlabes
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

</body>


</html>
