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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Edit Payment Method') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.payment_methods.index') }}">{{ trans_db('dashboard.Payment Methods') }}</a></li>
                                    <li class="breadcrumb-item active">{{ $paymentMethod->name }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Edit') }}: {{ $paymentMethod->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.payment_methods.update', $paymentMethod->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Name') }} ({{ trans_db('dashboard.Read Only') }})</label>
                                                    <input type="text" id="name" class="form-control" value="{{ $paymentMethod->name }}" disabled />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="tax">{{ trans_db('dashboard.Tax') }} (%)</label>
                                                    <input type="number" id="tax" class="form-control" name="tax" value="{{ old('tax', $paymentMethod->tax) }}" step="0.01" min="0" />
                                                </div>
                                            </div>

                                            <!-- Advanced Options -->
                                            <div class="col-12">
                                                <h5 class="mb-1 mt-1"><i data-feather="settings"></i> {{ trans_db('dashboard.Advanced Options') }}</h5>
                                                <hr>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="discount">{{ trans_db('dashboard.Discount') }}</label>
                                                    <input type="number" id="discount" class="form-control" name="discount" value="{{ old('discount', $paymentMethod->discount) }}" step="0.01" min="0" />
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="discount_type">{{ trans_db('dashboard.Discount Type') }}</label>
                                                    <select class="form-control" id="discount_type" name="discount_type">
                                                        <option value="percentage" {{ old('discount_type', $paymentMethod->discount_type) == 'percentage' ? 'selected' : '' }}>{{ trans_db('dashboard.Percentage') }} (%)</option>
                                                        <option value="fixed" {{ old('discount_type', $paymentMethod->discount_type) == 'fixed' ? 'selected' : '' }}>{{ trans_db('dashboard.Fixed') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="cod_limit">{{ trans_db('dashboard.Maximum COD Limit') }}</label>
                                                    <input type="number" id="cod_limit" class="form-control" name="cod_limit" value="{{ old('cod_limit', $paymentMethod->cod_limit) }}" step="0.01" min="0" />
                                                    <small class="form-text text-muted">{{ trans_db('dashboard.Leave empty for no limit') }}</small>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-success mt-2">
                                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $paymentMethod->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="is_active">
                                                            {{ trans_db('dashboard.Active') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary mr-1">{{ trans_db('dashboard.Save') }}</button>
                                                <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-outline-secondary">{{ trans_db('dashboard.Cancel') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
