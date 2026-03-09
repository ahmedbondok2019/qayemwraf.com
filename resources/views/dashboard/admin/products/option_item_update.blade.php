
<div class="card product_option">
    <div class="card-header">
        <h4 class="card-title">
            {{ optional(
                \App\Models\OptionTranslation::where('option_id', $option->id)
                    ->where('lang_id' , app()->getLocale())
                    ->first()
                    )->title }}</h4>
        <div class="heading-elements">
            <input type="hidden" class="option_id" value="{{ $option->option_id }}">
            <input type="hidden" name="op[option{{ $option->id }}][id]" value="{{ $option->id }}">
            <ul class="list-inline mb-0">
                <li>
                    <input type="hidden" name="op[option{{ $option->id }}][option_id]" value="{{ $option->option_id }}">
                    <label class="switch">    
                        <input type="checkbox" name="op[option{{ $option->id }}][option_required]" value="1" {{ $option->option_id == 1 ? "checked" : "" }}>
                        <span class="slider round"></span>
                    </label>
                    <label>{{ trans_db('dashboard.Required') }}</label>
                </li>
                <li>
                    <a data-action="close" onclick="removeOption(this, '{{ $option->id }}')"><i class="feather-32" data-feather='trash-2'></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show" style="">
        <div class="card-body">
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ trans_db("dashboard.Option Name") }}</th>
                                        <th>{{ trans_db('dashboard.Quantity') }}</th>
                                        <th>{{ trans_db('dashboard.reduce quantity') }}</th>
                                        <th>{{ trans_db('dashboard.Difference in Price') }}</th>
                                        <th>{{ trans_db('dashboard.Difference in Weight') }}</th>
                                        <th>{{ trans_db('dashboard.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $optionItems = \App\Models\ProductOptionItem::where('option_id', $option->option_id)->where('product_id', $option->product_id)->get();
                                    @endphp
                                    @foreach ($optionItems as $optionItem)
                                        <input type="hidden" name="op[option{{ $option->id }}][item_id][]" value="{{ $optionItem->id }}">
                                        <input type="hidden" name="op[option{{ $option->id }}][option_item_id][]" value="{{ $optionItem->option_item_id }}">
                                        <input type="hidden" name="op[option{{ $option->id }}][option_item_title][]" value="{{ $optionItem->option_item_title }}">
                                        <tr>
                                            <td>
                                                {{ $optionItem->option_item_title }}
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" class="touchspin" value="{{ $optionItem->quantity }}" name="op[option{{ $option->id }}][quantity][]"/>
                                                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('ignore_quantity') ? 'has-error' : '' }}">
                                                    <select name="op[option{{ $option->id }}][ignore_quantity][]" class="form-control" style="width: 100%;">
                                                        <option value="0" {{ $optionItem->ignore_quantity == 0 ? "selected" : "" }}>No</option>
                                                        <option value="1" {{ $optionItem->ignore_quantity == 1 ? "selected" : "" }}>Yes</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('difference_in_price') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" class="touchspin" value="{{ $optionItem->difference_in_price }}" name="op[option{{ $option->id }}][difference_in_price][]"/>
                                                        <span class="text-danger">{{ $errors->first('difference_in_price') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('difference_in_weight') ? 'has-error' : '' }}">
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" class="touchspin" value="{{ $optionItem->difference_in_weight }}" name="op[option{{ $option->id }}][difference_in_weight][]"/>
                                                        <span class="text-danger">{{ $errors->first('difference_in_weight') }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a data-action="close" onclick="removeItem(this)"><i class="feather-32" data-feather='trash-2'></i></a>
                                            </td>
                                        </tr> 
                                    @endforeach                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>