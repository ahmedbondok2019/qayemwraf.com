<div class="card product_product" id="product_product{{ $product->id }}">
    <div class="card-content collapse show" style="">
        <div class="card-body">
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans_db('dashboard.product Name') }}</th>
                                        <th>{{ trans_db('dashboard.Price') }}</th>
                                        <th>{{ trans_db('dashboard.Offer Price') }}</th>
                                        <th>{{ trans_db('dashboard.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="op[product{{ $product->id }}][product_id]"
                                                value="{{ $product->id }}">
                                            {{ $product->translation->title }}
                                        </td>
                                        <td>
                                            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                                <div class="input-group input-group-lg">
                                                    <input type="number" class="touchspin"
                                                        value="{{ intval($product->price) }}"
                                                        name="op[product{{ $product->id }}][price]" />
                                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                                                <div class="input-group input-group-lg">
                                                    <input type="number" class="touchspin"
                                                        value="{{ intval($product->sale_price) }}"
                                                        name="op[product{{ $product->id }}][sale_price]" />
                                                    <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a data-action="close" onclick="removeItem(this)"><i class="feather-32"
                                                    data-feather='trash-2'></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
