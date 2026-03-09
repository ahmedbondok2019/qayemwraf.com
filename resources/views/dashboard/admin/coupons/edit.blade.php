@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Coupons') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">{{ trans_db('dashboard.Coupons') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        {{-- Left Column: Basic Information --}}
                        <div class="col-md-9 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="title">{{ trans_db('dashboard.Title') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="type"></i></span>
                                                    </div>
                                                    <input type="text" id="title" class="form-control" name="title" value="{{ old('title', $coupon->title) }}" placeholder="{{ trans_db('dashboard.Title') }}" />
                                                </div>
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="code">{{ trans_db('dashboard.Code') }}</label>
                                                 <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="code"></i></span>
                                                    </div>
                                                    <input type="text" id="code" class="form-control" name="code" value="{{ old('code', $coupon->code) }}" placeholder="{{ trans_db('dashboard.Code') }}" required />
                                                </div>
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <hr>
                                    <h4 class="card-title mt-1 mb-1">{{ trans_db('dashboard.Discount Details') }}</h4>

                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="discount_type">{{ trans_db('dashboard.Discount Type') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="percent"></i></span>
                                                    </div>
                                                    <select class="form-control" id="discount_type" name="discount_type">
                                                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>{{ trans_db('dashboard.Percentage') }}</option>
                                                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>{{ trans_db('dashboard.Fixed') }}</option>
                                                    </select>
                                                </div>
                                                 @error('discount_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="discount_value">{{ trans_db('dashboard.Discount Value') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="dollar-sign"></i></span>
                                                    </div>
                                                    <input type="number" step="0.01" id="discount_value" class="form-control" name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}" required />
                                                </div>
                                                 @error('discount_value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="max_discount">{{ trans_db('dashboard.Max Discount') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="maximize"></i></span>
                                                    </div>
                                                    <input type="number" step="0.01" id="max_discount" class="form-control" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" />
                                                </div>
                                                 @error('max_discount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="valid_from">{{ trans_db('dashboard.Valid From') }}</label>
                                                 <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="valid_from" class="form-control" name="valid_from" value="{{ old('valid_from', optional($coupon->valid_from)->format('Y-m-d')) }}" />
                                                </div>
                                                 @error('valid_from')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="valid_until">{{ trans_db('dashboard.Valid Until') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="valid_until" class="form-control" name="valid_until" value="{{ old('valid_until', optional($coupon->valid_until)->format('Y-m-d')) }}" />
                                                </div>
                                                 @error('valid_until')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="usage_limit">{{ trans_db('dashboard.Usage Limit') }}</label>
                                                 <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="hash"></i></span>
                                                    </div>
                                                    <input type="number" id="usage_limit" class="form-control" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" />
                                                </div>
                                                 @error('usage_limit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="usage_limitation">{{ trans_db('dashboard.Usage Limitation') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="users"></i></span>
                                                    </div>
                                                    <select class="form-control" id="usage_limitation" name="usage_limitation">
                                                        <option value="">{{ trans_db('dashboard.Select') }}</option>
                                                        <option value="all" {{ old('usage_limitation', $coupon->usage_limitation) == 'all' ? 'selected' : '' }}>{{ trans_db('dashboard.All Users') }}</option>
                                                        <option value="once_per_user" {{ old('usage_limitation', $coupon->usage_limitation) == 'once_per_user' ? 'selected' : '' }}>{{ trans_db('dashboard.Once Per User') }}</option>
                                                    </select>
                                                </div>
                                                @error('usage_limitation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Details --}}
                        <div class="col-md-3 col-12">
                            <div class="card">
                                <div class="card-body">
                                     <div class="form-group">
                                        <label for="is_active">{{ trans_db('dashboard.Status') }}</label>
                                        <div class="custom-control custom-switch custom-switch-success">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $coupon->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="include_shipping">{{ trans_db('dashboard.Include Shipping') }}</label>
                                        <div class="custom-control custom-switch custom-switch-success">
                                            <input type="checkbox" class="custom-control-input" id="include_shipping" name="include_shipping" value="1" {{ old('include_shipping', $coupon->include_shipping) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="include_shipping">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="include_services">{{ trans_db('dashboard.Include Services') }}</label>
                                        <div class="custom-control custom-switch custom-switch-success">
                                            <input type="checkbox" class="custom-control-input" id="include_services" name="include_services" value="1" {{ old('include_services', $coupon->include_services) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="include_services">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_method_id">{{ trans_db('dashboard.Payment Method') }}</label>
                                        <select class="form-control select2" id="payment_method_id" name="payment_method_id[]" multiple>
                                            @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" 
                                                    {{ (is_array(old('payment_method_id', $coupon->payment_method_id)) && in_array($method->id, old('payment_method_id', $coupon->payment_method_id ?? []))) ? 'selected' : '' }}>
                                                    {{ $method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                         @error('payment_method_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_id">{{ trans_db('dashboard.Product') }}</label>
                                        <select class="form-control select2" id="product_id" name="product_id[]" multiple>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" 
                                                    {{ (is_array(old('product_id', $coupon->product_id)) && in_array($product->id, old('product_id', $coupon->product_id ?? []))) ? 'selected' : '' }}>
                                                    {{ $product->translation->name ?? $product->translations->first()->name ?? $product->name ?? 'Product #' . $product->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                         @error('product_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">{{ trans_db('dashboard.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endsection
