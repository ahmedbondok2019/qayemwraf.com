@if(isset($Setting) && $Setting->show_ratings)
@php
    $average = $product->averageRating();
    $count = $product->ratingCount();
    $fullStars = floor($average);
    $halfStar = ($average - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;
@endphp

<div class="rating-display" style="color: #ff9800; font-size: 12px;" title="{{ $average }} / 5">
    @for($i = 0; $i < $fullStars; $i++)
        <i class="fa-solid fa-star"></i>
    @endfor
    
    @if($halfStar)
        <i class="fa-solid fa-star-half-stroke"></i>
    @endif
    
    @for($i = 0; $i < $emptyStars; $i++)
        <i class="fa-regular fa-star"></i>
    @endfor
    
    <span style="color: #bdc3c7; margin-right: 5px; font-size: 11px;">
        ({{ number_format($average, 1) }})
    </span>
</div>
@endif
