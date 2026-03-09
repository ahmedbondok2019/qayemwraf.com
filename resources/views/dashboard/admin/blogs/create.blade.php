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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Add New Blog') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title">{{ trans_db('dashboard.Title') }}</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="slug">{{ trans_db('dashboard.Slug') }}</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="blog_category_id">{{ trans_db('dashboard.Category') }}</label>
                                <select name="blog_category_id" id="blog_category_id" class="form-control">
                                    <option value="">{{ trans_db('dashboard.Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->translation->title ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="tags">{{ trans_db('dashboard.Tags') }}</label>
                                <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="image">{{ trans_db('dashboard.Image') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" class="custom-file-input">
                                    <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') }}</label>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">{{ trans_db('dashboard.Description') }}</label>
                                <textarea name="description" id="description" class="form-control tinymce-editor">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <hr>
                        <h4>SEO</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="meta_title">{{ trans_db('dashboard.Meta Title') }}</label>
                                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="meta_keywords">{{ trans_db('dashboard.Meta Keywords') }}</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                            </div>
                            <div class="col-12 form-group">
                                <label for="meta_description">{{ trans_db('dashboard.Meta Description') }}</label>
                                <textarea name="meta_description" id="meta_description" class="form-control tinymce-editor">{{ old('meta_description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
