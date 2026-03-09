@extends('dashboard.admin.layouts.app')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 40px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
        }
    </style>
@endsection
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.flash_sale') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.flash_sales.index') }}">{{ trans_db('dashboard.flash_sale') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}
                                    </li>
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
                                    <h4 class="card-title">{{ trans_db('dashboard.Edit') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.flash_sales.update', $flashSale->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            
                                            <!-- Basic Information Header -->
                                            <div class="col-12 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="info" class="mr-50"></i> {{ trans_db('dashboard.Basic Information') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <!-- Names in different languages -->
                                            @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="name_{{ $localeCode }}" class="font-weight-bold">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                                            </div>
                                                            <input type="text" id="name_{{ $localeCode }}"
                                                                class="form-control" name="name_{{ $localeCode }}"
                                                                value="{{ old('name_' . $localeCode, $flashSale->translations->where('locale', $localeCode)->first()->name ?? '') }}" required placeholder="{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Dates -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="start_at" class="font-weight-bold">{{ trans_db('dashboard.valid_from') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                        </div>
                                                        <input type="datetime-local" id="start_at" class="form-control" name="start_at" value="{{ $flashSale->start_at ? $flashSale->start_at->format('Y-m-d\TH:i') : '' }}" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="end_at" class="font-weight-bold">{{ trans_db('dashboard.valid_to') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                        </div>
                                                        <input type="datetime-local" id="end_at" class="form-control" name="end_at" value="{{ $flashSale->end_at ? $flashSale->end_at->format('Y-m-d\TH:i') : '' }}" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Image -->
                                             <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="image" class="font-weight-bold">{{ trans_db('dashboard.Image') }} <small class="text-muted">(500x500)</small></label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image" name="image">
                                                        <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                                    </div>
                                                </div>
                                                @if($flashSale->image)
                                                    <div class="mt-1">
                                                        <img src="{{ asset($flashSale->image) }}" alt="Flash Sale Image" class="img-thumbnail" width="100">
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="is_active" class="font-weight-bold">{{ trans_db('dashboard.Status') }}</label>
                                                    <div class="custom-control custom-switch custom-switch-success">
                                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                                            name="is_active" {{ $flashSale->is_active ? 'checked' : '' }} />
                                                        <label class="custom-control-label" for="is_active">
                                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Products Header -->
                                            <div class="col-12 mt-3 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="box" class="mr-50"></i> {{ trans_db('dashboard.Products') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <!-- Product Search -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="product_search" class="font-weight-bold">{{ trans_db('dashboard.Search Product') }}</label>
                                                    <select class="form-control select2" id="product_search"></select>
                                                </div>
                                                
                                                <div class="table-responsive mt-2">
                                                    <table class="table table-hover table-bordered table-striped text-center">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>{{ trans_db('dashboard.product Name') }}</th>
                                                                <th>{{ trans_db('dashboard.Price') }}</th>
                                                                <th style="width: 200px;">{{ trans_db('dashboard.Offer Price') }}</th>
                                                                <th>{{ trans_db('dashboard.Delete') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="products-table-body">
                                                            @foreach ($flashSale->products as $product)
                                                                <tr id="product-row-{{ $product->id }}">
                                                                    <td>
                                                                        {{ $product->translation->name ?? $product->translations->first()->name ?? 'Product #' . $product->id }}
                                                                        <input type="hidden" name="products[]" value="{{ $product->id }}">
                                                                    </td>
                                                                    <td>{{ $product->price }}</td>
                                                                    <td>
                                                                        <input type="number" step="0.01" name="prices[{{ $product->id }}]" class="form-control" placeholder="{{ trans_db('dashboard.Offer Price') }}" required value="{{ $product->pivot->price }}">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeProductRow({{ $product->id }})">
                                                                            <i data-feather="trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 text-right">
                                                <button type="reset" class="btn btn-outline-secondary mr-1">{{ trans_db('dashboard.Reset') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Submit') }}</button>
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#product_search').select2({
            placeholder: '{{ trans_db("dashboard.Search Product") }}',
            ajax: {
                url: '{{ route("admin.flash_sales.search_products") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $('#product_search').on('select2:select', function (e) {
            var data = e.params.data;
            addProductRow(data);
            $(this).val(null).trigger('change');
        });

        
    });

    function addProductRow(product) {
        // Check if product already exists
        if ($('#product-row-' + product.id).length > 0) {
            alert('{{ trans_db("dashboard.Product already added") }}');
            return;
        }

        var row = `
            <tr id="product-row-${product.id}">
                <td>
                    ${product.text}
                    <input type="hidden" name="products[]" value="${product.id}">
                </td>
                <td>${product.price}</td>
                <td>
                    <input type="number" step="0.01" name="prices[${product.id}]" class="form-control" placeholder="{{ trans_db('dashboard.Offer Price') }}" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProductRow(${product.id})">
                        <i data-feather="trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#products-table-body').append(row);
            if (typeof feather !== 'undefined') {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    }

    function removeProductRow(id) {
            $('#product-row-' + id).remove();
    }
</script>
@endsection
