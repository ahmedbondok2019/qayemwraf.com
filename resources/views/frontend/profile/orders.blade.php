@extends('frontend.layouts.master')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            @include('frontend.profile.sidebar')

            <!-- Content -->
            <div class="profile-content">
                <div class="content-header mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3>{{ trans_db('frontend.My Orders') }}</h3>
                            <p>{{ trans_db('frontend.Track your order status and history') }}</p>
                        </div>
                        <div class="stats-badge">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                <i class="fa-solid fa-receipt me-1"></i> {{ $orders->total() }} {{ trans_db('frontend.Orders') }}
                            </span>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form action="{{ route('frontend.user.orders.index') }}" method="GET" class="filter-form p-3 bg-light rounded-3 mb-3">
                         <div class="row g-3 align-items-end">
                             <div class="col-md-4">
                                 <label class="form-label small text-muted mb-1">{{ trans_db('frontend.Status') }}</label>
                                 <select name="status" class="form-select form-select-sm rounded-3">
                                     <option value="all">{{ trans_db('frontend.All Statuses') }}</option>
                                     <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ trans_db('dashboard.pending') }}</option>
                                     <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ trans_db('dashboard.processing') }}</option>
                                     <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ trans_db('dashboard.shipped') }}</option>
                                     <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ trans_db('dashboard.completed') }}</option>
                                     <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ trans_db('dashboard.cancelled') }}</option>
                                     <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ trans_db('dashboard.delivered') }}</option>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <label class="form-label small text-muted mb-1">{{ trans_db('frontend.Type') }}</label>
                                 <select name="type" class="form-select form-select-sm rounded-3">
                                     <option value="all">{{ trans_db('frontend.All Types') }}</option>
                                     <option value="regular" {{ request('type') == 'regular' ? 'selected' : '' }}>{{ trans_db('frontend.Regular Order') }}</option>
                                     <option value="gift" {{ request('type') == 'gift' ? 'selected' : '' }}>{{ trans_db('frontend.Gift Order') }}</option>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <div class="d-flex gap-2">
                                     <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 flex-grow-1">
                                         <i class="fa-solid fa-filter me-1"></i> {{ trans_db('frontend.Filter') }}
                                     </button>
                                     @if(request()->has('status') || request()->has('type'))
                                         <a href="{{ route('frontend.user.orders.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                             {{ trans_db('frontend.Reset') }}
                                         </a>
                                     @endif
                                 </div>
                             </div>
                         </div>
                    </form>
                </div>

                @if($orders->count() > 0)
                    <div class="row" id="orders-container">
                        @include('frontend.profile.partials.order_items')
                    </div>
                    
                    @if($orders->hasMorePages())
                        <div class="text-center mt-4">
                            <button id="load-more-btn" class="btn btn-outline-primary rounded-pill px-4 py-2" data-page="2">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                {{ trans_db('frontend.Load More') }}
                            </button>
                        </div>
                    @endif
                @else
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fa-solid fa-box-open fa-4x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted mb-3">{{ trans_db('frontend.No orders found') }}</h5>
                        <p class="text-muted small mb-4">You haven't placed any orders yet.</p>
                        <a href="{{ route('frontend.products.index') }}" class="btn btn-primary rounded-pill px-4">
                            {{ trans_db('frontend.Start Shopping') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('frontend.profile.partials.styles')

<style>
    /* Card Styles */
    .order-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px !important;
        overflow: hidden;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    .card-header { background-color: transparent; }
    
    .font-weight-500 { font-weight: 500; }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#load-more-btn').on('click', function() {
            var btn = $(this);
            var page = btn.data('page');
            var spinner = btn.find('.spinner-border');
            
            // Disable button and show spinner
            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('page', page);
            
            $.ajax({
                url: currentUrl.toString(),
                type: 'get',
                dataType: 'html',
                success: function(response) {
                    if (response.trim() === "") {
                        btn.remove(); // No more data
                        return;
                    }
                    
                    // Append new items
                    $('#orders-container').append(response);
                    
                    // Update page number
                    btn.data('page', page + 1);
                    
                    // Enable button and hide spinner
                    btn.prop('disabled', false);
                    spinner.addClass('d-none');
                },
                error: function(xhr) {
                    // Check if 404 meaning no more pages, or other error
                    if(xhr.status === 404) {
                         btn.remove();
                    } else {
                        console.log('Error loading more orders');
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection
