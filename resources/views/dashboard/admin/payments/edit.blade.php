@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">

                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/payments/update') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <input type="hidden" name="id" value="{{ $payment->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Edit Order') }}</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                
                                        <div class="card-content collapse show" style="">
                                            <div class="card-body">
                                                <div class="row">
                                                    @php
                                                        $keys = array(
                                                            "Order" => $payment->order_id,
                                                            "Vendor" => optional(\App\Models\Vendor::find($payment->vendor_id))->name,
                                                            "Due Amount" => $payment->amount,
                                                            "payment_status" => $payment->paid_status == 0 ? "Not Paid" : "Paid",
                                                            "Due Date" => $payment->due_date,
                                                            "Paid Date" => $payment->paid_date,
                                                            "payment_ref_id" => $payment->payment_ref_id,
                                                            "website_profit" => $payment->website_profit,
                                                            "vendor_profit" => $payment->vendor_profit,
                                                            "Details" => $payment->notes,
                                                        );
                                                    @endphp
        
                                                    @foreach ($keys as $i => $key)
                                                        @include('dashboard.admin.orders.fields', ['key' => $i, 'field' => $key])
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Payment_status') }}</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                
                                        <div class="card-content collapse show" style="">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group {{ $errors->has('payment_ref_id') ? 'has-error' : '' }}">
                                                            <label for="exampleInputEmail1">{{ trans_db('dashboard.Payment_ref_id') }}</label>
                                                            {!! Form::text('payment_ref_id', $payment->payment_ref_id, ['placeholder'=> trans_db('dashboard.payment_ref_id'),'class' => "form-control" ]) !!}
                                                            <span class="text-danger">{{ $errors->first('payment_ref_id') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label for="textarea">{{ trans_db('dashboard.Details') }}</label>
                                                        <textarea class="form-control" rows="3" placeholder="{{ trans_db("dashboard.Details") }}" name="notes">{{ $payment->notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
