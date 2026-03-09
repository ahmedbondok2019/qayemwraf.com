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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Sliders') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">{{ trans_db('dashboard.Sliders') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
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
                                            @php
                                                $translation = $slider->translations->where('locale', $localeCode)->first();
                                            @endphp
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $localeCode }}" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab">
                                                <div class="row">
                                                    {{-- Title --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="title_{{ $localeCode }}">{{ trans_db('dashboard.Title') }} ({{ $properties['native'] }})</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i data-feather="type"></i></span>
                                                                </div>
                                                                <input type="text" id="title_{{ $localeCode }}" class="form-control" name="title_{{ $localeCode }}" value="{{ old('title_' . $localeCode, $translation->title ?? '') }}" placeholder="{{ trans_db('dashboard.Title') }}" />
                                                            </div>
                                                            @error('title_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- Subtitle --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="subtitle_{{ $localeCode }}">{{ trans_db('dashboard.Subtitle') }} ({{ $properties['native'] }})</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i data-feather="align-left"></i></span>
                                                                </div>
                                                                <input type="text" id="subtitle_{{ $localeCode }}" class="form-control" name="subtitle_{{ $localeCode }}" value="{{ old('subtitle_' . $localeCode, $translation->subtitle ?? '') }}" placeholder="{{ trans_db('dashboard.Subtitle') }}" />
                                                            </div>
                                                             @error('subtitle_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- Button Text --}}
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="button_text_{{ $localeCode }}">{{ trans_db('dashboard.Button Text') }} ({{ $properties['native'] }})</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i data-feather="mouse-pointer"></i></span>
                                                                </div>
                                                                <input type="text" id="button_text_{{ $localeCode }}" class="form-control" name="button_text_{{ $localeCode }}" value="{{ old('button_text_' . $localeCode, $translation->button_text ?? '') }}" placeholder="{{ trans_db('dashboard.Button Text') }}" />
                                                            </div>
                                                            @error('button_text_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    {{-- Common Fields --}}
                                    <div class="form-group mt-1">
                                        <label for="link">{{ trans_db('dashboard.Link') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i data-feather="link"></i></span>
                                            </div>
                                            <input type="text" id="link" class="form-control" name="link" value="{{ old('link', $slider->link) }}" placeholder="https://example.com" />
                                        </div>
                                         @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $slider->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="sort_order">{{ trans_db('dashboard.Sort Order') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i data-feather="menu"></i></span>
                                            </div>
                                            <input type="number" id="sort_order" class="form-control" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" />
                                        </div>
                                         @error('sort_order')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">{{ trans_db('dashboard.Category') }}</label>
                                        <select class="form-control select2" id="category_id" name="category_id">
                                            <option value="">{{ trans_db('dashboard.Select') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $slider->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                         @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        @if($slider->image)
                                            <div class="mt-2 text-center">
                                                <img src="{{ asset($slider->image) }}" alt="Slider Image" class="img-fluid rounded border p-1" style="max-height: 150px;">
                                            </div>
                                        @endif
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
