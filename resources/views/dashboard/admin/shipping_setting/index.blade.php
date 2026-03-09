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
                                  
                            <form class="form-validate" role="form"  action="{{ \LaravelLocalization::localizeUrl('admin-2023/order_setting/update') }}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
    
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="row">
    
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('free_min_amount') ? 'has-error' : '' }}">
                                                    <label> {{ trans_db('dashboard.free_min_amount') }} : </label>
                                                    <input type="text" class="form-control" name="free_min_amount" value="{{ $Setting->free_min_amount }}">
                                                    <span class="text-danger">{{ $errors->first('free_min_amount') }}</span>
                                                </div>
                                            </div>
	
                                            <div class="col-lg-6">
                                                <div class="form-group {{ $errors->has('multi_shipping_cost') ? 'has-error' : '' }}">
                                                    <label for="">{{ trans_db('dashboard.multi_shipping_cost') }}</label>
                                                    <select name="multi_shipping_cost" class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        <option value="1" {{ $Setting->multi_shipping_cost == 1 ? "selected" : "" }}>{{ trans_db('dashboard.max value') }}</option>
                                                        <option value="2" {{ $Setting->multi_shipping_cost == 2 ? "selected" : "" }}>{{ trans_db('dashboard.collect shipping value') }}</option>
                                                    </select>
                                                    <span class="text-danger">{{ $errors->first('multi_shipping_cost') }}</span>
                                                </div>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
    
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Save') }} </button>
                                </div>
                            </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>         
                        <!-- /.col -->
            </section>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
            <!-- /.content -->
@endsection
        
@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
        