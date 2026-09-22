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
                                <label for="title">{{ trans_db('dashboard.Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="slug">{{ trans_db('dashboard.Slug') }}</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="اتركه فارغاً للتوليد التلقائي">
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
                                <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags') }}" placeholder="أدخل الكلمات المفتاحية مفصولة بفواصل">
                            </div>

                            <!-- Dual Image Upload Section -->
                            <div class="col-12 my-2">
                                <div class="p-3 border rounded bg-light">
                                    <h5 class="mb-3 text-primary"><i data-feather="image"></i> صور المقال (الخارجية والداخلية)</h5>
                                    <div class="row">
                                        <!-- Outer / Card Image -->
                                        <div class="col-md-6 form-group">
                                            <label for="card_image" class="font-weight-bold">
                                                صورة الكارد الخارجية (Outer / Card Image)
                                                <span class="badge badge-light-primary ml-1">المقاس: 324 × 203 px</span>
                                            </label>
                                            <p class="text-muted small mb-1">الصورة المصغرة التي تظهر في قائمة المقالات وبطاقات الموقع.</p>
                                            <div class="custom-file">
                                                <input type="file" name="card_image" id="card_image" class="custom-file-input" accept="image/*" onchange="previewImg(this, '#preview_card')">
                                                <label class="custom-file-label" for="card_image">اختر صورة الكارد (324x203)</label>
                                            </div>
                                            <div class="mt-2 text-center" id="preview_card_wrapper" style="display: none;">
                                                <img id="preview_card" src="#" alt="Card Preview" class="rounded border shadow-sm" style="max-height: 120px; object-fit: cover;">
                                            </div>
                                        </div>

                                        <!-- Inner / Banner Image -->
                                        <div class="col-md-6 form-group">
                                            <label for="inner_image" class="font-weight-bold">
                                                صورة المقال الداخلية / الغلاف (Inner / Header Image)
                                                <span class="badge badge-light-info ml-1">المقاس: 1024 × 439 px</span>
                                            </label>
                                            <p class="text-muted small mb-1">صورة الغلاف العريضة البارزة أعلى تفاصيل المقال من الداخل.</p>
                                            <div class="custom-file">
                                                <input type="file" name="inner_image" id="inner_image" class="custom-file-input" accept="image/*" onchange="previewImg(this, '#preview_inner')">
                                                <label class="custom-file-label" for="inner_image">اختر صورة الغلاف الداخلي (1024x439)</label>
                                            </div>
                                            <div class="mt-2 text-center" id="preview_inner_wrapper" style="display: none;">
                                                <img id="preview_inner" src="#" alt="Inner Preview" class="rounded border shadow-sm" style="max-height: 120px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-2">
                                <label for="description">{{ trans_db('dashboard.Description') }}</label>
                                <textarea name="description" id="description" class="form-control tinymce-editor">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <hr>
                        <h4 class="text-secondary"><i data-feather="search"></i> إعدادات الـ SEO والأرشفة</h4>
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

                        <div class="form-group text-right mt-3">
                            <button type="submit" class="btn btn-primary px-4">{{ trans_db('dashboard.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function previewImg(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(target).attr('src', e.target.result);
                $(target + '_wrapper').show();
            }
            reader.readAsDataURL(input.files[0]);
            $(input).next('.custom-file-label').html(input.files[0].name);
        }
    }
</script>
@endsection
