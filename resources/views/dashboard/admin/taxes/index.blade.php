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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-lg-6 p-2">
                                <h2>{{ trans_db('dashboard.tax') }}</h2>
                            </div>
                            <div class="col-lg-6 p-2">
                                <div class="dt-buttons btn-group flex-wrap">
                                    @if (in_array('109',\Illuminate\Support\Facades\Session::get("permissionData")))
                                       <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/tax/create') }}" class="btn add-new btn-primary mt-50" tabindex="0">
                                           <span>{{ trans_db('dashboard.New Tax') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @livewire('dashboard.admin.tax')
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    @livewire('dashboard.admin.add-tax')
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')

@endsection
            
            