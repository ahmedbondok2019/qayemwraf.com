@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }
        
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        input:checked + .slider {
          background-color: #f38921;
        }
        
        input:focus + .slider {
          box-shadow: 0 0 1px #f38921;
        }
        
        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }
        
        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }
        
        .slider.round:before {
          border-radius: 50%;
        }
    </style>

    <style>
        .select2-container--classic .select2-selection--single .select2-selection__arrow b, .select2-container--default .select2-selection--single .select2-selection__arrow b {
            padding-left: 0 !important;
        }
    </style>
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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/tax/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label class="form-label" for="basic-icon-default-name">{{ trans_db('dashboard.Title') }}</label>
                                                <input type="text" id="basic-icon-default-name" class="form-control dt-uname" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="title"/>
                                                @error('title') <span class="text-danger error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                                                <label class="form-label" for="basic-icon-default-value">{{ trans_db('dashboard.value') }}</label>
                                                <input type="text" id="basic-icon-default-value" class="form-control dt-uname" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="value"/>
                                                @error('value') <span class="text-danger error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-3">
                                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                                <label class="form-label">{{ trans_db('dashboard.status') }}</label>
                                                <select class="form-control form-select-lg" name="status" id="select2-basic">
                                                    <option value="0">{{ trans_db("dashboard.NotActive") }}</option>
                                                    <option value="1">{{ trans_db("dashboard.active") }}</option>
                                                </select>
                                                @error('status') <span class="text-danger error">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="col-lg-3">
                                            <div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                                                <label class="form-label">{{ trans_db('dashboard.payment_method') }}</label>
                                                <select class="form-control form-select-lg" name="payment_method" id="select2-basic">
                                                    <option value="0" >{{ trans_db("dashboard.Choose") }}</option>
                                                    <option value="1">{{ trans_db("dashboard.Cash") }}</option>
                                                    <option value="2">{{ trans_db("website.Fawry") }}</option>
                                                    <option value="3">{{ trans_db("dashboard.Paytabs") }}</option>
                                                </select>
                                                @error('status') <span class="text-danger error">{{ $message }}</span> @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.payment_method') }}</h4>
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
                                                <div class="mb-1">
                                                    <select class="select2-size-lg form-select" multiple="multiple" id="selected_payment_methods" name="selected_payment_methods">
                                                    </select>
                                                    <input type="hidden" name="payment_methods">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.product_categories_to_exclude') }}</h4>
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
                                                <div class="mb-1">
                                                    <select class="select2-size-lg form-select" multiple="multiple" id="selected_product_categories" name="selected_product_categories"></select>
                                                    <input type="hidden" name="product_categories">
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

    {!! Html::script('admin/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-number-input.js') !!}
    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    <script>
        $('#selected_product_categories').select2({
            ajax: {
                url: "{{ env('APP_URL') . 'api/app-2023/product_categories' }}",
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    
                    feather.replace();
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }
        });

        var data = [
            {
                id: 0,
                text: "{{ trans_db('dashboard.Choose') }}"
            },
            {
                id: 1,
                text: "{{ trans_db('dashboard.Cash') }}"
            },
            {
                id: 2,
                text: "{{ trans_db('website.Fawry') }}"
            },
            {
                id: 3,
                text: "{{ trans_db('dashboard.Paytabs') }}"
            }
        ];

        $('#selected_payment_methods').select2({
            data: data
        });

        $('#selected_product_categories').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
            var old_value = $("input[name=product_categories]").val();
            var new_value = $(this).val();
            $("input[name=product_categories]").val(old_value + ',' + new_value);
            $(this).trigger('change');
        });
        
        $('#selected_product_categories').on('select2:unselect', function (e) {
            $("input[name=product_categories]").val($(this).val());
            $(this).trigger('change');
        });

        $('#selected_payment_methods').on('select2:select', function (e) {
            var data = e.params.data;
            var old_value = $("input[name=payment_methods]").val();
            var new_value = $(this).val();
            $("input[name=payment_methods]").val(old_value + ',' + new_value);
            $(this).trigger('change');
        });
        
        $('#selected_payment_methods').on('select2:unselect', function (e) {
            $("input[name=payment_methods]").val($(this).val());
            $(this).trigger('change');
        });
    </script>
@endsection
