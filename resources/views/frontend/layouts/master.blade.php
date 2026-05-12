<!DOCTYPE html>
<html lang="ar" dir="rtl">
@php
    $mainCssPath = public_path('website/css/ar/main.css');
    $v = file_exists($mainCssPath) ? filemtime($mainCssPath) : time(); // Auto-update version when main.css changes
@endphp
<head>
    @include('frontend.layouts.head')

    @stack('css')
    <style>
        html .content.app-content
        {
                padding: calc(2rem + 4.45rem + 1.3rem) 0rem 0 !important;
        }
      
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="icons-social-media-global">
        <a href="https://api.whatsapp.com/send/?phone={{ $Setting->whatsapp }}&text=السلام عليكم" class="whats"><i class="fa-brands fa-whatsapp"></i></a>
    </div>
    
    @include('frontend.layouts.header')
    @include('frontend.layouts.popups')

    @yield('content')

    @include('frontend.layouts.footer')
    @include('frontend.layouts.scripts')
    @stack('js')
    
    @if(isset($popupAds) && $popupAds->count() > 0)
    <div class="modal fade" id="adsModal" tabindex="-1" role="dialog" aria-labelledby="adsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <div class="swiper-container popup-swiper" style="overflow: hidden;">
                        <div class="swiper-wrapper">
                            @foreach($popupAds as $ad)
                                <div class="swiper-slide">
                                    @if($ad->image)
                                        <a href="{{ $ad->link ?? '#' }}">
                                            <img src="{{ asset($ad->image) }}" alt="{{ $ad->title }}" class="img-fluid rounded" style="max-height: 400px; width: auto;">
                                        </a>
                                    @endif
                                    @if($ad->title)
                                        <h4 class="mt-2">{{ $ad->title }}</h4>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            var popupSwiper = null;

            $('#adsModal').modal('show');
            
            $('#adsModal').on('shown.bs.modal', function () {
                if (!popupSwiper) {
                    popupSwiper = new Swiper('.popup-swiper', {
                        loop: true,
                        autoplay: {
                            delay: 3000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.popup-swiper .swiper-pagination',
                            clickable: true,
                        },
                    });
                } else {
                    popupSwiper.update();
                    popupSwiper.autoplay.start();
                }
            });
        });

             document.addEventListener('DOMContentLoaded', function () {
                        new Swiper('.home-ads-swiper', {
                            loop: true,
                            autoplay: {
                                delay: 4000,
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: '.home-ads-swiper .swiper-pagination',
                                clickable: true,
                            },
                            slidesPerView: 1,
                            spaceBetween: 10,
                        });
                    });
    </script>
    @endif
</body>
</html>
