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
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
                                </div>
                                <div class="card-body">
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
                                                <h5 class="mb-1 border-bottom pb-1 text-primary">{{ $properties['native'] }}</h5>
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="name_{{ $localeCode }}">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                            <input type="text" id="name_{{ $localeCode }}" class="form-control" name="name_{{ $localeCode }}" value="{{ old('name_' . $localeCode) }}" required />
                                                            @error('name_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="meta_title_{{ $localeCode }}">{{ trans_db('dashboard.Meta Title') }} ({{ $properties['native'] }})</label>
                                                            <input type="text" id="meta_title_{{ $localeCode }}" class="form-control" name="meta_title_{{ $localeCode }}" value="{{ old('meta_title_' . $localeCode) }}" />
                                                            @error('meta_title_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="description_{{ $localeCode }}">{{ trans_db('dashboard.Description') }} ({{ $properties['native'] }})</label>
                                                            <textarea id="description_{{ $localeCode }}" class="form-control tinymce-editor" name="description_{{ $localeCode }}">{{ old('description_' . $localeCode) }}</textarea>
                                                            @error('description_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="meta_description_{{ $localeCode }}">{{ trans_db('dashboard.Meta Description') }} ({{ $properties['native'] }})</label>
                                                            <textarea id="meta_description_{{ $localeCode }}" class="form-control tinymce-editor" name="meta_description_{{ $localeCode }}">{{ old('meta_description_' . $localeCode) }}</textarea>
                                                            @error('meta_description_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="meta_keywords_{{ $localeCode }}">{{ trans_db('dashboard.Meta Keywords') }} ({{ $properties['native'] }})</label>
                                                            <textarea id="meta_keywords_{{ $localeCode }}" class="form-control" name="meta_keywords_{{ $localeCode }}">{{ old('meta_keywords_' . $localeCode) }}</textarea>
                                                            @error('meta_keywords_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Data Tab --}}
                                        <div class="tab-pane" id="data" aria-labelledby="data-tab" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="sku">{{ trans_db('dashboard.Model') }} / SKU</label>
                                                        <input type="text" id="sku" class="form-control" name="sku" value="{{ old('sku') }}" />
                                                        @error('sku')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="price">{{ trans_db('dashboard.Price') }}</label>
                                                        <input type="number" step="0.01" id="price" class="form-control" name="price" value="{{ old('price') }}" required />
                                                        @error('price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="weight">{{ trans_db('dashboard.weight') }}</label>
                                                        <input type="number" step="0.01" id="weight" class="form-control" name="weight" value="{{ old('weight') }}" />
                                                        @error('weight')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="quantity">{{ trans_db('dashboard.Quantity') }}</label>
                                                        <input type="number" id="quantity" class="form-control" name="quantity" value="{{ old('quantity') }}" />
                                                        @error('quantity')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="max_order_qty">{{ trans_db('dashboard.max_order') }}</label>
                                                        <input type="number" id="max_order_qty" class="form-control" name="max_order_qty" value="{{ old('max_order_qty') }}" />
                                                        @error('max_order_qty')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group mt-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="ignore_quantity" name="ignore_quantity" {{ old('ignore_quantity') ? 'checked' : '' }} />
                                                            <label class="custom-control-label" for="ignore_quantity">{{ trans_db('dashboard.ignore_quantity') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="mt-2 border-bottom pb-1 mb-1 text-primary">{{ trans_db('dashboard.Special Offer') }}</h5>
                                            <div class="row">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="special_price">{{ trans_db('dashboard.Offer Price') }}</label>
                                                        <input type="number" step="0.01" id="special_price" class="form-control" name="special_price" value="{{ old('special_price') }}" />
                                                        @error('special_price')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="special_price_start">{{ trans_db('dashboard.valid_from') }}</label>
                                                        <input type="date" id="special_price_start" class="form-control" name="special_price_start" value="{{ old('special_price_start') }}" />
                                                        @error('special_price_start')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="special_price_end">{{ trans_db('dashboard.valid_to') }}</label>
                                                        <input type="date" id="special_price_end" class="form-control" name="special_price_end" value="{{ old('special_price_end') }}" />
                                                        @error('special_price_end')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <h5 class="mt-2 border-bottom pb-1 mb-1 text-primary">{{ trans_db('dashboard.best_seller') }}</h5>
                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                     <div class="form-group mt-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="is_best_seller" name="is_best_seller" {{ old('is_best_seller') ? 'checked' : '' }} />
                                                            <label class="custom-control-label" for="is_best_seller">{{ trans_db('dashboard.best_seller') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                     <div class="form-group">
                                                        <label for="is_gift">{{ trans_db('dashboard.gift') }}</label>
                                                        <div class="custom-control custom-switch custom-switch-primary">
                                                            <input type="checkbox" class="custom-control-input" id="is_gift" name="is_gift" {{ old('is_gift') ? 'checked' : '' }} />
                                                            <label class="custom-control-label" for="is_gift">
                                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="best_seller_start">{{ trans_db('dashboard.valid_from') }}</label>
                                                        <input type="date" id="best_seller_start" class="form-control" name="best_seller_start" value="{{ old('best_seller_start') }}" />
                                                        @error('best_seller_start')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="best_seller_end">{{ trans_db('dashboard.valid_to') }}</label>
                                                        <input type="date" id="best_seller_end" class="form-control" name="best_seller_end" value="{{ old('best_seller_end') }}" />
                                                        @error('best_seller_end')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Options Tab --}}
                                        <div class="tab-pane" id="options" aria-labelledby="options-tab" role="tabpanel">
                                            <div class="form-group">
                                                <label for="option_search">{{ trans_db('dashboard.Search Option') }}</label>
                                                <select class="form-control select2" id="option_search">
                                                    <option value="">{{ trans_db('dashboard.Select') }}</option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary mt-1" id="add-option-btn">{{ trans_db('dashboard.Add New') }}</button>
                                            </div>
                                            <hr>
                                            <div id="product-options-container">
                                                {{-- Dynamic Option Blocks --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="status">{{ trans_db('dashboard.Status') }}</label>
                                        <div class="custom-control custom-switch custom-switch-success">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked />
                                            <label class="custom-control-label" for="status">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="show_on_home">{{ trans_db('dashboard.Front-end') }}</label>
                                        <div class="custom-control custom-switch custom-switch-info">
                                            <input type="checkbox" class="custom-control-input" id="show_on_home" name="show_on_home" checked />
                                            <label class="custom-control-label" for="show_on_home">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product_brand_id">{{ trans_db('dashboard.Brands') }}</label>
                                        <select class="form-control select2" name="product_brand_id" id="product_brand_id">
                                            <option value="">{{ trans_db('dashboard.Select') }}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('product_brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_brand_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="shipping_rule_id">{{ trans_db('dashboard.Shipping Rules') }}</label>
                                        <select class="form-control select2" name="shipping_rule_id" id="shipping_rule_id">
                                            <option value="">{{ trans_db('dashboard.Select') }}</option>
                                            @foreach($shippingRules as $rule)
                                                <option value="{{ $rule->id }}" {{ old('shipping_rule_id') == $rule->id ? 'selected' : '' }}>{{ $rule->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('shipping_rule_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans_db('dashboard.Categories') }}</label>
                                        <select class="form-control select2" name="categories[]" multiple>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @if($category->children && $category->children->count())
                                                    @foreach($category->children as $child)
                                                        <option value="{{ $child->id }}" {{ (collect(old('categories'))->contains($child->id)) ? 'selected' : '' }}>-- {{ $child->name }}</option>
                                                        @if($child->children && $child->children->count())
                                                            @foreach($child->children as $subchild)
                                                                 <option value="{{ $subchild->id }}" {{ (collect(old('categories'))->contains($subchild->id)) ? 'selected' : '' }}>---- {{ $subchild->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="image">{{ trans_db('dashboard.Image') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="gallery">{{ trans_db('dashboard.Images') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="gallery" name="gallery[]" multiple>
                                            <label class="custom-file-label" for="gallery">{{ trans_db('dashboard.Choose file') }}</label>
                                        </div>
                                        @error('gallery')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">{{ trans_db('dashboard.Submit') }}</button>
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
        $('.select2').select2();
        let optionIndex = 0;

        // Restore old options if they exist
        const oldOptions = @json(old('product_options'));
        
        if (oldOptions && Object.keys(oldOptions).length > 0) {
            Object.keys(oldOptions).forEach(function(index) {
                let opt = oldOptions[index];
                let optionId = opt.option_id;
                // Find name from the select box
                let optionName = $(`#option_search option[value="${optionId}"]`).text();
                
                if(optionId && optionName) {
                    // Fetch values and rebuild
                    let url = "{{ route('admin.products.option.values', ':id') }}";
                    url = url.replace(':id', optionId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        async: false, // Ensure sequential addition to keep index order roughly correct (though index is explicit in old data)
                        success: function(values) {
                             addOptionBlock(optionId, optionName, values);
                             
                             // Now add the values rows
                             if (opt.values) {
                                 Object.keys(opt.values).forEach(function(valId) {
                                     let valData = opt.values[valId];
                                     let valName = '';
                                     // Find value name in the loaded values
                                     let valueObj = values.find(v => v.id == valId);
                                     if (valueObj) {
                                         valName = valueObj.name || (valueObj.translation ? valueObj.translation.name : '');
                                     }

                                     if(valName) {
                                         addValueRow(index, optionId, valId, valName, valData);
                                     }
                                 });
                                 
                                 // Update index to avoid conflicts
                                 if (index >= optionIndex) {
                                     optionIndex = parseInt(index) + 1;
                                 }
                             }
                        }
                    });
                }
            });
        }

        $('#add-option-btn').click(function() {
            let optionId = $('#option_search').val();
            let optionName = $('#option_search option:selected').text();
            
            if (!optionId) {
                alert('Please select an option first');
                return;
            }
            
            if ($(`#option-block-${optionId}`).length > 0) {
                 alert('Option already added');
                 return;
            }

            // Fetch values via AJAX
            let url = "{{ route('admin.products.option.values', ':id') }}";
            url = url.replace(':id', optionId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(values) {
                     addOptionBlock(optionId, optionName, values);
                },
                error: function(xhr) {
                    alert('Error loading option values: ' + xhr.statusText);
                }
            });
        });

        function addOptionBlock(id, name, values) {
            let valuesHtml = '';
            values.forEach(val => {
               valuesHtml += `<option value="${val.id}">${val.name || val.translation?.name}</option>`;
            });

            let block = `
                <div class="card border mb-2" id="option-block-${id}">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h5 class="mb-0">${name}</h5>
                        <div>
                             <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="req_${id}" name="product_options[${optionIndex}][required]" checked>
                                <label class="custom-control-label" for="req_${id}">{{ trans_db('dashboard.Required') }}</label>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger remove-option-block" data-id="${id}"><i data-feather="trash"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="product_options[${optionIndex}][option_id]" value="${id}">
                        <table class="table table-bordered table-sm option-values-table" id="option-values-table-${id}">
                            <thead>
                                <tr class="text-center bg-light">
                                    <th>{{ trans_db('dashboard.Value') }}</th>
                                    <th>{{ trans_db('dashboard.Quantity') }}</th>
                                    <th>{{ trans_db('dashboard.reduce quantity') }}</th>
                                    <th>{{ trans_db('dashboard.Price') }} (+/-)</th>
                                    <th>{{ trans_db('dashboard.weight') }} (+/-)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="mt-2 d-flex align-items-center">
                            <select class="form-control w-auto mr-1" id="value-select-${id}">
                                ${valuesHtml}
                            </select>
                            <button type="button" class="btn btn-sm btn-success add-value-row-btn mr-1" data-index="${optionIndex}" data-id="${id}">
                                <i data-feather="plus"></i> {{ trans_db('dashboard.Add New Item') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary add-all-values-btn" data-index="${optionIndex}" data-id="${id}">
                                {{ trans_db('dashboard.Add All Values') ?? 'إضافة كل القيم' }}
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            $('#product-options-container').append(block);
            
            // Automatically add all values on creation
            values.forEach(val => {
                addValueRow(optionIndex, id, val.id, val.name || val.translation?.name);
            });

            if(feather) feather.replace();
            optionIndex++;
        }

        $(document).on('click', '.add-all-values-btn', function() {
            let id = $(this).data('id');
            let idx = $(this).data('index');
            let select = $(`#value-select-${id}`);
            
            select.find('option').each(function() {
                let valId = $(this).val();
                let valName = $(this).text();
                if ($(`#val-row-${idx}-${valId}`).length === 0) {
                    addValueRow(idx, id, valId, valName);
                }
            });
        });
        
        function addValueRow(idx, id, valueId, valueName, data = null) {
             let qty = data ? data.quantity : 100;
             let subtract = data ? data.subtract_stock : 1;
             
             let pricePrefix = data ? data.price_prefix : '+';
             let price = data ? data.price : 0;
             
             let weightPrefix = data ? data.weight_prefix : '+';
             let weight = data ? data.weight : 0;

             let row = `
                <tr id="val-row-${idx}-${valueId}">
                    <td>
                        ${valueName}
                        <input type="hidden" name="product_options[${idx}][values][${valueId}][value_id]" value="${valueId}">
                    </td>
                    <td><input type="number" class="form-control" name="product_options[${idx}][values][${valueId}][quantity]" value="${qty}"></td>
                    <td>
                        <select class="form-control" name="product_options[${idx}][values][${valueId}][subtract_stock]">
                            <option value="1" ${subtract == 1 ? 'selected' : ''}>{{ trans_db('dashboard.Yes') }}</option>
                            <option value="0" ${subtract == 0 ? 'selected' : ''}>{{ trans_db('dashboard.No') }}</option>
                        </select>
                    </td>
                    <td class="d-flex">
                        <select class="form-control mr-1 w-25" name="product_options[${idx}][values][${valueId}][price_prefix]">
                            <option value="+" ${pricePrefix == '+' ? 'selected' : ''}>+</option>
                            <option value="-" ${pricePrefix == '-' ? 'selected' : ''}>-</option>
                        </select>
                        <input type="number" step="0.01" class="form-control" name="product_options[${idx}][values][${valueId}][price]" value="${price}">
                    </td>
                    <td class="d-flex">
                         <select class="form-control mr-1 w-25" name="product_options[${idx}][values][${valueId}][weight_prefix]">
                            <option value="+" ${weightPrefix == '+' ? 'selected' : ''}>+</option>
                            <option value="-" ${weightPrefix == '-' ? 'selected' : ''}>-</option>
                        </select>
                        <input type="number" step="0.01" class="form-control" name="product_options[${idx}][values][${valueId}][weight]" value="${weight}">
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-value-row"><i data-feather="trash"></i></button></td>
                </tr>
            `;
            $(`#option-values-table-${id} tbody`).append(row);
            if(feather) feather.replace();
        }

        $(document).on('click', '.remove-option-block', function() {
            let id = $(this).data('id');
            $(`#option-block-${id}`).remove();
        });

        $(document).on('click', '.add-value-row-btn', function() {
            let id = $(this).data('id');
            let idx = $(this).data('index'); // This captures the index at time of creation
            
             // If we rely on stored index, ensure restoration sets it correctly in DOM
             // The addOptionBlock uses global optionIndex at time of render. 
             // That is correct.

            let valueSelect = $(`#value-select-${id}`);
            let valueId = valueSelect.val();
            let valueName = valueSelect.find('option:selected').text();
            
            // Check if value already exists
             if ($(`#val-row-${idx}-${valueId}`).length > 0) {
                 alert('Value already added');
                 return;
            }
            
            addValueRow(idx, id, valueId, valueName);
        });

        $(document).on('click', '.remove-value-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
<style>
    /* Correction to style d-flex cells correctly */
    .d-flex { display: flex !important; }
</style>
@endsection