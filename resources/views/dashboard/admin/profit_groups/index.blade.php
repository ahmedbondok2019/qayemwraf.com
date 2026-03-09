@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

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
                            <h2>{{ trans_db('dashboard.profit_group') }}</h2>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @livewire('dashboard.admin.profit-group')
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @livewire('dashboard.admin.add-profit-group')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')

@endsection
            
            