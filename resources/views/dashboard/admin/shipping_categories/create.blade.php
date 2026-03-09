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
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start m-1">{{ trans_db('dashboard.shipping_categories') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        
                    </div>
                </div>
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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/shipping_categories/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.title') }}</label>
                                                {!! Form::text('title', old('title'), ['placeholder'=> trans_db('dashboard.title'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><label for="">ID</label></th>
                                                    <th><label for="">{{ trans_db("dashboard.Title") }}</label></th>
                                                    <th><label for="">{{ trans_db("dashboard.value") }}</label></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($areas as $area)
                                                    <tr>
                                                        <input type="hidden" name="areas[area_id][]" value="{{ $area->id }}">
                                                        <td><label for="">{{ $area->id }}</label></td>
                                                        <td><label for="">{{ $area->translations()->first()->title }}</label></td>
                                                        <td><input class="form-control" type="text" name="areas[value][]" value=""></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>
                                    <!-- users edit account form ends -->
                                </div>
                                <!-- Account Tab ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
