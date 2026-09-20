@php
    $appSetting = isset($Setting) && $Setting ? $Setting : (\App\Models\Setting::first() ?: new \App\Models\Setting());
    $about = $appSetting->getAboutSectionFormatted();
    
    // Icon mapping helper
    $iconClassMap = [
        'shield' => 'fa-shield-halved',
        'truck' => 'fa-truck-fast',
        'headset' => 'fa-headset',
        'award' => 'fa-award',
        'wrench' => 'fa-wrench',
    ];

    // Highlight word in title
    $mainTitle = $about['title'];
    $highlight = $about['highlight_text'];
    if (!empty($highlight) && str_contains($mainTitle, $highlight)) {
        $formattedTitle = str_replace($highlight, '<span class="text-gold-highlight">' . e($highlight) . '</span>', e($mainTitle));
    } else {
        $formattedTitle = e($mainTitle);
    }
@endphp

<section class="qayem-about-section py-5 position-relative">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
            
            {{-- Left Column: Texts, Stats & Features --}}
            <div class="col-lg-7">
                <div class="about-content-wrapper">
                    
                    {{-- Badge / Tag --}}
                    @if(!empty($about['tag']))
                    <div class="about-tag-pill d-inline-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-building-wheat text-gold"></i>
                        <span>{{ $about['tag'] }}</span>
                    </div>
                    @endif

                    {{-- Main Title --}}
                    <h2 class="about-main-title fw-bolder mb-3">
                        {!! $formattedTitle !!}
                    </h2>

                    {{-- Description --}}
                    <p class="about-main-desc mb-4">
                        {{ $about['description'] }}
                    </p>

                    {{-- 4 Statistics Row --}}
                    @if(!empty($about['stats']) && count($about['stats']))
                    <div class="about-stats-row row g-2 mb-4 pb-2 text-center">
                        @foreach($about['stats'] as $st)
                        <div class="col-6 col-sm-3">
                            <div class="stat-box p-2">
                                <div class="stat-val fw-bold text-gold">{{ $st['value'] }}</div>
                                <div class="stat-lbl text-muted small">{{ $st['label'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- 3 Features Cards --}}
                    @if(!empty($about['features']) && count($about['features']))
                    <div class="about-features-grid row g-3">
                        @foreach($about['features'] as $feat)
                        @php
                            $iconClass = $iconClassMap[$feat['icon']] ?? 'fa-circle-check';
                        @endphp
                        <div class="col-md-4 col-sm-6">
                            <div class="feature-mini-card h-100 p-3 rounded-4 shadow-sm bg-white border border-light">
                                <div class="feature-icon-circle mb-2 d-inline-flex align-items-center justify-content-center rounded-circle">
                                    <i class="fa-solid {{ $iconClass }} text-gold"></i>
                                </div>
                                <h4 class="feature-title h6 fw-bold mb-1 text-dark">{{ $feat['title'] }}</h4>
                                <p class="feature-desc small text-muted mb-0 lh-base">{{ $feat['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>

            {{-- Right Column: Dynamic Collage & Floating Badges --}}
            <div class="col-lg-5">
                <div class="about-collage-container position-relative">
                    
                    <div class="row g-3 align-items-stretch">
                        
                        {{-- Left Column of Collage: Top (Engineer) + Bottom (Experience Box) --}}
                        <div class="col-5 d-flex flex-column gap-3 justify-content-between">
                            
                            {{-- Top Left Image (Engineer) --}}
                            <div class="collage-item collage-top-left position-relative rounded-4 overflow-hidden shadow-sm">
                                <img src="{{ $about['image_2'] }}" alt="Engineering Studies" class="img-fluid w-100 h-100 object-fit-cover" style="min-height: 180px; max-height: 220px;" loading="lazy">
                                @if(!empty($about['image_2_badge']))
                                <div class="floating-pill-badge badge-gold-bg">
                                    <i class="fa-solid fa-compass-drafting me-1"></i> {{ $about['image_2_badge'] }}
                                </div>
                                @endif
                            </div>

                            {{-- Bottom Left Experience Card & Image --}}
                            <div class="collage-item collage-bottom-left position-relative rounded-4 overflow-hidden shadow-sm bg-white border border-light p-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="exp-icon-wrap rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-award text-gold"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bolder text-gold d-block fs-5 lh-1">{{ $about['experience_years'] }}</span>
                                        <span class="small fw-bold text-dark">{{ $about['experience_title'] }}</span>
                                    </div>
                                </div>
                                <p class="exp-subtext text-muted small mb-0 lh-sm border-top pt-2 mt-1">
                                    {{ $about['experience_subtitle'] }}
                                </p>
                            </div>

                        </div>

                        {{-- Right Column of Collage: Big Main Warehouse Image --}}
                        <div class="col-7">
                            <div class="collage-item collage-main-right position-relative rounded-4 overflow-hidden shadow h-100" style="min-height: 380px;">
                                <img src="{{ $about['image_1'] }}" alt="Storage Solutions" class="img-fluid w-100 h-100 object-fit-cover position-absolute top-0 start-0" loading="lazy">
                                <div class="collage-overlay-gradient position-absolute bottom-0 start-0 end-0 p-3 d-flex flex-column justify-content-end text-white">
                                    @if(!empty($about['image_1_badge_title']))
                                    <div class="d-inline-block">
                                        <span class="badge bg-dark bg-opacity-75 text-gold border border-warning border-opacity-25 px-2 py-1 mb-1 rounded-2 small">
                                            {{ $about['image_1_badge_title'] }}
                                        </span>
                                    </div>
                                    @endif
                                    @if(!empty($about['image_1_badge_subtitle']))
                                    <h4 class="h6 fw-bold mb-0 text-white text-shadow">
                                        {{ $about['image_1_badge_subtitle'] }}
                                    </h4>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<style>
    /* ====================================================
       About Qayem Wraf Section Styles
    ==================================================== */
    .qayem-about-section {
        background: linear-gradient(180deg, rgba(248, 251, 255, 0.6) 0%, #ffffff 100%);
        font-family: inherit;
    }

    .text-gold {
        color: #c59b27 !important;
    }

    .text-gold-highlight {
        color: #c59b27;
        position: relative;
        display: inline-block;
    }

    .about-tag-pill {
        background: rgba(197, 155, 39, 0.12);
        color: #a47d15;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        border: 1px solid rgba(197, 155, 39, 0.25);
    }

    .about-main-title {
        font-size: 32px;
        line-height: 1.35;
        color: #1a2530;
        letter-spacing: -0.5px;
    }

    @media (min-width: 992px) {
        .about-main-title {
            font-size: 36px;
        }
    }

    .about-main-desc {
        font-size: 15px;
        line-height: 1.85;
        color: #5a6a7e;
    }

    /* Stats */
    .about-stats-row {
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .stat-val {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
    }
    .stat-lbl {
        font-size: 13px;
        margin-top: 4px;
        font-weight: 600;
    }

    /* Features Mini Cards */
    .feature-mini-card {
        transition: all 0.3s ease;
        border: 1px solid #edf2f7 !important;
    }
    .feature-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(197, 155, 39, 0.12) !important;
        border-color: rgba(197, 155, 39, 0.3) !important;
    }
    .feature-icon-circle {
        width: 38px;
        height: 38px;
        background: rgba(197, 155, 39, 0.12);
        font-size: 16px;
    }

    /* Collage Layout */
    .about-collage-container {
        padding: 10px;
    }
    .collage-item {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .collage-item:hover {
        transform: scale(1.02);
    }
    .floating-pill-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #c59b27;
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    [dir="ltr"] .floating-pill-badge {
        right: auto;
        left: 12px;
    }
    .exp-icon-wrap {
        width: 36px;
        height: 36px;
        background: rgba(197, 155, 39, 0.12);
        font-size: 18px;
    }
    .exp-subtext {
        font-size: 11px;
        line-height: 1.4;
    }
    .collage-overlay-gradient {
        background: linear-gradient(180deg, rgba(0,0,0,0) 20%, rgba(10, 20, 35, 0.88) 100%);
        min-height: 140px;
    }
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0,0,0,0.6);
    }
</style>
