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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Brands') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.product_brands.index') }}">{{ trans_db('dashboard.Brands') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}
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
                                    <h4 class="card-title">{{ trans_db('dashboard.Edit') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form"
                                        action="{{ route('admin.product_brands.update', $brand->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            
                                            <!-- Basic Info Header -->
                                            <div class="col-12 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="info" class="mr-50"></i> {{ trans_db('dashboard.Basic Information') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <!-- Names -->
                                            @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="title_{{ $localeCode }}" class="font-weight-bold">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                                            </div>
                                                            <input type="text" id="title_{{ $localeCode }}"
                                                                class="form-control" name="{{ $localeCode }}[title]"
                                                                value="{{ old($localeCode . '.title', $brand->translations->where('locale', $localeCode)->first()->title ?? '') }}"
                                                                required placeholder="{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-12 mt-2 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="image" class="mr-50"></i> {{ trans_db('dashboard.Details') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <!-- Sort Order -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="sort_order" class="font-weight-bold">{{ trans_db('dashboard.Sort Order') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="align-left"></i></span>
                                                        </div>
                                                        <input type="number" id="sort_order" class="form-control"
                                                            name="sort_order" value="{{ old('sort_order', $brand->sort_order) }}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="is_active" class="font-weight-bold">{{ trans_db('dashboard.Status') }}</label>
                                                    <div class="custom-control custom-switch custom-switch-success">
                                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                                            name="is_active" value="1"
                                                            {{ $brand->is_active ? 'checked' : '' }} />
                                                        <label class="custom-control-label" for="is_active">
                                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Image -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="image" class="font-weight-bold">{{ trans_db('dashboard.image') }}</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                                            <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                                        </div>
                                                    </div>
                                                    @if ($brand->image)
                                                        <div class="mt-2 p-1 border rounded" style="width: fit-content;">
                                                            <img src="{{asset($brand->image) }}"
                                                                alt="brand image" class="img-fluid rounded" width="100">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 text-right">
                                                <button type="reset" class="btn btn-outline-secondary mr-1">{{ trans_db('dashboard.Reset') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Submit') }}</button>
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
