@extends('frontend.layouts.master')

@section('content')
<div class="gifts-page py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class=" fw-bold text-dark mb-3">
                <i class="fa-solid fa-gift pulse-icon"></i> {{ trans_db('frontend.Gifts') }}
            </h2>
            <p class="lead text-muted">{{ trans_db('frontend.You can now access exclusive gifts from your profile.') }}</p>
        </div>

        @if($gifts->count() > 0)
            <form action="{{ route('frontend.user.gifts.store') }}" method="POST" id="giftForm">
                @csrf
                <div class="alert alert-success text-center mb-4">
                    <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.You can select up to :count gifts.', ['count' => $maxGiftItems]) }}
                </div>
                
                <div class="row g-4">
                    @foreach($gifts as $product)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="gift-card-wrapper position-relative">
                                <input type="checkbox" name="gift_ids[]" value="{{ $product->id }}" id="gift_{{ $product->id }}" class="gift-checkbox" onchange="checkGiftLimit()">
                                <label for="gift_{{ $product->id }}" class="gift-card-label w-100">
                                    <div class="v-card gift-mode">
                                        <div class="v-status-indicators">
                                            <span class="v-status-dot gift-dot" title="{{ trans_db('frontend.Gift') }}" style="background-color: #f39c12; color: white;">
                                                <i class="fa-solid fa-gift"></i>
                                            </span>
                                        </div>
                                        <div class="v-card-img-link">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->translation->name ?? '' }}" onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                        </div>
                                        <div class="v-card-content">
                                            <div class="v-card-title">{{ $product->translation->name ?? '' }}</div>
                                            <!-- Hidden cart/wishlist buttons -->
                                        </div>
                                        <div class="gift-overlay">
                                            <i class="fa-solid fa-check-circle"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-1" id="submitGiftBtn" disabled>
                        <i class="fa-solid fa-gift"></i> {{ trans_db('frontend.Request Gift') }}
                    </button>
                    <div class="mt-3">
                        {{ $gifts->links() }}
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-5">
                <div class="empty-state mb-4">
                    <i class="fa-solid fa-gift fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted">{{ trans_db('frontend.No gifts available at the moment.') }}</h4>
            </div>
        @endif
    </div>
</div>

@push('css')
<style>
    .pulse-icon {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(0, 0, 0, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
    }
    
    /* Gift Selection Styling */
    .gift-checkbox { display: none; }
    .gift-card-label { cursor: pointer; transition: all 0.3s; display: block; position: relative; }
    .gift-card-label:hover { transform: translateY(-5px); }
    
    .v-card.gift-mode { border: 2px solid transparent; transition: all 0.3s; }
    .gift-checkbox:checked + .gift-card-label .v-card.gift-mode {
        border-color: #f39c12;
        box-shadow: 0 10px 20px rgba(243, 156, 18, 0.2);
    }
    
    .gift-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(243, 156, 18, 0.1);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: all 0.3s;
        border-radius: 15px;
        pointer-events: none;
    }
    .gift-overlay i { font-size: 3rem; color: #f39c12; transform: scale(0); transition: all 0.3s; }
    
    .gift-checkbox:checked + .gift-card-label .gift-overlay { opacity: 1; }
    .gift-checkbox:checked + .gift-card-label .gift-overlay i { transform: scale(1); }
</style>
@endpush

@push('js')
<script>
    const maxGiftItems = {{ $maxGiftItems ?? 1 }};
    
    function checkGiftLimit() {
        const checkboxes = document.querySelectorAll('.gift-checkbox');
        const checkedCount = document.querySelectorAll('.gift-checkbox:checked').length;
        const submitBtn = document.getElementById('submitGiftBtn');
        
        // Enable/Disable Submit Button
        submitBtn.disabled = checkedCount === 0;
        
        // Disable unchecked boxes if limit reached
        checkboxes.forEach(cb => {
            if (!cb.checked) {
                cb.disabled = checkedCount >= maxGiftItems;
                if (checkedCount >= maxGiftItems) {
                    cb.parentElement.style.opacity = '0.5';
                } else {
                    cb.parentElement.style.opacity = '1';
                }
            }
        });
    }
</script>
@endpush
@endsection
