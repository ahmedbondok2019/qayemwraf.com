@foreach($ratings as $rate)
    <div class="media mb-3" style="display: flex; align-items: flex-start;">
        <div class="rounded-circle d-flex align-items-center justify-content-center" 
             style="width: 45px; height: 45px; background-color: #f8f9fa; color: var(--main-color, #1cbcec); font-size: 18px; font-weight: bold; flex-shrink: 0; margin-right: 15px; border: 1px solid #eee;">
            {{ mb_substr($rate->user->name ?? trans_db('frontend.Guest'), 0, 1, 'UTF-8') }}
        </div>
        <div class="media-body" style="flex-grow: 1;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h6 class="mt-0 mb-0" style="font-weight: bold; font-size: 14px;">{{ $rate->user->name ?? trans_db('frontend.Guest') }}</h6>
                <small class="text-muted" style="font-size: 11px;">
                    {{ $rate->created_at->diffForHumans() }}
                </small>
            </div>
            <div class="text-warning mb-1" style="font-size: 10px;">
                @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= $rate->rating ? 'fas' : 'far' }} fa-star"></i>
                @endfor
            </div>
            <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.4;">{{ $rate->comment }}</p>
        </div>
    </div>
@endforeach
