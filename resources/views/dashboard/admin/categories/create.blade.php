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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Category') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ trans_db('dashboard.Category') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Add New') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            
                                            <!-- Validations Errors -->
                                            @if($errors->any())
                                                <div class="col-12">
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Languages Tabs -->
                                            <div class="col-12">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
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
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $localeCode }}" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab">
                                                            <div class="row">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="title_{{ $localeCode }}">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                                        <input type="text" id="title_{{ $localeCode }}" class="form-control" name="title_{{ $localeCode }}" value="{{ old('title_' . $localeCode) }}" placeholder="{{ trans_db('dashboard.Name') }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="meta_title_{{ $localeCode }}">{{ trans_db('dashboard.Meta Title') }} ({{ $properties['native'] }})</label>
                                                                        <input type="text" id="meta_title_{{ $localeCode }}" class="form-control" name="meta_title_{{ $localeCode }}" value="{{ old('meta_title_' . $localeCode) }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="description_{{ $localeCode }}">{{ trans_db('dashboard.Description') }} ({{ $properties['native'] }})</label>
                                                                        <textarea id="description_{{ $localeCode }}" class="form-control" name="description_{{ $localeCode }}">{{ old('description_' . $localeCode) }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="meta_description_{{ $localeCode }}">{{ trans_db('dashboard.Meta Description') }} ({{ $properties['native'] }})</label>
                                                                        <textarea id="meta_description_{{ $localeCode }}" class="form-control" name="meta_description_{{ $localeCode }}">{{ old('meta_description_' . $localeCode) }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="meta_keywords_{{ $localeCode }}">{{ trans_db('dashboard.Meta Keywords') }} ({{ $properties['native'] }})</label>
                                                                        <input type="text" id="meta_keywords_{{ $localeCode }}" class="form-control" name="meta_keywords_{{ $localeCode }}" value="{{ old('meta_keywords_' . $localeCode) }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="parent_id">{{ trans_db('dashboard.Parent Category') }}</label>
                                                    <select class="form-control" id="parent_id" name="parent_id">
                                                        <option value="">{{ trans_db('dashboard.Main Category') }}</option>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->translation->title ?? $cat->translations->first()->title ?? 'N/A' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                     
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="image">{{ trans_db('dashboard.Image') }}</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image" name="image">
                                                        <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
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
                                            </div>

                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary mr-1">{{ trans_db('dashboard.Submit') }}</button>
                                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">{{ trans_db('dashboard.Cancel') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
