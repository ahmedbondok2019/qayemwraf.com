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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/area/addAreaTrans') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <input type="hidden" name="area_id" value="{{ $id }}">

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">
                                        <x-admin.setting.input :col="'6'" :field="'title'" :value="old('title')" :trans="trans_db('dashboard.title')" />
                                        <x-admin.setting.input :col="'6'" :field="'shipping_time'" :value="old('shipping_time')" :trans="trans_db('dashboard.shipping_time')" />
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
