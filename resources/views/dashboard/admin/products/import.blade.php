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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Import Products') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans_db('dashboard.Products') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Import') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Upload CSV File') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <a href="{{ route('admin.products.import_template', ['format' => 'csv']) }}" class="btn btn-outline-secondary btn-sm">
                                    <i data-feather="download" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Download CSV Template') }}</span>
                                </a>
                                <a href="{{ route('admin.products.import_template', ['format' => 'xlsx']) }}" class="btn btn-outline-secondary btn-sm ml-50">
                                    <i data-feather="download" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Download Excel Template') }}</span>
                                </a>
                                <a href="{{ route('admin.products.export_categories') }}" class="btn btn-outline-info btn-sm ml-50">
                                    <i data-feather="list" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Export Categories List') }}</span>
                                </a>
                                <a href="{{ route('admin.products.export_brands') }}" class="btn btn-outline-info btn-sm ml-50">
                                    <i data-feather="tag" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Export Brands List') }}</span>
                                </a>
                            </div>

                            <form action="{{ route('admin.products.import_process') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-2">
                                    <label for="file">{{ trans_db('dashboard.CSV File') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file" accept=".csv" required>
                                        <label class="custom-file-label" for="file">{{ trans_db('dashboard.Choose CSV file') }}</label>
                                    </div>
                                    @error('file')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="upload" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Import Now') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-info">{{ trans_db('dashboard.Instructions') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted">
                                {{ trans_db('dashboard.Please ensure your CSV file has the following columns in order:') }}
                            </p>
                            <ul class="list-group list-group-flush list-group-bordered">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>name_ar</span>
                                    <span class="badge badge-light-danger">{{ trans_db('dashboard.Required') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>name_en</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>price</span>
                                    <span class="badge badge-light-warning">{{ trans_db('dashboard.Numeric') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>quantity</span>
                                    <span class="badge badge-light-warning">{{ trans_db('dashboard.Numeric') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>brand</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-danger">
                                    <span>image_folder</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>shipping_section</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>sku</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Text') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    <span>category</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.ID or Name (comma-separated)') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    <span>weight</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Numeric') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    <span>max_order_qty</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Numeric') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    <span>ignore_quantity</span>
                                    <span class="badge badge-light-secondary">0 / 1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                                    <span>special_price</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Numeric') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                                    <span>special_price_start</span>
                                    <span class="badge badge-light-secondary">YYYY-MM-DD</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                                    <span>special_price_end</span>
                                    <span class="badge badge-light-secondary">YYYY-MM-DD</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-info">
                                    <span>is_best_seller</span>
                                    <span class="badge badge-light-secondary">0 / 1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-info">
                                    <span>best_seller_start</span>
                                    <span class="badge badge-light-secondary">YYYY-MM-DD</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-info">
                                    <span>best_seller_end</span>
                                    <span class="badge badge-light-secondary">YYYY-MM-DD</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center text-warning">
                                    <span>is_gift</span>
                                    <span class="badge badge-light-secondary">0 / 1</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>description_ar</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>description_en</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>meta_title_ar</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>meta_title_en</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>meta_description_ar</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>meta_description_en</span>
                                    <span class="badge badge-light-secondary">{{ trans_db('dashboard.Optional') }}</span>
                                </li>
                            </ul>
                            
                            <div class="alert alert-warning mt-2" role="alert">
                                <div class="alert-body">
                                    <i data-feather="alert-triangle" class="mr-50"></i>
                                    <span>{{ trans_db('dashboard.Heading row is required in the CSV file.') }}</span>
                                </div>
                            </div>

                            <div class="alert alert-info mt-1" role="alert">
                                <div class="alert-body">
                                    <i data-feather="info" class="mr-50"></i>
                                    <span>{{ trans_db('dashboard.Images Instruction') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
