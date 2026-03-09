@extends('frontend.layouts.master')

@section('content')
<div class="static-page-premium py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-card bg-white rounded-20 shadow-sm overflow-hidden">
                    <div class="page-header-banner p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h1 class="display-4 font-weight-bold mb-0">{{ $page->title }}</h1>
                    </div>
                    <div class="page-content p-4 p-md-5">
                        <div class="content-body lead text-muted" style="line-height: 1.8;">
                            {!! $page->content !!}
                        </div>
                    </div>
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
