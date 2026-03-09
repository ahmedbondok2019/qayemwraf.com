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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Countries') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.countries.index') }}">{{ trans_db('dashboard.Countries') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
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
                                                <div class="form-group">
                                                    <label for="name_{{ $localeCode }}">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="flag"></i></span>
                                                        </div>
                                                        <input type="text" id="name_{{ $localeCode }}" class="form-control" name="name_{{ $localeCode }}" value="{{ old('name_' . $localeCode) }}" placeholder="{{ trans_db('dashboard.Name') }}" />
                                                    </div>
                                                    @error('name_' . $localeCode)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <hr>
                                    <h4 class="card-title mt-1 mb-1">{{ trans_db('dashboard.Settings') }}</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="code">{{ trans_db('dashboard.Code') }} (e.g. EG)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="globe"></i></span>
                                                    </div>
                                                    <input type="text" id="code" class="form-control" name="code" value="{{ old('code') }}" placeholder="EG" />
                                                </div>
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone_code">{{ trans_db('dashboard.Phone Code') }} (e.g. +20)</label>
                                                 <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="phone"></i></span>
                                                    </div>
                                                    <input type="text" id="phone_code" class="form-control" name="phone_code" value="{{ old('phone_code') }}" placeholder="+20" />
                                                </div>
                                                @error('phone_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="sort_order">{{ trans_db('dashboard.Sort Order') }}</label>
                                                 <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="sliders"></i></span>
                                                    </div>
                                                    <input type="number" id="sort_order" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" />
                                                </div>
                                                @error('sort_order')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                        <label for="image">{{ trans_db('dashboard.Flag') }}</label>
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
