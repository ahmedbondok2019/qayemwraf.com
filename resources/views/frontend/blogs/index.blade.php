@extends('frontend.layouts.master')

@section('content')
<div class="blogs-page py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="font-weight-bold display-4">{{ trans_db('frontend.Our Blog') }}</h1>
            <p class="text-muted lead">{{ trans_db('frontend.Stay updated with our latest news and articles') }}</p>
        </div>

        <div class="row">
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card-modern h-100 shadow-sm rounded-20 overflow-hidden bg-white border-0 transition-hover">
                    <div class="blog-img-wrapper position-relative" style="height: 240px;">
                        @if($blog->BlogTranslation && $blog->BlogTranslation->image)
                            <img src="{{ asset('website/images/blog/'.$blog->BlogTranslation->image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $blog->BlogTranslation->title }}">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                <i class="fa-regular fa-image fa-4x opacity-25"></i>
                            </div>
                        @endif
                        <div class="blog-date-badge position-absolute" style="top: 20px; right: 20px; background: rgba(102, 126, 234, 0.9); color: white; padding: 6px 15px; border-radius: 50px; font-size: 0.85rem; backdrop-filter: blur(4px);">
                            {{ $blog->created_at->format('d M, Y') }}
                        </div>
                    </div>
                    <div class="blog-content-wrapper p-4">
                        @if($blog->category)
                        <span class="badge mb-3 px-3 py-2 rounded-pill" style="background: rgba(102, 126, 234, 0.1); color: #667eea; font-weight: 600;">{{ $blog->category->translation->title ?? '' }}</span>
                        @endif
                        <h4 class="blog-title font-weight-bold mb-3" style="line-height: 1.5; font-size: 1.3rem;">
                            <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->BlogTranslation->slug ?? 'post']) }}" class="text-dark text-decoration-none hover-primary">
                                {{ $blog->BlogTranslation->title ?? 'بدون عنوان' }}
                            </a>
                        </h4>
                        <p class="blog-excerpt text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ strip_tags($blog->BlogTranslation->description ?? '') }}
                        </p>
                        <hr class="opacity-5 my-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('frontend.blogs.show', ['id' => $blog->id, 'slug' => $blog->BlogTranslation->slug ?? 'post']) }}" class="btn btn-link p-0 text-primary font-weight-bold text-decoration-none read-more-link">
                                {{ trans_db('frontend.Read More') }} <i class="fa-solid fa-arrow-left ml-2 animate-icon"></i>
                            </a>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> 5 min read</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fa-regular fa-newspaper fa-4x text-muted mb-3 opacity-25"></i>
                <h3 class="text-muted">{{ trans_db('frontend.No articles found') }}</h3>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $blogs->links() }}
        </div>
    </div>
</div>

<style>
    .rounded-20 { border-radius: 20px; }
    .transition-hover { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .transition-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
    .transition-img { transition: transform 0.6s ease; }
    .blog-card-modern:hover .transition-img { transform: scale(1.1); }
    .hover-primary:hover { color: #667eea !important; }
    .animate-icon { transition: transform 0.3s ease; display: inline-block; }
    .read-more-link:hover .animate-icon { transform: translateX(-5px); }
</style>
@endsection
