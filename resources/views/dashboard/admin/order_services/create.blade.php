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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Add New Service') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.order_services.index') }}">{{ trans_db('dashboard.Order Services') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') }}</li>
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
                                    <h4 class="card-title">{{ trans_db('dashboard.Add New Service') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.order_services.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Name') }} (EN)</label>
                                                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name_ar">{{ trans_db('dashboard.Name') }} (AR)</label>
                                                    <input type="text" id="name_ar" class="form-control" name="name_ar" value="{{ old('name_ar') }}" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="price">{{ trans_db('dashboard.Price') }}</label>
                                                    <input type="number" id="price" class="form-control" name="price" value="{{ old('price') }}" step="0.01" min="0" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-switch-success mt-2">
                                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                                        <label class="custom-control-label" for="is_active">
                                                            {{ trans_db('dashboard.Active') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary mr-1">{{ trans_db('dashboard.Save') }}</button>
                                                <a href="{{ route('admin.order_services.index') }}" class="btn btn-outline-secondary">{{ trans_db('dashboard.Cancel') }}</a>
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
