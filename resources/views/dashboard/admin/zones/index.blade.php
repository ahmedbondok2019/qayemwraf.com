@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #d7d2d2;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 1px;
            left: 1px !important;
            width: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #ad0a0a00 transparent transparent transparent !important;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 100px;
            left: 38% !important;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
        }
    </style>
@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ trans_db('dashboard.zone') }}</h2>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @livewire('dashboard.admin.zones')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @livewire('dashboard.admin.add-zone')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')
@endsection
            
            