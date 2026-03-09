@extends('frontend.layouts.master')

@section('content')
<div class="blog-details-modern py-5 bg-white">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="premium-breadcrumb mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">{{ trans_db('frontend.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.blogs.index') }}">{{ trans_db('frontend.Blog') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blog->BlogTranslation->title ?? '' }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <article class="post-article">
                    <div class="post-header mb-4">
                        @if($blog->category)
                            <a href="#" class="post-category-badge mb-3 d-inline-block">
                                {{ $blog->category->translation->title ?? '' }}
                            </a>
                        @endif
                        <h1 class="post-main-title font-weight-bold">{{ $blog->BlogTranslation->title ?? '' }}</h1>
                        
                        <div class="post-meta-data d-flex align-items-center flex-wrap mt-3 text-muted">
                            <span class="meta-item"><i class="fa-regular fa-calendar-days"></i> {{ $blog->created_at->format('d M, Y') }}</span>
                            <span class="meta-item"><i class="fa-regular fa-user"></i> {{ $blog->BlogTranslation->Author ?? 'Admin' }}</span>
                            <span class="meta-item"><i class="fa-regular fa-eye"></i> 1,234 {{ trans_db('frontend.views') }}</span>
                        </div>
                    </div>

                    <div class="post-featured-image-wrapper rounded-20 shadow-sm overflow-hidden mb-5">
                        @if($blog->BlogTranslation && $blog->BlogTranslation->image)
                            <img src="{{ asset($blog->BlogTranslation->image) }}" class="img-fluid w-100" alt="{{ $blog->BlogTranslation->title }}">
                        @else
                            <div class="placeholder-img bg-light d-flex align-items-center justify-content-center py-5">
                                <i class="fa-regular fa-image fa-5x opacity-25"></i>
                            </div>
                        @endif
                    </div>

                    <div class="post-content-body mb-5">
                        {!! $blog->BlogTranslation->description ?? '' !!}
                    </div>

                    <!-- Footer / Tags / Share -->
                    <div class="post-footer-actions border-top pt-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="post-tags">
                                    <span class="font-weight-bold me-2">{{ trans_db('frontend.Tags') }}:</span>
                                    @php $tags = explode(',', $blog->BlogTranslation->tags ?? ''); @endphp
                                    @foreach($tags as $tag)
                                        @if(trim($tag))
                                            <span class="tag-item">#{{ trim($tag) }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-share-modern d-flex align-items-center justify-content-md-end">
                                    <span class="font-weight-bold me-3">{{ trans_db('frontend.Share') }}:</span>
                                    <div class="share-btns">
                                        <a href="#" class="share-btn facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                        <a href="#" class="share-btn twitter"><i class="fa-brands fa-twitter"></i></a>
                                        <a href="#" class="share-btn whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar pe-lg-4">
                    <!-- Search Widget -->
                    <div class="sidebar-widget widget-search mb-5">
                        <h4 class="widget-title">{{ trans_db('frontend.Search') }}</h4>
                        <form action="{{ route('frontend.blogs.index') }}" method="GET" class="premium-search-form">
                            <div class="search-input-group">
                                <input type="text" name="search" placeholder="{{ trans_db('frontend.Search articles...') }}">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                    <!-- Latest Posts Widget -->
                    <div class="sidebar-widget widget-latest-posts mb-5">
                        <h4 class="widget-title">{{ trans_db('frontend.Latest Articles') }}</h4>
                        <div class="posts-list">
                            @foreach($latestBlogs as $lblog)
                            <div class="mini-post-item d-flex align-items-center mb-4">
                                <div class="mini-post-img rounded-12 overflow-hidden flex-shrink-0">
                                    <a href="{{ route('frontend.blogs.show', ['id' => $lblog->id, 'slug' => $lblog->BlogTranslation->slug ?? 'post']) }}">
                                        @if($lblog->BlogTranslation && $lblog->BlogTranslation->image)
                                            <img src="{{ asset($lblog->BlogTranslation->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $lblog->BlogTranslation->title }}">
                                        @else
                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                                <i class="fa-regular fa-image opacity-25"></i>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="mini-post-content ms-3">
                                    <h6 class="mini-title mb-1">
                                        <a href="{{ route('frontend.blogs.show', ['id' => $lblog->id, 'slug' => $lblog->BlogTranslation->slug ?? 'post']) }}">
                                            {{ $lblog->BlogTranslation->title ?? '' }}
                                        </a>
                                    </h6>
                                    <span class="mini-date text-muted"><i class="fa-regular fa-calendar pe-1"></i> {{ $lblog->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Sidebar Ad / Banner if exists -->
                    <div class="sidebar-banner rounded-20 p-4 text-center text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fa-regular fa-paper-plane fa-3x mb-3"></i>
                        <h5>{{ trans_db('frontend.Subscribe to News') }}</h5>
                        <p class="small mb-4">{{ trans_db('frontend.Get latest updates directly to your inbox.') }}</p>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-light btn-sm rounded-pill px-4">{{ trans_db('frontend.Contact Us') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Typography & Fonts */
    .blog-details-modern {
        background: #fff;
        font-family: 'Cairo', sans-serif;
    }

    /* Breadcrumbs */
    .premium-breadcrumb .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }
    .premium-breadcrumb .breadcrumb-item a {
        color: #718096;
        text-decoration: none;
        transition: color 0.3s;
    }
    .premium-breadcrumb .breadcrumb-item a:hover {
        color: #667eea;
    }
    .premium-breadcrumb .breadcrumb-item.active {
        color: #2d3748;
        font-weight: 600;
    }

    /* Post Article */
    .post-main-title {
        font-size: 2.8rem;
        line-height: 1.2;
        color: #1a202c;
    }
    .post-category-badge {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 6px 15px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .post-meta-data .meta-item {
        margin-right: 20px;
        font-size: 0.95rem;
    }
    .post-meta-data .meta-item i {
        margin-right: 5px;
        color: #a0aec0;
    }

    /* Content Styling */
    .post-content-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #4a5568;
    }
    .post-content-body p {
        margin-bottom: 1.5rem;
    }

    /* Sidebar Styles */
    .widget-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 2rem;
        padding-bottom: 15px;
        position: relative;
    }
    .widget-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: #667eea;
        border-radius: 3px;
    }
    html[dir="rtl"] .widget-title::after {
        left: auto;
        right: 0;
    }

    /* Search Form */
    .premium-search-form .search-input-group {
        position: relative;
        background: #f7fafc;
        border-radius: 12px;
        padding: 5px;
        border: 2px solid #edf2f7;
        transition: all 0.3s;
    }
    .premium-search-form .search-input-group:focus-within {
        border-color: #667eea;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .premium-search-form input {
        width: 100%;
        border: none;
        background: transparent;
        padding: 10px 15px;
        outline: none;
        color: #2d3748;
        text-align: inherit; /* Respect parent direction */
    }
    .premium-search-form button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #667eea;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    html[dir="rtl"] .premium-search-form button {
        right: auto;
        left: 5px;
    }
    .premium-search-form button:hover {
        background: #764ba2;
        transform: translateY(-50%) scale(1.05);
    }

    /* Mini Posts */
    .mini-post-img {
        width: 80px;
        height: 80px;
        border: 1px solid #edf2f7;
    }
    .mini-title a {
        color: #2d3748;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s;
        text-align: inherit;
    }
    .mini-title a:hover {
        color: #667eea;
    }
    .mini-date {
        font-size: 0.8rem;
    }

    /* Tags & Share */
    .tag-item {
        display: inline-block;
        background: #edf2f7;
        color: #4a5568;
        padding: 5px 12px;
        border-radius: 50px;
        margin-right: 5px;
        font-size: 0.85rem;
        transition: all 0.3s;
        cursor: pointer;
    }
    html[dir="rtl"] .tag-item {
        margin-right: 0;
        margin-left: 5px;
    }
    .tag-item:hover {
        background: #667eea;
        color: #fff;
    }
    .share-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none !important;
        margin-left: 10px;
        transition: all 0.3s;
    }
    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .facebook { background: #3b5998; }
    .twitter { background: #1da1f2; }
    .whatsapp { background: #25d366; }

    /* RTL Utilities */
    html[dir="rtl"] .meta-item {
        margin-right: 0;
        margin-left: 20px;
    }
    html[dir="rtl"] .post-meta-data .meta-item i {
        margin-right: 0;
        margin-left: 5px;
    }
    html[dir="rtl"] .mini-post-content {
        text-align: right;
    }
    html[dir="rtl"] .mini-post-content.ms-3 {
        margin-left: 0 !important;
        margin-right: 1rem !important;
    }
    html[dir="rtl"] .post-share-modern .font-weight-bold {
        margin-right: 0 !important;
        margin-left: 1rem !important;
    }
    html[dir="rtl"] .share-btn {
        margin-left: 0;
        margin-right: 10px;
    }

    /* Important: Fix text wrapping for large random strings */
    .post-content-body {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .post-main-title {
            font-size: 2rem;
        }
        .post-content-body {
            font-size: 1.05rem;
        }
    }

    .rounded-20 { border-radius: 20px; }
    .rounded-12 { border-radius: 12px; }
</style>
@endsection
