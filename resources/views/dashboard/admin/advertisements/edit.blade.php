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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Advertisements') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">{{ trans_db('dashboard.Advertisements') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $localeCode }}" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="title_{{ $localeCode }}">{{ trans_db('dashboard.Title') }} ({{ $properties['native'] }})</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i data-feather="type"></i></span>
                                                                </div>
                                                                <input type="text" id="title_{{ $localeCode }}" class="form-control" name="title_{{ $localeCode }}" value="{{ old('title_' . $localeCode, $advertisement->translate($localeCode)->title ?? '') }}" placeholder="{{ trans_db('dashboard.Title') }}" />
                                                            </div>
                                                            @error('title_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="link_{{ $localeCode }}">{{ trans_db('dashboard.Link') }} ({{ $properties['native'] }})</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i data-feather="link"></i></span>
                                                                </div>
                                                                <input type="text" id="link_{{ $localeCode }}" class="form-control" name="link_{{ $localeCode }}" value="{{ old('link_' . $localeCode, $advertisement->translate($localeCode)->link ?? '') }}" placeholder="{{ trans_db('dashboard.Link') }}" />
                                                            </div>
                                                            @error('link_' . $localeCode)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <hr>
                                    <h4 class="card-title mt-1 mb-1">{{ trans_db('dashboard.Settings') }}</h4>

                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="location">{{ trans_db('dashboard.Location') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="map-pin"></i></span>
                                                    </div>
                                                    <select class="form-control" id="location" name="location">
                                                        <option value="home" {{ old('location', $advertisement->location) == 'home' ? 'selected' : '' }}>{{ trans_db('dashboard.Home') }}</option>
                                                        <option value="category" {{ old('location', $advertisement->location) == 'category' ? 'selected' : '' }}>{{ trans_db('dashboard.Category') }}</option>
                                                        <option value="popup" {{ old('location', $advertisement->location) == 'popup' ? 'selected' : '' }}>{{ trans_db('dashboard.Popup') }}</option>
                                                    </select>
                                                </div>
                                                @error('location')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-12" id="category_selector" style="{{ old('location', $advertisement->location) == 'category' ? '' : 'display:none;' }}">
                                            <div class="form-group">
                                                <label for="category_id">{{ trans_db('dashboard.Category') }}</label>
                                                <select class="form-control select2" id="category_id" name="category_id">
                                                    <option value="">{{ trans_db('dashboard.Select') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $advertisement->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="start_at">{{ trans_db('dashboard.Start Date') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="start_at" class="form-control" name="start_at" value="{{ old('start_at', optional($advertisement->start_at)->format('Y-m-d')) }}" />
                                                </div>
                                                @error('start_at')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="end_at">{{ trans_db('dashboard.End Date') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                                    </div>
                                                    <input type="date" id="end_at" class="form-control" name="end_at" value="{{ old('end_at', optional($advertisement->end_at)->format('Y-m-d')) }}" />
                                                </div>
                                                @error('end_at')
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
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $advertisement->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>{{ trans_db('dashboard.Current Image') }}</label>
                                        <div class="mb-1">
                                            @if($advertisement->translation && $advertisement->translation->image)
                                                <img src="{{ asset($advertisement->translation->image) }}" class="img-fluid rounded" alt="Current Image" style="max-height: 200px;">
                                            @else
                                                <p class="text-muted small">{{ trans_db('dashboard.No image uploaded') }}</p>
                                            @endif
                                        </div>

                                        <label for="image">{{ trans_db('dashboard.Change Image') }}</label>
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
<script>
    $('#location').change(function() {
        if($(this).val() == 'category') {
            $('#category_selector').show();
        } else {
            $('#category_selector').hide();
        }
    });
</script>
@endsection
