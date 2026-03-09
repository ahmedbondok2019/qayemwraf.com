@if (isset($field) && $field != null)
    @if ($key != 'payment_status')
        <div class="col-lg-12">
            <label for="{{ $key }}">{{ trans_db('dashboard.' . ucwords($key)) }}</label> : 
            <span>{{ $field }}</span>
        </div>
    @endif   
@endif

@if ($key == 'payment_status')
    <div class="col-lg-12">
        <label for="{{ $key }}">{{ trans_db('dashboard.' . ucwords($key)) }}</label> : 
        <span>
            @if (isset($detail))
                @if ($key == 'payment_status')
                    {{ \App\Http\Controllers\Admin\OrdersController::getPaymentStatus($detail) }}
                @else
                    @switch($detail)
                        @case(1)
                            {{ trans_db('dashboard.Yes') }}
                            @break
                        @case(2)
                            {{ trans_db('dashboard.No') }}
                            @break
                        @default
                            {{ $detail }}
                            @break
                    @endswitch   
                @endif 
            @endif
        </span>
    </div>
@endif

@if (isset($detail) && $detail != null)
    @if ($key != 'payment_status')
        <div class="col-lg-12">
            <label for="{{ $key }}">{{ trans_db('dashboard.' . $key) }}</label> : 
            <span>
                @if ($key == 'payment_status')
                    {{ \App\Http\Controllers\Admin\OrdersController::getPaymentStatus($detail) }}
                @else
                    @switch($detail)
                        @case(1)
                            {{ trans_db('dashboard.Yes') }}
                            @break
                        @case(2)
                            {{ trans_db('dashboard.No') }}
                            @break
                        @default
                            {{ $detail }}
                            @break
                    @endswitch   
                @endif 
            </span>
        </div>
    @endif
@endif