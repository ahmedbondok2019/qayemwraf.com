@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

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
                            <h2>{{ trans_db('dashboard.area') }}</h2>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @livewire('dashboard.admin.areas')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @livewire('dashboard.admin.add-area')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')

@endsection
            
            