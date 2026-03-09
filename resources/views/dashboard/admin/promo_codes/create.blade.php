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

                                @include('dashboard.admin.component.page_error', ['errors' => $errors])

                                <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">

                                    <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/promo_code/store') }}"
                                        method="post" enctype="multipart/form-data" role="form">
                                        @csrf

                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_name') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-name">{{ trans_db('dashboard.Title') }}</label>
                                                            <input type="text" id="basic-icon-default-name"
                                                                class="form-control dt-uname" name="promo_name"
                                                                value="" />
                                                            @error('promo_name')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_code') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-price">{{ trans_db('dashboard.promo_codes') }}</label>
                                                            <input type="text" id="basic-icon-default-price"
                                                                class="form-control dt-uname" name="promo_code"
                                                                value="" />
                                                            @error('promo_code')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promoValue') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-slug">{{ trans_db('dashboard.promoValue') }}</label>
                                                            <input type="text" id="basic-icon-default-slug"
                                                                class="form-control dt-uname" name="promoValue"
                                                                value="" />
                                                            @error('promoValue')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promoMaxAmount') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-promoMaxAmount">{{ trans_db('dashboard.promoMaxAmount') }}</label>
                                                            <input type="text" id="basic-icon-default-promoMaxAmount"
                                                                class="form-control dt-uname" name="promoMaxAmount"
                                                                value="" />
                                                            @error('promoMaxAmount')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_valid_from') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-promo_valid_from">{{ trans_db('dashboard.promo_valid_from') }}</label>
                                                            <input type="date" id="basic-icon-default-promo_valid_from"
                                                                class="form-control dt-uname" name="promo_valid_from"
                                                                value="" />
                                                            @error('promo_valid_from')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_valid_to') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-promo_valid_to">{{ trans_db('dashboard.promo_valid_to') }}</label>
                                                            <input type="date" id="basic-icon-default-promo_valid_to"
                                                                class="form-control dt-uname" name="promo_valid_to"
                                                                value="" />
                                                            @error('promo_valid_to')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_usage_count') ? 'has-error' : '' }}">
                                                            <label class="form-label"
                                                                for="basic-icon-default-promo_usage_count">{{ trans_db('dashboard.promo_usage_count') }}</label>
                                                            <input type="text" id="basic-icon-default-promo_usage_count"
                                                                class="form-control dt-uname" name="promo_usage_count"
                                                                value="" />
                                                            @error('promo_usage_count')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promoType') ? 'has-error' : '' }}">
                                                            <label
                                                                class="form-label">{{ trans_db('dashboard.promoType') }}</label>
                                                            <select class="form-control form-select-lg" name="promoType">
                                                                <option value="1">{{ trans_db('dashboard.percentage') }}
                                                                </option>
                                                                <option value="2">{{ trans_db('dashboard.fixed') }}</option>
                                                            </select>
                                                            @error('promoType')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="form-group {{ $errors->has('promo_oneUse') ? 'has-error' : '' }}">
                                                            <label
                                                                class="form-label">{{ trans_db('dashboard.Usage Limit') }}</label>
                                                            <select class="form-control form-select-lg"
                                                                name="promo_oneUse">
                                                                <option value="">{{ trans_db('dashboard.Choose') }}
                                                                </option>
                                                                <option value="1">{{ trans_db('dashboard.promo_oneUse') }}
                                                                </option>
                                                                <option value="2">{{ trans_db('dashboard.Every Order') }}
                                                                </option>
                                                            </select>
                                                            @error('promoType')
                                                                <span class="text-danger error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans_db('dashboard.payment_method') }}</label>
                                                            <select class="select2-size-lg form-select"
                                                                id="selected_payment_method"
                                                                name="selected_payment_method">
                                                                <option value="0">{{ trans_db('dashboard.Choose') }}
                                                                </option>
                                                                <option value="1">{{ trans_db('dashboard.Cash') }}</option>
                                                                <option value="2">{{ trans_db('website.Fawry') }}</option>
                                                                <option value="3">{{ trans_db('dashboard.Paytabs') }}
                                                                </option>
                                                            </select>
                                                            <input type="hidden" name="payment_method" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans_db('dashboard.product Name') }}</label>
                                                            <select class="select2-size-lg form-select"
                                                                id="selected_product_id" name="selected_product_id">
                                                                <option value="">{{ trans_db('dashboard.Choose') }}
                                                                </option>
                                                                @foreach ($products as $product)
                                                                    @if (isset($product->translation->title))
                                                                        <option value="{{ $product->id }}">
                                                                            {{ $product->translation->title }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="product_id" value="">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
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

    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    <script>
        // $('#selected_product_id').select2({
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
        var data = [{
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

        $('#selected_payment_method').select2({
            data: data
        });

        $('#selected_payment_method').on('select2:select', function(e) {
            var data = e.params.data;
            var old_value = $("input[name=payment_method]").val();
            var new_value = $(this).val();
            $("input[name=payment_method]").val(new_value);
            $(this).trigger('change');
        });

        $('#selected_payment_method').on('select2:unselect', function(e) {
            $("input[name=payment_method]").val($(this).val());
            $(this).trigger('change');
        });

        $('#selected_product_id').on('select2:select', function(e) {
            var data = e.params.data;
            var old_value = $("input[name=product_id]").val();
            var new_value = $(this).val();
            $("input[name=product_id]").val(new_value);
            $(this).trigger('change');
        });

        $('#selected_product_id').on('select2:unselect', function(e) {
            $("input[name=product_id]").val($(this).val());
            $(this).trigger('change');
        });
    </script>
@endsection
