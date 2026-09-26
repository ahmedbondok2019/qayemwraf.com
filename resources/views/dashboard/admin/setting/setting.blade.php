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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Settings') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Settings') }}
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
                                    <h4 class="card-title">{{ trans_db('dashboard.Edit Settings') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.settings.update') }}" method="POST"
                                        enctype="multipart/form-data">
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

                                            <div class="col-12">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" aria-controls="general" role="tab" aria-selected="true">
                                                            <i data-feather="info"></i> {{ trans_db('dashboard.App Information') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" aria-controls="contact" role="tab" aria-selected="false">
                                                            <i data-feather="phone"></i> {{ trans_db('dashboard.Contact Information') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="gift-tab" data-toggle="tab" href="#gift" aria-controls="gift" role="tab" aria-selected="false">
                                                            <i data-feather="gift"></i> {{ trans_db('dashboard.Gift Settings') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" aria-controls="messages" role="tab" aria-selected="false">
                                                            <i data-feather="message-square"></i> {{ trans_db('dashboard.Status Messages') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="social-login-tab" data-toggle="tab" href="#social-login" aria-controls="social-login" role="tab" aria-selected="false">
                                                            <i data-feather="lock"></i> {{ trans_db('dashboard.Social Login') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ratings-tab" data-toggle="tab" href="#ratings" aria-controls="ratings" role="tab" aria-selected="false">
                                                            <i data-feather="star"></i> {{ trans_db('dashboard.Ratings Settings') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="why-choose-us-tab" data-toggle="tab" href="#why-choose-us" aria-controls="why-choose-us" role="tab" aria-selected="false">
                                                            <i data-feather="help-circle"></i> {{ trans_db('dashboard.Why Choose Us') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="catalog-tab" data-toggle="tab" href="#catalog" aria-controls="catalog" role="tab" aria-selected="false">
                                                            <i data-feather="file-text"></i> {{ trans_db('dashboard.Catalog Download Settings', 'إعدادات كتالوج المنتجات (PDF)') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="about-section-tab" data-toggle="tab" href="#about-section" aria-controls="about-section" role="tab" aria-selected="false">
                                                            <i data-feather="layout"></i> {{ trans_db('dashboard.About Section Settings', 'قسم عن قائم ورف') }}
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    
                                                    <!-- General Tab -->
                                                    <div class="tab-pane active" id="general" aria-labelledby="general-tab" role="tabpanel">
                                                        <div class="row">
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.app_name') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="app_name[{{ $localeCode }}]"
                                                                        value="{{ old("app_name.$localeCode", $Setting->translate('app_name', $localeCode)) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.app_meta_title') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="app_meta_title[{{ $localeCode }}]"
                                                                        value="{{ old("app_meta_title.$localeCode", $Setting->translate('app_meta_title', $localeCode)) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.app_meta_desc') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="app_meta_desc[{{ $localeCode }}]" rows="3">{{ old("app_meta_desc.$localeCode", $Setting->translate('app_meta_desc', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12">
                                                                <hr>
                                                                <h5 class="mb-1 mt-2"><i data-feather="image"></i> {{ trans_db('dashboard.Images') }}</h5>
                                                            </div>

                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="logo">{{ trans_db('dashboard.logo') }}</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="logo" name="logo">
                                                                        <label class="custom-file-label" for="logo">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    @if($Setting->logo)
                                                                        <div class="mt-1">
                                                                            <img src="{{ asset($Setting->logo) }}" alt="Logo" width="100" class="rounded" style="background: #f0f0f0">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="logo_dark">{{ trans_db('dashboard.logo_dark') }}</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="logo_dark" name="logo_dark">
                                                                        <label class="custom-file-label" for="logo_dark">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    @if($Setting->logo_dark)
                                                                        <div class="mt-1">
                                                                            <img src="{{ asset($Setting->logo_dark) }}" alt="Logo Dark" width="100" class="rounded" style="background: #333">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="fav_icon">{{ trans_db('dashboard.fav_icon') }}</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="fav_icon" name="fav_icon">
                                                                        <label class="custom-file-label" for="fav_icon">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    @if($Setting->fav_icon)
                                                                        <div class="mt-1">
                                                                            <img src="{{ asset($Setting->fav_icon) }}" alt="Fav Icon" width="32" class="rounded">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="primary_color">{{ trans_db('dashboard.Primary Color', 'اللون الأساسي') }}</label>
                                                                    <input type="color" class="form-control" id="primary_color" name="primary_color" value="{{ old('primary_color', $Setting->primary_color ?? '#28c76f') }}">
                                                                    <small class="text-muted">هذا اللون سيتحكم في هوية الموقع الرئيسية</small>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="primary_color_to">{{ trans_db('dashboard.Gradient Color', 'لون التدرج') }}</label>
                                                                    <input type="color" class="form-control" id="primary_color_to" name="primary_color_to" value="{{ old('primary_color_to', $Setting->primary_color_to ?? '#3066d1') }}">
                                                                    <small class="text-muted">هذا اللون يستخدم لنهاية تدرج الألوان</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Contact & Social Tab -->
                                                    <div class="tab-pane" id="contact" aria-labelledby="contact-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="contact_email">{{ trans_db('dashboard.contact_email') }}</label>
                                                                    <input type="email" id="contact_email" class="form-control" name="contact_email"
                                                                        value="{{ old('contact_email', $Setting->contact_email) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="phone">{{ trans_db('dashboard.phone') }}</label>
                                                                    <input type="text" id="phone" class="form-control" name="phone"
                                                                        value="{{ old('phone', $Setting->phone) }}" />
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <hr>
                                                                <h6 class="mb-1 text-primary font-weight-bold"><i data-feather="map-pin"></i> {{ trans_db('dashboard.Showroom Address', 'عنوان المعرض / المقر الرئيسي') }}</h6>
                                                            </div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.Showroom Address', 'عنوان المعرض') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="address[{{ $localeCode }}]"
                                                                        value="{{ old("address.$localeCode", $Setting->translate('address', $localeCode)) }}" placeholder="مثال: 35 عمارات التوفيقية، مدينة نصر، القاهرة..." />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12">
                                                                <hr>
                                                                <h6 class="mb-1 text-primary font-weight-bold"><i data-feather="home"></i> {{ trans_db('dashboard.Factory Address', 'عنوان المصنع') }}</h6>
                                                            </div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.Factory Address', 'عنوان المصنع') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="factory_address[{{ $localeCode }}]"
                                                                        value="{{ old("factory_address.$localeCode", $Setting->translate('factory_address', $localeCode)) }}" placeholder="مثال: المنطقة الصناعية - 6 أكتوبر - الجيزة..." />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12">
                                                                <hr>
                                                                <h6 class="mb-1 text-primary font-weight-bold"><i data-feather="map"></i> {{ trans_db('dashboard.Additional Address', 'العنوان الإضافي') }}</h6>
                                                            </div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.Additional Address', 'العنوان الإضافي') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="additional_address[{{ $localeCode }}]"
                                                                        value="{{ old("additional_address.$localeCode", $Setting->translate('additional_address', $localeCode)) }}" placeholder="مثال: فرع الإسكندرية / عنوان آخر..." />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12">
                                                                <hr>
                                                                <h5 class="mb-1 mt-2"><i data-feather="share-2"></i> {{ trans_db('dashboard.Social Media') }}</h5>
                                                            </div>

                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="facebook">{{ trans_db('dashboard.facebook') }}</label>
                                                                    <input type="text" id="facebook" class="form-control" name="facebook" value="{{ old('facebook', $Setting->facebook) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="instagram">{{ trans_db('dashboard.instagram') }}</label>
                                                                    <input type="text" id="instagram" class="form-control" name="instagram" value="{{ old('instagram', $Setting->instagram) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="twitter">{{ trans_db('dashboard.twitter') }}</label>
                                                                    <input type="text" id="twitter" class="form-control" name="twitter" value="{{ old('twitter', $Setting->twitter) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="youtube">{{ trans_db('dashboard.youtube') }}</label>
                                                                    <input type="text" id="youtube" class="form-control" name="youtube" value="{{ old('youtube', $Setting->youtube) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="whatsapp">{{ trans_db('dashboard.whatsapp') }}</label>
                                                                    <input type="text" id="whatsapp" class="form-control" name="whatsapp" value="{{ old('whatsapp', $Setting->whatsapp) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="linkedin">{{ trans_db('dashboard.linkedin') }}</label>
                                                                    <input type="text" id="linkedin" class="form-control" name="linkedin" value="{{ old('linkedin', $Setting->linkedin) }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Gift Tab -->
                                                    <div class="tab-pane" id="gift" aria-labelledby="gift-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="min_order_for_gift">{{ trans_db('dashboard.min_order_for_gift') }}</label>
                                                                    <input type="number" step="0.01" id="min_order_for_gift" class="form-control" name="min_order_for_gift" value="{{ old('min_order_for_gift', $Setting->min_order_for_gift) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="max_gift_items">{{ trans_db('dashboard.max_gift_items') }}</label>
                                                                    <input type="number" id="max_gift_items" class="form-control" name="max_gift_items" value="{{ old('max_gift_items', $Setting->max_gift_items) }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Messages Tab -->
                                                    <div class="tab-pane" id="messages" aria-labelledby="messages-tab" role="tabpanel">
                                                        <div class="row">
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.msg_processing') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="msg_processing[{{ $localeCode }}]" rows="2">{{ old("msg_processing.$localeCode", $Setting->translate('msg_processing', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12"><hr></div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.msg_shipped') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="msg_shipped[{{ $localeCode }}]" rows="2">{{ old("msg_shipped.$localeCode", $Setting->translate('msg_shipped', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12"><hr></div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.msg_completed') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="msg_completed[{{ $localeCode }}]" rows="2">{{ old("msg_completed.$localeCode", $Setting->translate('msg_completed', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12"><hr></div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.msg_cancelled') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="msg_cancelled[{{ $localeCode }}]" rows="2">{{ old("msg_cancelled.$localeCode", $Setting->translate('msg_cancelled', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12"><hr></div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.msg_delivered') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" name="msg_delivered[{{ $localeCode }}]" rows="2">{{ old("msg_delivered.$localeCode", $Setting->translate('msg_delivered', $localeCode)) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <!-- Social Login Tab -->
                                                    <div class="tab-pane" id="social-login" aria-labelledby="social-login-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="mb-1 mt-2"><i data-feather="facebook"></i> Facebook Settings</h5>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="facebook_client_id">Facebook Client ID</label>
                                                                    <input type="text" id="facebook_client_id" class="form-control" name="facebook_client_id" value="{{ old('facebook_client_id', $Setting->facebook_client_id) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="facebook_client_secret">Facebook Client Secret</label>
                                                                    <input type="text" id="facebook_client_secret" class="form-control" name="facebook_client_secret" value="{{ old('facebook_client_secret', $Setting->facebook_client_secret) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="facebook_redirect">Facebook Redirect URL</label>
                                                                    <input type="text" id="facebook_redirect" class="form-control" name="facebook_redirect" value="{{ old('facebook_redirect', $Setting->facebook_redirect) }}" />
                                                                    <small class="text-muted">Example: https://yourdomain.com/login/facebook/callback</small>
                                                                </div>
                                                            </div>

                                                            <div class="col-12"><hr></div>

                                                            <div class="col-12">
                                                                <h5 class="mb-1 mt-2"><i class="fab fa-google"></i> Google Settings</h5>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="google_client_id">Google Client ID</label>
                                                                    <input type="text" id="google_client_id" class="form-control" name="google_client_id" value="{{ old('google_client_id', $Setting->google_client_id) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="google_client_secret">Google Client Secret</label>
                                                                    <input type="text" id="google_client_secret" class="form-control" name="google_client_secret" value="{{ old('google_client_secret', $Setting->google_client_secret) }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="google_redirect">Google Redirect URL</label>
                                                                    <input type="text" id="google_redirect" class="form-control" name="google_redirect" value="{{ old('google_redirect', $Setting->google_redirect) }}" />
                                                                    <small class="text-muted">Example: https://yourdomain.com/login/google/callback</small>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    <!-- Ratings Tab -->
                                                    <div class="tab-pane" id="ratings" aria-labelledby="ratings-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="mb-1 mt-2 theme-text-primary"><i data-feather="star"></i> {{ trans_db('dashboard.Ratings & Reviews Control') }}</h5>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" class="custom-control-input" id="show_ratings" name="show_ratings" {{ $Setting->show_ratings ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="show_ratings">{{ trans_db('dashboard.Show Ratings in Frontend') }}</label>
                                                                    </div>
                                                                    <p><small class="text-muted">{{ trans_db('dashboard.show_ratings_desc') }}</small></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <div class="custom-control custom-switch custom-control-inline">
                                                                        <input type="checkbox" class="custom-control-input" id="enable_reviews" name="enable_reviews" {{ $Setting->enable_reviews ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="enable_reviews">{{ trans_db('dashboard.Enable Adding Reviews') }}</label>
                                                                    </div>
                                                                    <p><small class="text-muted">{{ trans_db('dashboard.enable_reviews_desc') }}</small></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Why Choose Us Tab -->
                                                    <div class="tab-pane" id="why-choose-us" aria-labelledby="why-choose-us-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="mb-1 mt-2 theme-text-primary"><i data-feather="help-circle"></i> {{ trans_db('dashboard.Why Choose Us') }}</h5>
                                                            </div>
                                                            
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.why_choose_us_title') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="why_choose_us_title[{{ $localeCode }}]"
                                                                        value="{{ old("why_choose_us_title.$localeCode", $Setting->translate('why_choose_us_title', $localeCode)) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.why_choose_us_subtitle') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="why_choose_us_subtitle[{{ $localeCode }}]"
                                                                        value="{{ old("why_choose_us_subtitle.$localeCode", $Setting->translate('why_choose_us_subtitle', $localeCode)) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-12"><hr><h6 class="mb-2"><i data-feather="grid"></i> {{ trans_db('dashboard.why_choose_us_items') }}</h6></div>

                                                            @php
                                                                $rawItems = $Setting->why_choose_us_items ?? \App\Models\Setting::defaultWhyChooseUsItems();
                                                            @endphp

                                                            @foreach($rawItems as $index => $item)
                                                            <div class="col-12 mb-2 p-2 border rounded" style="background: #f8f9fa;">
                                                                <h6 class="text-primary font-weight-bold">العنصر {{ $index + 1 }}</h6>
                                                                <input type="hidden" name="why_choose_us_items[{{ $index }}][id]" value="{{ $item['id'] ?? ($index + 1) }}">
                                                                <div class="row">
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="form-group mb-1">
                                                                            <label>الأيقونة (Icon Key)</label>
                                                                            <select class="form-control" name="why_choose_us_items[{{ $index }}][icon]">
                                                                                <option value="shield_check" {{ ($item['icon'] ?? '') == 'shield_check' ? 'selected' : '' }}>shield_check (خامات وأمان)</option>
                                                                                <option value="award" {{ ($item['icon'] ?? '') == 'award' ? 'selected' : '' }}>award (جودة وهندسة)</option>
                                                                                <option value="maximize" {{ ($item['icon'] ?? '') == 'maximize' ? 'selected' : '' }}>maximize (استغلال مساحات)</option>
                                                                                <option value="wrench" {{ ($item['icon'] ?? '') == 'wrench' ? 'selected' : '' }}>wrench (تركيب وصيانة)</option>
                                                                                <option value="layers" {{ ($item['icon'] ?? '') == 'layers' ? 'selected' : '' }}>layers (أحمال ثقيلة)</option>
                                                                                <option value="truck" {{ ($item['icon'] ?? '') == 'truck' ? 'selected' : '' }}>truck (توريد ونقل)</option>
                                                                                <option value="box" {{ ($item['icon'] ?? '') == 'box' ? 'selected' : '' }}>box (تخزين ذكي)</option>
                                                                                <option value="stethoscope" {{ ($item['icon'] ?? '') == 'stethoscope' ? 'selected' : '' }}>stethoscope (استشارات)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="form-group mb-1">
                                                                            <label>العنوان (عربي)</label>
                                                                            <input type="text" class="form-control" name="why_choose_us_items[{{ $index }}][title][ar]" value="{{ is_array($item['title'] ?? null) ? ($item['title']['ar'] ?? '') : ($item['title'] ?? '') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-12">
                                                                        <div class="form-group mb-1">
                                                                            <label>العنوان (English)</label>
                                                                            <input type="text" class="form-control" name="why_choose_us_items[{{ $index }}][title][en]" value="{{ is_array($item['title'] ?? null) ? ($item['title']['en'] ?? '') : ($item['title'] ?? '') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group mb-0">
                                                                            <label>الوصف (عربي)</label>
                                                                            <textarea class="form-control" rows="2" name="why_choose_us_items[{{ $index }}][description][ar]">{{ is_array($item['description'] ?? null) ? ($item['description']['ar'] ?? '') : ($item['description'] ?? '') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group mb-0">
                                                                            <label>الوصف (English)</label>
                                                                            <textarea class="form-control" rows="2" name="why_choose_us_items[{{ $index }}][description][en]">{{ is_array($item['description'] ?? null) ? ($item['description']['en'] ?? '') : ($item['description'] ?? '') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <!-- Catalog Download Tab -->
                                                    <div class="tab-pane" id="catalog" aria-labelledby="catalog-tab" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="mb-1 mt-2 theme-text-primary"><i data-feather="file-text"></i> {{ trans_db('dashboard.Catalog Download Settings') }}</h5>
                                                            </div>

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.Catalog Title') }} ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="catalog_title[{{ $localeCode }}]"
                                                                        value="{{ old("catalog_title.$localeCode", $Setting->translate('catalog_title', $localeCode) ?: ($localeCode == 'ar' ? 'حمّل كتالوج المنتجات الطبية الكامل' : 'Download Full Medical Products Catalog')) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>{{ trans_db('dashboard.Catalog Description') }} ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" rows="2" name="catalog_description[{{ $localeCode }}]">{{ old("catalog_description.$localeCode", $Setting->translate('catalog_description', $localeCode) ?: ($localeCode == 'ar' ? 'استعرض أكثر من 10,000 منتج طبي. مثالي للمستشفيات، العيادات، وطلبات الجملة.' : 'Browse over 10,000 medical products. Ideal for hospitals, clinics, and wholesale orders.')) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label for="catalog_pdf">{{ trans_db('dashboard.Upload Catalog PDF') }}</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="catalog_pdf" name="catalog_pdf" accept="application/pdf">
                                                                        <label class="custom-file-label" for="catalog_pdf">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    @if($Setting->catalog_pdf)
                                                                        <div class="mt-1">
                                                                            <a href="{{ asset($Setting->catalog_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                <i data-feather="download"></i> {{ trans_db('dashboard.Current PDF File') }}
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- About Qayem Wraf Section Tab -->
                                                    <div class="tab-pane" id="about-section" aria-labelledby="about-section-tab" role="tabpanel">
                                                        @php
                                                            $aboutDefaults = \App\Models\Setting::defaultAboutSection();
                                                            $currentStats = $Setting->about_stats ?? $aboutDefaults['stats'];
                                                            $currentFeatures = $Setting->about_features ?? $aboutDefaults['features'];
                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="mb-2 theme-text-primary"><i data-feather="type"></i> {{ trans_db('dashboard.Main Texts', 'النصوص والفقرات الرئيسية') }}</h5>
                                                            </div>

                                                            <!-- Tag (Badge) -->
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>الشارة العلوية ({{ $properties['native'] }}) - Tag / Badge</label>
                                                                    <input type="text" class="form-control" name="about_tag[{{ $localeCode }}]"
                                                                        value="{{ old("about_tag.$localeCode", $Setting->translate('about_tag', $localeCode) ?: ($aboutDefaults['tag'][$localeCode] ?? '')) }}" placeholder="عن قائم ورف" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <!-- Title -->
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>العنوان الرئيسي ({{ $properties['native'] }})</label>
                                                                    <input type="text" class="form-control" name="about_title[{{ $localeCode }}]"
                                                                        value="{{ old("about_title.$localeCode", $Setting->translate('about_title', $localeCode) ?: ($aboutDefaults['title'][$localeCode] ?? '')) }}" />
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <!-- Highlight Text -->
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label>النص المميز باللون الذهبي ({{ $properties['native'] }}) - Highlight Word</label>
                                                                    <input type="text" class="form-control" name="about_highlight_text[{{ $localeCode }}]"
                                                                        value="{{ old("about_highlight_text.$localeCode", $Setting->translate('about_highlight_text', $localeCode) ?: ($aboutDefaults['highlight_text'][$localeCode] ?? '')) }}" />
                                                                    <small class="text-muted">الكلمة أو العبارة التي ستظهر باللون الذهبي داخل العنوان</small>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <!-- Description -->
                                                            @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>الفقرة التعريفية ({{ $properties['native'] }})</label>
                                                                    <textarea class="form-control" rows="3" name="about_description[{{ $localeCode }}]">{{ old("about_description.$localeCode", $Setting->translate('about_description', $localeCode) ?: ($aboutDefaults['description'][$localeCode] ?? '')) }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endforeach

                                                            <!-- 4 Statistics Counters -->
                                                            <div class="col-12"><hr><h5 class="mb-2 theme-text-primary"><i data-feather="bar-chart-2"></i> العدادات والإحصائيات (4 عناصر)</h5></div>
                                                            @for($i = 0; $i < 4; $i++)
                                                            @php
                                                                $stat = $currentStats[$i] ?? ($aboutDefaults['stats'][$i] ?? ['value' => '', 'label' => ['ar' => '', 'en' => '']]);
                                                            @endphp
                                                            <div class="col-md-6 col-12 mb-2 p-2 border rounded" style="background: #fdfdfd;">
                                                                <h6 class="font-weight-bold text-secondary">إحصائية {{ $i + 1 }}</h6>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="form-group mb-1">
                                                                            <label>الرقم / القيمة</label>
                                                                            <input type="text" class="form-control" name="about_stats[{{ $i }}][value]" value="{{ old("about_stats.$i.value", $stat['value'] ?? '') }}" placeholder="+15">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group mb-1">
                                                                            <label>التسمية (عربي)</label>
                                                                            <input type="text" class="form-control" name="about_stats[{{ $i }}][label][ar]" value="{{ old("about_stats.$i.label.ar", is_array($stat['label'] ?? null) ? ($stat['label']['ar'] ?? '') : ($stat['label'] ?? '')) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group mb-1">
                                                                            <label>التسمية (EN)</label>
                                                                            <input type="text" class="form-control" name="about_stats[{{ $i }}][label][en]" value="{{ old("about_stats.$i.label.en", is_array($stat['label'] ?? null) ? ($stat['label']['en'] ?? '') : '') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endfor

                                                            <!-- 3 Feature Cards -->
                                                            <div class="col-12"><hr><h5 class="mb-2 theme-text-primary"><i data-feather="check-square"></i> بطاقات المميزات (3 بطاقات)</h5></div>
                                                            @for($j = 0; $j < 3; $j++)
                                                            @php
                                                                $feat = $currentFeatures[$j] ?? ($aboutDefaults['features'][$j] ?? ['icon' => 'shield', 'title' => ['ar' => '', 'en' => ''], 'description' => ['ar' => '', 'en' => '']]);
                                                            @endphp
                                                            <div class="col-md-4 col-12 mb-2 p-2 border rounded" style="background: #f8f9fa;">
                                                                <h6 class="font-weight-bold text-primary">الميزة {{ $j + 1 }}</h6>
                                                                <div class="form-group mb-1">
                                                                    <label>الأيقونة</label>
                                                                    <select class="form-control" name="about_features[{{ $j }}][icon]">
                                                                        <option value="shield" {{ ($feat['icon'] ?? '') == 'shield' ? 'selected' : '' }}>درع أمان وجودة (Shield)</option>
                                                                        <option value="truck" {{ ($feat['icon'] ?? '') == 'truck' ? 'selected' : '' }}>شاحنة وتوصيل (Truck)</option>
                                                                        <option value="headset" {{ ($feat['icon'] ?? '') == 'headset' ? 'selected' : '' }}>سماعة واستشارات (Headset)</option>
                                                                        <option value="award" {{ ($feat['icon'] ?? '') == 'award' ? 'selected' : '' }}>وسام تميز (Award)</option>
                                                                        <option value="wrench" {{ ($feat['icon'] ?? '') == 'wrench' ? 'selected' : '' }}>معدات وتركيب (Wrench)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>العنوان (عربي)</label>
                                                                    <input type="text" class="form-control" name="about_features[{{ $j }}][title][ar]" value="{{ old("about_features.$j.title.ar", is_array($feat['title'] ?? null) ? ($feat['title']['ar'] ?? '') : ($feat['title'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>العنوان (EN)</label>
                                                                    <input type="text" class="form-control" name="about_features[{{ $j }}][title][en]" value="{{ old("about_features.$j.title.en", is_array($feat['title'] ?? null) ? ($feat['title']['en'] ?? '') : '') }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>الوصف (عربي)</label>
                                                                    <textarea class="form-control" rows="2" name="about_features[{{ $j }}][description][ar]">{{ old("about_features.$j.description.ar", is_array($feat['description'] ?? null) ? ($feat['description']['ar'] ?? '') : ($feat['description'] ?? '')) }}</textarea>
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <label>الوصف (EN)</label>
                                                                    <textarea class="form-control" rows="2" name="about_features[{{ $j }}][description][en]">{{ old("about_features.$j.description.en", is_array($feat['description'] ?? null) ? ($feat['description']['en'] ?? '') : '') }}</textarea>
                                                                </div>
                                                            </div>
                                                            @endfor

                                                            <!-- Images & Badges Section -->
                                                            <div class="col-12"><hr><h5 class="mb-2 theme-text-primary"><i data-feather="image"></i> الصور والشارات التفاعلية (Images & Floating Badges)</h5></div>

                                                            <!-- Image 1 -->
                                                            <div class="col-md-4 col-12 mb-3 p-2 border rounded">
                                                                <h6 class="font-weight-bold text-dark">الصورة الرئيسية (الكبيرة يميناً)</h6>
                                                                <div class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="about_image_1" name="about_image_1" accept="image/*">
                                                                        <label class="custom-file-label" for="about_image_1">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    <div class="mt-1">
                                                                        <img src="{{ asset($Setting->about_image_1 ?? $aboutDefaults['image_1']) }}" alt="About Image 1" class="img-fluid rounded" style="max-height: 120px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>عنوان شارة الصورة 1 (عربي)</label>
                                                                    <input type="text" class="form-control" name="about_image_1_badge_title[ar]" value="{{ old('about_image_1_badge_title.ar', $Setting->translate('about_image_1_badge_title', 'ar') ?: ($aboutDefaults['image_1_badge_title']['ar'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>عنوان شارة الصورة 1 (EN)</label>
                                                                    <input type="text" class="form-control" name="about_image_1_badge_title[en]" value="{{ old('about_image_1_badge_title.en', $Setting->translate('about_image_1_badge_title', 'en') ?: ($aboutDefaults['image_1_badge_title']['en'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>نص الشارة الفرعي 1 (عربي)</label>
                                                                    <input type="text" class="form-control" name="about_image_1_badge_subtitle[ar]" value="{{ old('about_image_1_badge_subtitle.ar', $Setting->translate('about_image_1_badge_subtitle', 'ar') ?: ($aboutDefaults['image_1_badge_subtitle']['ar'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <label>نص الشارة الفرعي 1 (EN)</label>
                                                                    <input type="text" class="form-control" name="about_image_1_badge_subtitle[en]" value="{{ old('about_image_1_badge_subtitle.en', $Setting->translate('about_image_1_badge_subtitle', 'en') ?: ($aboutDefaults['image_1_badge_subtitle']['en'] ?? '')) }}">
                                                                </div>
                                                            </div>

                                                            <!-- Image 2 -->
                                                            <div class="col-md-4 col-12 mb-3 p-2 border rounded">
                                                                <h6 class="font-weight-bold text-dark">الصورة الثانية (أعلى اليسار)</h6>
                                                                <div class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="about_image_2" name="about_image_2" accept="image/*">
                                                                        <label class="custom-file-label" for="about_image_2">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    <div class="mt-1">
                                                                        <img src="{{ asset($Setting->about_image_2 ?? $aboutDefaults['image_2']) }}" alt="About Image 2" class="img-fluid rounded" style="max-height: 120px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>نص شارة الصورة 2 (عربي)</label>
                                                                    <input type="text" class="form-control" name="about_image_2_badge[ar]" value="{{ old('about_image_2_badge.ar', $Setting->translate('about_image_2_badge', 'ar') ?: ($aboutDefaults['image_2_badge']['ar'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <label>نص شارة الصورة 2 (EN)</label>
                                                                    <input type="text" class="form-control" name="about_image_2_badge[en]" value="{{ old('about_image_2_badge.en', $Setting->translate('about_image_2_badge', 'en') ?: ($aboutDefaults['image_2_badge']['en'] ?? '')) }}">
                                                                </div>
                                                            </div>

                                                            <!-- Image 3 & Experience Badge -->
                                                            <div class="col-md-4 col-12 mb-3 p-2 border rounded">
                                                                <h6 class="font-weight-bold text-dark">الصورة الثالثة + شارة سنوات الخبرة</h6>
                                                                <div class="form-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="about_image_3" name="about_image_3" accept="image/*">
                                                                        <label class="custom-file-label" for="about_image_3">{{ trans_db('dashboard.Choose file') }}</label>
                                                                    </div>
                                                                    <div class="mt-1">
                                                                        <img src="{{ asset($Setting->about_image_3 ?? $aboutDefaults['image_3']) }}" alt="About Image 3" class="img-fluid rounded" style="max-height: 120px;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>سنوات الخبرة (الرقم)</label>
                                                                    <input type="text" class="form-control" name="about_experience_years" value="{{ old('about_experience_years', $Setting->about_experience_years ?: $aboutDefaults['experience_years']) }}" placeholder="15+">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>عنوان شارة الخبرة (عربي)</label>
                                                                    <input type="text" class="form-control" name="about_experience_title[ar]" value="{{ old('about_experience_title.ar', $Setting->translate('about_experience_title', 'ar') ?: ($aboutDefaults['experience_title']['ar'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>عنوان شارة الخبرة (EN)</label>
                                                                    <input type="text" class="form-control" name="about_experience_title[en]" value="{{ old('about_experience_title.en', $Setting->translate('about_experience_title', 'en') ?: ($aboutDefaults['experience_title']['en'] ?? '')) }}">
                                                                </div>
                                                                <div class="form-group mb-1">
                                                                    <label>نص الشارة الفرعي (عربي)</label>
                                                                    <textarea class="form-control" rows="2" name="about_experience_subtitle[ar]">{{ old('about_experience_subtitle.ar', $Setting->translate('about_experience_subtitle', 'ar') ?: ($aboutDefaults['experience_subtitle']['ar'] ?? '')) }}</textarea>
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <label>نص الشارة الفرعي (EN)</label>
                                                                    <textarea class="form-control" rows="2" name="about_experience_subtitle[en]">{{ old('about_experience_subtitle.en', $Setting->translate('about_experience_subtitle', 'en') ?: ($aboutDefaults['experience_subtitle']['en'] ?? '')) }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary mr-1">{{ trans_db('dashboard.Submit') }}</button>
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