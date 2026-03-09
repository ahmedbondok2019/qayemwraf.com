@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
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
                        <div class="dropdown">
                            @if (in_array('26',\Illuminate\Support\Facades\Session::get("permissionData")))
                                <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/shipping_categories/create') }}" class="btn add-new btn-primary mt-50" tabindex="0">
                                    <span>{{ trans_db('dashboard.New shipping categories') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
                @livewire('dashboard.admin.shipping-category')
            </div>
        </div>
    </div>
                {{-- <div class="col-lg-4">
                    @livewire('dashboard.admin.add-shipping-category')
                </div> --}}
            {{-- </div>
        </div>
    </div> --}}
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')
@endsection
            
            