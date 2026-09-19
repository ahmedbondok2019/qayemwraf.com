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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.projects') ?: 'المشروعات' }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">{{ trans_db('dashboard.projects') ?: 'المشروعات' }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Add New') ?: 'إضافة مشروع جديد' }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <form class="form" action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Left Column: Project Information --}}
                        <div class="col-md-8 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Basic Information') ?: 'بيانات المشروع' }}</h4>
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
                                    <div class="tab-content mt-2">
                                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $localeCode }}" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab">
                                                {{-- Title --}}
                                                <div class="form-group">
                                                    <label for="title_{{ $localeCode }}">{{ trans_db('dashboard.Title') ?: 'عنوان المشروع' }} ({{ $properties['native'] }}) <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="type"></i></span>
                                                        </div>
                                                        <input type="text" id="title_{{ $localeCode }}" class="form-control" name="title_{{ $localeCode }}" value="{{ old('title_' . $localeCode) }}" placeholder="مثال: تجهيز مخازن شركة الأمل" required />
                                                    </div>
                                                    @error('title_' . $localeCode)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                {{-- Description --}}
                                                <div class="form-group">
                                                    <label for="description_{{ $localeCode }}">{{ trans_db('dashboard.Description') ?: 'وصف المشروع والتفاصيل' }} ({{ $properties['native'] }})</label>
                                                    <textarea id="description_{{ $localeCode }}" class="form-control" name="description_{{ $localeCode }}" rows="4" placeholder="اكتب نبذة عن المشروع، المنتجات المستخدمة، ومكان التركيب...">{{ old('description_' . $localeCode) }}</textarea>
                                                    @error('description_' . $localeCode)
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- External Link / Video --}}
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="link">{{ trans_db('dashboard.Link') ?: 'رابط تفاصيل / موقع العميل' }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="link"></i></span>
                                                    </div>
                                                    <input type="url" id="link" class="form-control" name="link" value="{{ old('link') }}" placeholder="https://..." />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="video">{{ trans_db('dashboard.Video') ?: 'رابط فيديو (YouTube / Vimeo)' }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="video"></i></span>
                                                    </div>
                                                    <input type="text" id="video" class="form-control" name="video" value="{{ old('video') }}" placeholder="https://youtube.com/watch?v=..." />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column: Media & Settings --}}
                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Media & Status') ?: 'صورة المشروع والإعدادات' }}</h4>
                                </div>
                                <div class="card-body">
                                    {{-- Image Upload --}}
                                    <div class="form-group">
                                        <label for="image">{{ trans_db('dashboard.Image') ?: 'صورة المشروع الرئيسية' }} <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" required onchange="previewImage(this, 'imagePreview')" />
                                            <label class="custom-file-label" for="image">{{ trans_db('dashboard.Choose file') ?: 'اختر الصورة' }}</label>
                                        </div>
                                        <small class="text-muted d-block mt-50">
                                            <i data-feather="shield"></i> سيتم تطبيق العلامة المائية لشعار <strong>قائم ورف</strong> تلقائياً.
                                        </small>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="mt-1 text-center">
                                            <img id="imagePreview" src="#" alt="Preview" style="display:none; max-width: 100%; height: 180px; object-fit: cover; border-radius: 6px; border: 1px dashed #ccc;" />
                                        </div>
                                    </div>

                                    {{-- Sort Order --}}
                                    <div class="form-group">
                                        <label for="sort_order">{{ trans_db('dashboard.Sort Order') ?: 'الترتيب' }}</label>
                                        <input type="number" id="sort_order" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" />
                                    </div>

                                    {{-- Is Active --}}
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} />
                                            <label class="custom-control-label" for="is_active">{{ trans_db('dashboard.Active') ?: 'مفعّل ونشط على التطبيق' }}</label>
                                        </div>
                                    </div>

                                    <hr>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i data-feather="save"></i> {{ trans_db('dashboard.Save') ?: 'حفظ المشروع' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
