@extends('frontend.layouts.master')

@section('content')
<div class="static-page-premium py-4">
    @php
        $pageSlug = $page->slug ?? ($page->translation->slug ?? '');
        $isAboutPage = str_contains($pageSlug, 'about') || request()->is('*about*');
    @endphp

    @if($isAboutPage)
        @include('frontend.includes.about_section')
    @endif

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-card bg-white rounded-20 shadow-sm overflow-hidden">
                    <div class="page-header-banner p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #0b1a30 0%, #152c4e 100%);">
                        <h1 class="display-4 font-weight-bold mb-0">{{ $page->title }}</h1>
                    </div>
                    @if(!empty(strip_tags($page->content)))
                    <div class="page-content p-4 p-md-5">
                        <div class="content-body lead text-muted" style="line-height: 1.8;">
                            {!! $page->content !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-20 { border-radius: 20px; }
    .page-content p { margin-bottom: 1.5rem; }
</style>
@endsection
