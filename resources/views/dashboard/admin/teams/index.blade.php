@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    <!-- BEGIN: Page CSS-->
{{--    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}--}}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}
    <!-- END: Page CSS-->

@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @livewire('dashboard.admin.team')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {!! Html::script('admin/app-assets/vendors/js/vendors.min.js') !!}

    {!! Html::script('admin/old/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}

   
    <!-- BEGIN: Theme JS-->
    {!! Html::script('admin/app-assets/js/core/app-menu.js') !!}
    {!! Html::script('admin/app-assets/js/core/app.js') !!}
    
@endsection
            
            