@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Pages') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ trans_db('dashboard.Pages') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Left Column: Basic Information --}}
                        <div class="col-md-9 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{-- Tabs for Languages --}}
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                   id="{{ $localeCode }}-tab"
                                                   data-toggle="tab"
                                                   href="#{{ $localeCode }}"
                                                   aria-controls="{{ $localeCode }}"
                                                   role="tab"
                                                   aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                    {{ $properties['native'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $localeCode }}" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab">
                                                
                                                {{-- Title --}}
                                                <div class="form-group">
                                                    <label for="title_{{ $localeCode }}">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="type"></i></span>
                                                        </div>
                                                        <input type="text" id="title_{{ $localeCode }}" class="form-control" name="title_{{ $localeCode }}" value="{{ old('title_' . $localeCode) }}" placeholder="{{ trans_db('dashboard.Name') }}" />
                                                    </div>
                                                    @error('title_' . $localeCode)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- Content (TinyMCE) --}}
                                                <div class="form-group">
                                                    <label for="content_{{ $localeCode }}">{{ trans_db('dashboard.Content') }} ({{ $properties['native'] }})</label>
                                                    <textarea id="content_{{ $localeCode }}" class="form-control tinymce-editor" name="content_{{ $localeCode }}" rows="10">{{ old('content_' . $localeCode) }}</textarea>
                                                    @error('content_' . $localeCode)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <hr>
                                                <h5 class="mb-1">{{ trans_db('dashboard.SEO Information') }}</h5>

                                                {{-- Meta Title --}}
                                                <div class="form-group">
                                                    <label for="meta_title_{{ $localeCode }}">{{ trans_db('dashboard.Meta Title') }} ({{ $properties['native'] }})</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="search"></i></span>
                                                        </div>
                                                        <input type="text" id="meta_title_{{ $localeCode }}" class="form-control" name="meta_title_{{ $localeCode }}" value="{{ old('meta_title_' . $localeCode) }}" />
                                                    </div>
                                                </div>

                                                {{-- Meta Description --}}
                                                <div class="form-group">
                                                    <label for="meta_description_{{ $localeCode }}">{{ trans_db('dashboard.Meta Description') }} ({{ $properties['native'] }})</label>
                                                    <textarea id="meta_description_{{ $localeCode }}" class="form-control tinymce-editor" name="meta_description_{{ $localeCode }}" rows="3">{{ old('meta_description_' . $localeCode) }}</textarea>
                                                </div>

                                                {{-- Meta Keywords --}}
                                                <div class="form-group">
                                                    <label for="meta_keywords_{{ $localeCode }}">{{ trans_db('dashboard.Meta Keywords') }} ({{ $properties['native'] }})</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="tag"></i></span>
                                                        </div>
                                                        <input type="text" id="meta_keywords_{{ $localeCode }}" class="form-control" name="meta_keywords_{{ $localeCode }}" value="{{ old('meta_keywords_' . $localeCode) }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <hr>
                                    <div class="form-group">
                                        <label for="sort_order">{{ trans_db('dashboard.Sort Order') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i data-feather="sliders"></i></span>
                                            </div>
                                            <input type="number" id="sort_order" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Details --}}
                        <div class="col-md-3 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="is_active">{{ trans_db('dashboard.Status') }}</label>
                                        <div class="custom-control custom-switch custom-switch-success">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                            <label class="custom-control-label" for="is_active">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">{{ trans_db('dashboard.Image') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">{{ trans_db('dashboard.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection