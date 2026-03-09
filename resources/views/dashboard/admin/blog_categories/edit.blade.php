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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Edit Blog Category') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.blog_categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title">{{ trans_db('dashboard.Name') }}</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $category->translation->title ?? '') }}" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="slug">{{ trans_db('dashboard.Slug') }}</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->translation->slug ?? '') }}">
                            </div>
                            <div class="col-12 form-group">
                                <label for="description">{{ trans_db('dashboard.Description') }}</label>
                                <textarea name="description" id="description" class="form-control tinymce-editor">{{ old('description', $category->translation->description ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">{{ trans_db('dashboard.Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>{{ trans_db('dashboard.Active') }}</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>{{ trans_db('dashboard.Inactive') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="view_index">{{ trans_db('dashboard.Sort Order') }}</label>
                                <input type="number" name="view_index" id="view_index" class="form-control" value="{{ $category->view_index }}">
                            </div>
                        </div>

                        <hr>
                        <h4>SEO</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="meta_title">{{ trans_db('dashboard.Meta Title') }}</label>
                                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $category->translation->meta_title ?? '') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="meta_keywords">{{ trans_db('dashboard.Meta Keywords') }}</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $category->translation->meta_keywords ?? '') }}">
                            </div>
                            <div class="col-12 form-group">
                                <label for="meta_description">{{ trans_db('dashboard.Meta Description') }}</label>
                                <textarea name="meta_description" id="meta_description" class="form-control tinymce-editor">{{ old('meta_description', $category->translation->meta_description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
