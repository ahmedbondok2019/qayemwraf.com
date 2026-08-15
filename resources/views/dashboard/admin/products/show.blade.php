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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Products') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans_db('dashboard.Products') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Show') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <a href="{{ frontend_site_url(url('/products/' . $product->id)) }}" target="_blank" class="btn btn-success">
                            <i data-feather="external-link"></i> {{ trans_db('dashboard.View on Site') }}
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <i data-feather="edit"></i> {{ trans_db('dashboard.Edit') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <!-- Product Details -->
                    <div class="col-md-8 col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
                            </div>
                            <div class="card-body pt-2">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" aria-controls="general" role="tab" aria-selected="true">{{ trans_db('dashboard.General') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" aria-controls="data" role="tab" aria-selected="false">{{ trans_db('dashboard.Data') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" aria-controls="options" role="tab" aria-selected="false">{{ trans_db('dashboard.Options') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    {{-- General Tab --}}
                                    <div class="tab-pane active" id="general" aria-labelledby="general-tab" role="tabpanel">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            @php
                                                $translation = $product->translations->where('locale', $localeCode)->first();
                                            @endphp
                                            <div class="mt-2">
                                                <h5 class="mb-1 border-bottom pb-1 text-primary">{{ $properties['native'] }}</h5>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Name') }}:</div>
                                                    <div class="col-sm-9">{{ $translation->name ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Slug') }}:</div>
                                                    <div class="col-sm-9 text-muted small">{{ $translation->slug ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Meta Title') }}:</div>
                                                    <div class="col-sm-9">{{ $translation->meta_title ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Description') }}:</div>
                                                    <div class="col-sm-9 border rounded p-1 bg-lighten-5" style="max-height: 200px; overflow-y: auto;">
                                                        {!! $translation->description ?? '-' !!}
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Meta Description') }}:</div>
                                                    <div class="col-sm-9 small text-muted border rounded p-1 bg-lighten-5">
                                                        {!! $translation->meta_description ?? '-' !!}
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-sm-3 font-weight-bold">{{ trans_db('dashboard.Meta Keywords') }}:</div>
                                                    <div class="col-sm-9 small text-muted border rounded p-1 bg-lighten-5">
                                                        {{ $translation->meta_keywords ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Data Tab --}}
                                    <div class="tab-pane" id="data" aria-labelledby="data-tab" role="tabpanel">
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.Model') }} / SKU:</th>
                                                        <td>{{ $product->sku ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.Price') }}:</th>
                                                        <td class="text-success font-weight-bold">
                                                            @if($product->has_special_price)
                                                                <span class="text-muted mr-1" style="text-decoration: line-through;">{{ number_format($product->price, 2) }}</span>
                                                                <span class="text-success">{{ number_format($product->special_price, 2) }}</span>
                                                            @else
                                                                <span>{{ number_format($product->price, 2) }}</span>
                                                            @endif
                                                            {{ $product->currency_symbol }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.Quantity') }}:</th>
                                                        <td>
                                                            @if($product->ignore_quantity)
                                                                <span class="badge badge-light-secondary">{{ trans_db('dashboard.ignore_quantity') }}</span>
                                                            @else
                                                                <span class="badge badge-light-{{ $product->quantity > 0 ? 'success' : 'danger' }}">{{ $product->quantity }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.max_order') }}:</th>
                                                        <td>{{ $product->max_order_qty ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.weight') }}:</th>
                                                        <td>{{ $product->weight ?? '0' }} kg</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6 border-left">
                                                <h6 class="text-primary">{{ trans_db('dashboard.Special Offer') }}</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.Offer Price') }}:</th>
                                                        <td>{{ $product->special_price ? number_format($product->special_price, 2) . ' ' . $product->currency_symbol : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.valid_from') }}:</th>
                                                        <td>{{ $product->special_price_start ? $product->special_price_start->format('Y-m-d') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.valid_to') }}:</th>
                                                        <td>{{ $product->special_price_end ? $product->special_price_end->format('Y-m-d') : '-' }}</td>
                                                    </tr>
                                                </table>

                                                <h6 class="text-primary mt-1">{{ trans_db('dashboard.best_seller') }}</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.Status') }}:</th>
                                                        <td>{!! $product->is_best_seller ? '<span class="badge badge-light-primary">Yes</span>' : 'No' !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.valid_from') }}:</th>
                                                        <td>{{ $product->best_seller_start ? $product->best_seller_start->format('Y-m-d') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pl-0">{{ trans_db('dashboard.valid_to') }}:</th>
                                                        <td>{{ $product->best_seller_end ? $product->best_seller_end->format('Y-m-d') : '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Options Tab --}}
                                    <div class="tab-pane" id="options" aria-labelledby="options-tab" role="tabpanel">
                                        <div class="mt-2">
                                            @forelse($product->productOptions as $prodOption)
                                                <div class="card border mb-2 shadow-none">
                                                    <div class="card-header bg-light-secondary p-1">
                                                        <h6 class="mb-0">{{ $prodOption->option->name ?? '-' }} @if($prodOption->required) <small class="text-danger">({{ trans_db('dashboard.Required') }})</small> @endif</h6>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        <table class="table table-sm table-hover mb-0">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>{{ trans_db('dashboard.Value') }}</th>
                                                                    <th>{{ trans_db('dashboard.Quantity') }}</th>
                                                                    <th>{{ trans_db('dashboard.Price') }}</th>
                                                                    <th>{{ trans_db('dashboard.weight') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($prodOption->values as $val)
                                                                    <tr>
                                                                        <td>{{ $val->optionValue->value ?? '-' }}</td>
                                                                        <td>{{ $val->quantity }} @if($val->subtract_stock) <i data-feather="trending-down" class="text-warning" title="Reduces stock"></i> @endif</td>
                                                                        <td>{{ $val->price_increment ? '+' : '-' }}{{ number_format($val->price, 2) }}</td>
                                                                        <td>{{ $val->weight_increment ? '+' : '-' }}{{ $val->weight }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-2 text-muted">
                                                    {{ trans_db('dashboard.No Options Found') }}
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Related Products -->
                         <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.Related Products') }}</h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="row">
                                    @forelse($product->relatedProducts as $related)
                                        <div class="col-md-3 col-6 mb-2">
                                            <div class="border rounded text-center p-1">
                                                <img src="{{ asset($related->image ?? 'assets/images/placeholder.png') }}" class="img-fluid rounded mb-1" style="height: 100px; object-fit: contain;">
                                                <p class="mb-0 text-truncate font-weight-bold">{{ $related->name }}</p>
                                                <small class="text-muted">{{ number_format($related->price, 2) }} {{ $related->currency_symbol }}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center text-muted">No related products.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="col-md-4 col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.Main View') }}</h4>
                            </div>
                            <div class="card-body pt-2 text-center">
                                <div class="mb-2">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                    @else
                                        <div class="bg-light p-3 rounded">No main image</div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-around mb-2">
                                    <div>
                                        <small class="text-muted d-block">{{ trans_db('dashboard.Status') }}</small>
                                        @if($product->status)
                                            <span class="badge badge-light-success">{{ trans_db('dashboard.active') }}</span>
                                        @else
                                            <span class="badge badge-light-danger">{{ trans_db('dashboard.inactive') }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans_db('dashboard.gift') }}</small>
                                        @if($product->is_gift)
                                            <span class="badge badge-light-warning"><i data-feather="gift" style="width: 12px; height: 12px;"></i> Yes</span>
                                        @else
                                            <span class="badge badge-light-secondary">No</span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="text-left">
                                    <div class="mb-1">
                                        <h6 class="mb-0"><i data-feather="tag" class="mr-1"></i>{{ trans_db('dashboard.Brands') }}</h6>
                                        <p class="ml-2 mb-0">{{ $product->brand->name ?? '-' }}</p>
                                    </div>
                                    <div class="mb-1">
                                        <h6 class="mb-0"><i data-feather="folder" class="mr-1"></i>{{ trans_db('dashboard.Categories') }}</h6>
                                        <div class="ml-2 mt-1">
                                            @foreach($product->categories as $cat)
                                                <span class="badge badge-light-info mb-1">{{ $cat->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <h6 class="mb-0"><i data-feather="truck" class="mr-1"></i>{{ trans_db('dashboard.Shipping Rules') }}</h6>
                                        <p class="ml-2 mb-0">{{ $product->shippingRule->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.Gallery') }}</h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="row">
                                    @forelse($product->images as $img)
                                        <div class="col-4 mb-1">
                                             <a href="{{ asset($img->image) }}" target="_blank">
                                                <img src="{{ asset($img->image) }}" class="img-fluid rounded border shadow-sm h-100" style="object-fit: cover;">
                                             </a>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center text-muted">No exhibition images.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Logistics -->
                        <div class="card">
                            <div class="card-body">
                                <p class="small text-muted mb-0">Created: {{ $product->created_at->format('Y-m-d H:i') }}</p>
                                <p class="small text-muted mb-0">Last Updated: {{ $product->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        if(feather) feather.replace();
    });
</script>
@endsection
