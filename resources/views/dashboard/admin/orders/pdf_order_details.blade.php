

<div class="card-body invoice-padding pb-0" style="display: flex;">
    <div class="invoice-total-wrapper" style="max-width: 350px !important;">
        <div class="invoice-total-item" style="display: flex;">
            <table class="inside_table" style="text-align:left;display: flex;">
                <tr style="background-color: #f7f2ea">
                    <td>product Name</td>
                    {{-- <td>vendor Name</td> --}}
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>tax</td>
                    <td>Discount</td>
                    <td>subtotal</td>
                    <td>shipping</td>
                </tr>
                <tr>
                    <td>{{ \App\Models\ProductTranslation::where('product_id', $order_details->product_id)->where('lang_id' , app()->getlocale())->first()->title }}</td>
                    {{-- <td>{{ optional(\App\Models\Vendor::find($order_details->vendor_id))->name }}</td> --}}
                    <td>{{ $order_details->quantity }}</td>
                    <td>{{ $order_details->price * $rate }}</td>
                    <td>{{ $order_details->tax * $rate }}</td>
                    <td>{{ $order_details->discount * $rate }}</td>
                    <td>{{ $order_details->subtotal * $rate }}</td>
                    <td>
                        @if ($order_details->shipping_method_id == 1)
                            private shipping
                        @else
                            bosta
                        @endif
                    </td>
                </tr>
                @php
                    $order_options = \App\Models\OrderOption::where('order_details_id', $order_details->id)
                        ->where('product_id', $order_details->product_id)
                        ->where('user_id', $order_details->user_id)->get();
                @endphp
                @foreach ($order_options as $options)
                    <div class="card product_option">
                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row" id="table-hover-row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Option Name</th>
                                                            <th>Option Item</th>
                                                        </tr>
                                                    </thead>
                                                        <tr>
                                                            <td>{{ \App\Models\OptionTranslation::where('option_id', $order_details->option_id)->where('lang_id' , app()->getlocale())->first()->title }}</td>
                                                            <td>{{ \App\Models\OptionItemTranslation::where('option_item_id' , $order_details->option_item_id)->title }}</td>
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
                @endforeach
            </table>
        </div>
    </div>
</div>