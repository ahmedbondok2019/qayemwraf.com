@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #39383c;
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ trans_db('dashboard.promo_code') }}</h2>

                            <div class="col-lg-6 p-2">
                                <div class="dt-buttons btn-group flex-wrap">
                                    @if (in_array('66',\Illuminate\Support\Facades\Session::get("permissionData")))
                                       <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/promo_code/create') }}" class="btn add-new btn-primary mt-50" tabindex="0">
                                           <span>{{ trans_db('dashboard.New Promo code') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            @livewire('dashboard.admin.promo-code')
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    @livewire('dashboard.admin.add-promo-code')
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    <script>
        $(document).ready(function() {
            window.initSelectProductDrop=()=>{
                $('#product_id').select2({
                    placeholder: '{{ trans_db("dashboard.Choose") }}',
                    allowClear: true});
            }
            initSelectProductDrop();
            $('#product_id').on('change', function (e) {
                livewire.emit('selectedProductItem', e.target.value)
            });
            window.livewire.on('select2',()=>{
                initSelectProductDrop();
            });

        });
        
        $(document).ready(function() {
            window.initSelectPaymentDrop=()=>{
                $('#payment_method').select2({
                    placeholder: '{{ trans_db("dashboard.Choose") }}',
                    allowClear: true});
            }
            initSelectPaymentDrop();
            $('#payment_method').on('change', function (e) {
                livewire.emit('selectedPaymentItem', e.target.value)
            });
            window.livewire.on('select2',()=>{
                initSelectPaymentDrop();
            });

        });
    </script>
    <script>
        // $('#product_id').select2({
        //     ajax: {
        //         url: "{{ env('APP_URL') . 'api/app-2023/related_products' }}",
        //         processResults: function (data, params) {
        //             params.page = params.page || 1;
                    
        //             feather.replace();
        //             return {
        //                 results: data.results,
        //                 pagination: {
        //                     more: (params.page * 10) < data.count_filtered
        //                 }
        //             };
        //         }
        //     }
        // });
    </script>

    <script>

        // var data = [
        //     {
        //         id: 0,
        //         text: "{{ trans_db('dashboard.Choose') }}"
        //     },
        //     {
        //         id: 1,
        //         text: "{{ trans_db('dashboard.Cash') }}"
        //     },
        //     {
        //         id: 2,
        //         text: "{{ trans_db('website.Fawry') }}"
        //     },
        //     {
        //         id: 3,
        //         text: "{{ trans_db('dashboard.Paytabs') }}"
        //     }
        // ];

        // $('#payment_method').select2({
        //     data: data
        // });

        // $('#payment_method').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     var old_value = $("input[name=payment_method]").val();
        //     var new_value = $(this).val();
        //     $("input[name=payment_method]").val(old_value + ',' + new_value);
        //     $(this).trigger('change');
        // });
        
        // $('#payment_method').on('select2:unselect', function (e) {
        //     $("input[name=payment_method]").val($(this).val());
        //     $(this).trigger('change');
        // });
        
        // $('#product_id').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     var old_value = $("input[name=product_id]").val();
        //     var new_value = $(this).val();
        //     $("input[name=product_id]").val(old_value + ',' + new_value);
        //     $(this).trigger('change');
        // });
        
        // $('#product_id').on('select2:unselect', function (e) {
        //     $("input[name=product_id]").val($(this).val());
        //     $(this).trigger('change');
        // });
    </script>
@endsection
            
            