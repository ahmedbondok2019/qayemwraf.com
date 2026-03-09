@php
    $currency = App\Models\Currency::activated()->first();
    $rate = $currency->rate ?? 1;
@endphp

<div class="card product_option">
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans_db('dashboard.product Name') }}</th>
                                        <th>{{ trans_db('dashboard.vendor Name') }}</th>
                                        <th>{{ trans_db('dashboard.Quantity') }}</th>
                                        <th>{{ trans_db('dashboard.Price') }}</th>
                                        <th>{{ trans_db('dashboard.tax') }}</th>
                                        <th>{{ trans_db('dashboard.Discount') }}</th>
                                        <th>{{ trans_db('dashboard.subtotal') }}</th>
                                        <th>{{ trans_db('dashboard.shipping_method') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $order_details->productTranslation->title ?? trans_db('dashboard.not_available') }}
                                        </td>
                                        <td>{{ $order_details->vendor->name ?? trans_db('dashboard.not_available') }}</td>
                                        <td>{{ $order_details->quantity }}</td>
                                        <td>{{ number_format($order_details->converted_price, 2) }}</td>
                                        <td>{{ number_format($order_details->tax, 2) }}</td>
                                        <td>{{ number_format($order_details->converted_discount, 2) }}</td>
                                        <td>{{ number_format($order_details->converted_subtotal, 2) }}</td>
                                        <td>
                                            <select name="shipping_method_id" class="form-control select2"
                                                data-id="{{ $order_details->id }}">
                                                <option value="">{{ trans_db('dashboard.Choose') }}</option>
                                                <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}
                                                </option>
                                                <option value="1"
                                                    {{ $order_details->shipping_method_id == 1 ? 'selected' : '' }}>
                                                    {{ trans_db('dashboard.private shipping') }}</option>
                                                <option value="2"
                                                    {{ $order_details->shipping_method_id == 2 ? 'selected' : '' }}>
                                                    {{ trans_db('dashboard.bosta') }}</option>
                                                <option value="3"
                                                    {{ $order_details->shipping_method_id == 3 ? 'selected' : '' }}>
                                                    {{ trans_db('dashboard.speedaf') }}</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @forelse ($order_details->orderOptions as $option)
                <div class="card product_option mt-2">
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans_db('dashboard.option_name') }}</th>
                                                        <th>{{ trans_db('dashboard.option_item') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $option->optionTranslation->title ?? trans_db('dashboard.not_available') }}
                                                        </td>
                                                        <td>{{ $option->optionItemTranslation->title ?? trans_db('dashboard.not_available') }}
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
            @empty
                <div class="alert alert-info mt-2">
                    {{ trans_db('dashboard.no_options_available') }}
                </div>
            @endforelse
        </div>
    </div>
</div>
