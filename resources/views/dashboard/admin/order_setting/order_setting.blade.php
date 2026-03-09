@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

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
                                  
                            <form class="form-validate" role="form"  action="{{ \LaravelLocalization::localizeUrl('admin-2023/order_setting/update') }}" method="post" enctype="multipart/form-data">
                                @csrf
    
                                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
    
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="row">
    
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('free_min_amount') ? 'has-error' : '' }}">
                                                    <label> {{ trans_db('dashboard.free_min_amount') }} : </label>
                                                    <input type="text" class="form-control" name="free_min_amount" value="{{ $Setting->free_min_amount }}">
                                                    <span class="text-danger">{{ $errors->first('free_min_amount') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group {{ $errors->has('categories') ? 'has-error' : '' }}">
                                                    <label> {{ trans_db('dashboard.product_categories') }} : </label>
                                                    <select class="select2-size-lg form-select" multiple="multiple" id="selected_categories" name="selected_categories">
                                                        @foreach (array_filter(explode(',' , $Setting->categories), fn($value) => !is_null($value) && $value !== '') as $order_categories)
                                                            @foreach ($categories as $category)
                                                                @if ($category->id == $order_categories)
                                                                    <option value="{{ $category->id }}" selected data-cat="{{ $categories }}">{{ $category->CategoryTranslation->title }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="categories" value="{{ $Setting->categories }}">
                                                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group pt-2 {{ $errors->has('date_from') ? 'has-error' : '' }}">
                                                    <label for="exampleInputEmail3">{{ trans_db('dashboard.From') }}</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="datetime-local" class="form-control" name="date_from" value="{{ $Setting->date_from }}" placeholder="{{ __("dasboard.date_from") }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group pt-2 {{ $errors->has('date_to') ? 'has-error' : '' }}">
                                                    <label for="exampleInputEmail3">{{ trans_db('dashboard.To') }}</label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="datetime-local" class="form-control" name="date_to" value="{{ $Setting->date_to }}" placeholder="{{ __("dasboard.date_to") }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group {{ $errors->has('multi_shipping_cost') ? 'has-error' : '' }}">
                                                    <label for="">{{ trans_db('dashboard.multi_shipping_cost') }}</label>
                                                    <select name="multi_shipping_cost" class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        <option value="1" {{ $Setting->multi_shipping_cost == 1 ? "selected" : "" }}>{{ trans_db('dashboard.max value') }}</option>
                                                        <option value="2" {{ $Setting->multi_shipping_cost == 2 ? "selected" : "" }}>{{ trans_db('dashboard.collect shipping value') }}</option>
                                                    </select>
                                                    <span class="text-danger">{{ $errors->first('multi_shipping_cost') }}</span>
                                                </div>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
    
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Save') }} </button>
                                </div>
                            </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>         
                        <!-- /.col -->
            </section>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
            <!-- /.content -->
@endsection
        
@section('script')
    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    <script>
        $('#selected_categories').select2({
            ajax: {
                url: "{{ env('APP_URL') . 'api/app-2023/product_categories' }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
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

        $('#selected_categories').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
            var old_value = $("input[name=categories]").val();
            var new_value = $(this).val();
            $("input[name=categories]").val(old_value + ',' + new_value);
            $(this).trigger('change');
        });
        
        $('#selected_categories').on('select2:unselect', function (e) {
            $("input[name=categories]").val($(this).val());
            $(this).trigger('change');
        });
    </script>
@endsection
        