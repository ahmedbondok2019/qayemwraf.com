@foreach($orders as $order)
<div class="col-lg-4 col-md-6 mb-4 order-card-item">
    <div class="card order-card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-3 pb-0 px-3">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem;">#{{ $order->id }}</h6>
                @if($order->payment_method == 'gift' || $order->payment_method == 'Gift')
                    <span class=" text-dark d-flex align-items-center gap-1" style="font-size: 0.75rem; padding: 0.35em 0.65em;">
                        <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.Gift') }}
                    </span>
                @endif
            </div>
            <span class="badge badge-status {{ $order->status }} px-3 py-2 rounded-pill small">
                {{ $order->order_status[0] ?? $order->order_status }}
            </span>
        </div>
        <div class="card-body px-3 pt-2 pb-3">
            <hr class="my-2 border-light opacity-50">
            
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small d-flex align-items-center gap-2">
                    <i class="fa-regular fa-calendar text-secondary" style="width: 16px;"></i> {{ trans_db('frontend.Date') }}
                </span>
                <span class="text-dark fw-bold small">{{ $order->created_at->format('Y-m-d') }}</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small d-flex align-items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-secondary" style="width: 16px;"></i> {{ trans_db('frontend.Items') }}
                </span>
                <span class="text-dark fw-bold small">{{ $order->order_details->count() }}</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small d-flex align-items-center gap-2">
                    <i class="fa-solid fa-money-bill-wave text-secondary" style="width: 16px;"></i> {{ trans_db('frontend.Total') }}
                </span>
                <span class="text-primary fw-bold">{{ $order->total }} {{ $order->currency }}</span>
            </div>
            
            <a href="{{ route('frontend.user.orders.show', $order->id) }}" class="btn btn-primary btn-sm w-100 rounded-1 view-order-btn fw-bold py-2 mt-2" style="border-width: 1.5px;">
                {{ trans_db('frontend.View Details') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
