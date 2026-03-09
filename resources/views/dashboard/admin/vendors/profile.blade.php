@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}

    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}

@endsection

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card user-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                            <div class="user-avatar-section">
                                                <div class="d-flex justify-content-start">
                                                    <img src="{{ $Details->VendorImages->first() !== null ? asset('website/images/vendor/') . $Details->VendorImages->first()->image : asset('website/user/User-Profile.png') }}" class="img-fluid rounded" height="104" width="104" alt="User avatar"  >
                                                    <div class="d-flex flex-column ml-1">
                                                        <div class="user-info mb-1">
                                                            <h4 class="mb-0">{{$Details->name}}</h4>
                                                            <h4 class="mb-0">{{$Details->full_name}}</h4>
                                                            Phone: <span class="card-text">{{$Details->mobile_number}}</span>
                                                        </div>
                                                        <div class="user-info mb-1">
                                                            Civil ID: <span class="card-text">{{$Details->civil_ID}}</span>
                                                        </div>
                                                        <div class="user-info mb-1">
                                                            Date Birth: <span class="card-text">{{ $Details->date_birth != null ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s' , $Details->date_birth)->format('Y-m-d') : null }}</span>
                                                        </div>
                                                        <div class="d-flex flex-wrap">
                                                            <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/edit/' . $Details->id) }}" class="btn btn-primary">Edit</a>
{{--                                                            <button class="btn btn-outline-danger ml-1">Delete</button>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                            <div class="user-info-wrapper">
                                                <div class="d-flex flex-wrap">
                                                    <div class="user-info-title">
                                                        <i data-feather="user" class="mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">Username</span>
                                                    </div>
                                                    <p class="card-text mb-0">{{$Details->name}}</p>
                                                </div>
                                                <div class="d-flex flex-wrap my-50">
                                                    <div class="user-info-title">
                                                        <i data-feather="check" class="mr-1"></i>
                                                        <span class="card-text user-info-title font-weight-bold mb-0">File Number</span>
                                                    </div>
                                                    <p class="card-text mb-0">{{$Details->file_number}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card user-card">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($Details->VendorImages as $image)
                                            <a onclick="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')" href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/delete/image/' . $image->id) }}">
                                                <i class="fa fa-trash danger" aria-hidden="true"></i>
                                                <div class="col-md-6">
                                                    <img src="{{ asset('website/images/vendor') }}/{{ $image->image }}" alt="" style="height: 50px;width:50px;border-radius: 25%">
                                                </div>
                                            </a>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card user-card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                                <thead>
                                                <tr>
                                                    <th># </th>
                                                    <th> invoice id </th>
                                                    <th> status </th>
                                                    <th> total </th>
                                                    <th> discount </th>
                                                    <th> paid </th>
                                                    <th> balance </th>
                                                    <th> Action </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($appointments as $appointment)
                                                    <tr>
                                                        @php($fixedRoute = \LaravelLocalization::localizeUrl('admin-2023/invoices/edit/' . $appointment->id))
                                                        <td><a href="{{ $fixedRoute}}">{{$appointment->id}}</a></td>
                                                        <td><a href="{{ $fixedRoute}}">{{$appointment->invoice_id}}</a></td>
                                                        @php($invoice = \App\Models\Invoice::find($appointment->invoice_id))
                                                        <td><a href="{{ $fixedRoute}}">{{ \App\Http\Controllers\Admin\InvoicesController::getStatus($invoice->status, $invoice->total_amount, $invoice->discount , $invoice->amount) }}</a></td>
                                                        <td><a href="{{ $fixedRoute}}">{{$invoice->total_amount}}</a></td>
                                                        <td><a href="{{ $fixedRoute}}">{{$invoice->discount}}</a></td>
                                                        <td><a href="{{ $fixedRoute}}">{{$invoice->paid_amount}}</a></td>
                                                        <td><a href="{{ $fixedRoute}}">{{$invoice->total_amount - $invoice->discount - $invoice->paid_amount}}</a></td>
                                                        <td>
                                                            <a href="{{ $fixedRoute}}" class="btn btn-success btn-sm">{{ trans_db('dashboard.Update') }}</a>
                                                            <a onclick="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')"
                                                               href="{{ \LaravelLocalization::localizeUrl('admin-2023/invoices/delete') }}/{{$appointment->id}}"
                                                               class="btn btn-danger btn-sm">{{ trans_db('dashboard.delete') }}
                                                            </a>
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
                    <!-- User Card & Plan Ends -->
                </section>

            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

@endsection
