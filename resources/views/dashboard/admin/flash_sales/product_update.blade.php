<div class="card product_product" id="product_product{{ $item->id }}">
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
                                    <?php
                                    $product = \App\Models\Product::find($item->product_id);
                                    ?>
                                    @if (isset($product))
                                        <tr>
                                            <td>
                                                <input type="hidden" name="op[product{{ $product->id }}][id]"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" class="product_id"
                                                    name="op[product{{ $product->id }}][product_id]"
                                                    value="{{ $product->id }}">
                                                {{ $product->translation->title }}
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" value="{{ intval($item->price) }}"
                                                            name="op[product{{ $product->id }}][price]" />
                                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="form-group {{ $errors->has('sale_price') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" value="{{ intval($item->sale_price) }}"
                                                            name="op[product{{ $product->id }}][sale_price]" />
                                                        <span
                                                            class="text-danger">{{ $errors->first('sale_price') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a data-action="close" onclick="removeItem(this)"><i class="feather-32"
                                                        data-feather='trash-2'></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
