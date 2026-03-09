@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}

    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}

    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>

    <style>

        .image_area {
            position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg{
            max-width: 1000px !important;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }

    </style>

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        rel="stylesheet"
    />

    <style type="text/css">
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white !important;
            background-color: #0d6efd;
            padding: 0.35rem;
            border-radius: 10px;
        }

        .bootstrap-tagsinput {
            padding: 10px 10px;
        }
    </style>
@endsection

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users edit start -->
            <section class="app-user-edit">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">

                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <!-- Account Tab starts -->
                            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                <form class="form-validate" role="form"  action="{{ \LaravelLocalization::localizeUrl('admin-2023/settings/update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
        
                                    @include('dashboard.admin.component.page_error' , ['errors' => $errors])
        
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{ isset($Setting->id) ?? null }}">
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('app_name') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.app_name') }} : </label>
                                                        <input type="text" class="form-control" name="app_name" value="{{ $Setting->app_name }}">
                                                        <span class="text-danger">{{ $errors->first('app_name') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('app_meta_title') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.app_meta_title') }} : </label>
                                                        <input type="text" class="form-control" name="app_meta_title" value="{{ $Setting->app_meta_title }}">
                                                        <span class="text-danger">{{ $errors->first('app_meta_title') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                                        <label for="exampleInputEmail3">{{ trans_db('dashboard.video_link') }}</label>
                                                        {!! Form::text('video_link', $Setting->video_link, ['placeholder'=> '<iframe width="727" height="409" src="https://www.youtube.com/embed/dLwsoM3WnuQ" title="CAR TYRES | How It&#39;s Made" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>','class' => "form-control" ]) !!}
                                                        <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.video_file') }}</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile2" name="video_file">
                                                                    <label class="custom-file-label" for="customFile2" style="padding-right: 83px;">{{ trans_db('dashboard.video_file') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.music_file') }}</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile3" name="music_file">
                                                                    <label class="custom-file-label" for="customFile3" style="padding-right: 83px;">{{ trans_db('dashboard.music_file') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                @if (isset($Setting->video_file) && $Setting->video_file != null)
                                                    <div class="col-lg-4">
                                                        <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/settings/delete_video') }}">
                                                            <i data-feather='trash'></i>
                                                        </a>

                                                        <video controls width="300">
                                                            <source src="{{ asset('website/uploads/videos/' . $Setting->video_file) }}" type="video/mp4" style="width: 150px; height: 150px">
                                                        </video>
                                                    </div>      
                                                @endif
                                                
                                                @if (isset($Setting->music_file) && $Setting->music_file != null)
                                                    <div class="col-lg-4">
                                                        <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/settings/delete_music_file') }}">
                                                            <i data-feather='trash'></i>
                                                        </a>
                                                        <audio controls>
                                                            {{-- <source src="horse.ogg" type="audio/ogg"> --}}
                                                            <source src="{{ asset('website/uploads/videos/' . $Setting->music_file) }}" type="audio/mpeg">
                                                          </audio>
                                                    </div>      
                                                @endif
                                                
        
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.logo') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:196 - {{ trans_db('dashboard.height') }}:36)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="logo">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.logo') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->logo }}" alt="">
                                                </div>
        
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.logo_dark') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:196 - {{ trans_db('dashboard.height') }}:36)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="logo_dark">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.logo_dark') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->logo_dark }}" alt="">
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.fav_icon') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:160 - {{ trans_db('dashboard.height') }}:34)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="fav_icon">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.fav_icon') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->fav_icon }}" alt="">
                                                </div>
        
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('app_meta_desc') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.app_meta_desc') }} : </label>
                                                        <textarea class="form-control" name="app_meta_desc" cols="30" rows="5">{{ $Setting->app_meta_desc }}</textarea>
                                                        <span class="text-danger">{{ $errors->first('app_meta_desc') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="id" value="{{ $Setting->id }}">
        
                                                <x-admin.setting.input :col="'4'" :field="'phone1'" :value="$Setting->phone1" :trans="trans_db('dashboard.Phone')" />
                                                <x-admin.setting.input :col="'4'" :field="'contact_email'" :value="$Setting->contact_email" :trans="trans_db('dashboard.Email')" />
                                                {{-- <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('phone1') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.Phone') }} 1: </label>
                                                        <input type="text" class="form-control" name="phone1" value="{{ $Setting->phone1 }}">
                                                        <span class="text-danger">{{ $errors->first('phone1') }}</span>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('phone2') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.Phone') }} 2: </label>
                                                        <input type="text" class="form-control" name="phone2" value="{{ $Setting->phone2 }}">
                                                        <span class="text-danger">{{ $errors->first('phone2') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('phone3') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.Phone') }} 3: </label>
                                                        <input type="text" class="form-control" name="phone3" value="{{ $Setting->phone3 }}">
                                                        <span class="text-danger">{{ $errors->first('phone3') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('phone4') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.Phone') }} 4: </label>
                                                        <input type="text" class="form-control" name="phone4" value="{{ $Setting->phone4 }}">
                                                        <span class="text-danger">{{ $errors->first('phone4') }}</span>
                                                    </div>
                                                </div>
        
                                                {{-- <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.Email') }} : </label>
                                                        <input type="text" class="form-control" name="contact_email" value="{{ $Setting->contact_email }}">
                                                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                                    </div>
                                                </div> --}}
                                                
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.Facebook') }} : </label>
                                                        <input type="text" class="form-control" name="facebook" value="{{ $Setting->facebook }}">
                                                        <span class="text-danger">{{ $errors->first('facebook') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('whatsapp') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.Whats') }} : </label>
                                                        <input type="text" class="form-control" name="whatsapp" value="{{ $Setting->whatsapp }}">
                                                        <span class="text-danger">{{ $errors->first('whatsapp') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('instagram') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.Instagram') }} : </label>
                                                        <input type="text" class="form-control" name="instagram" value="{{ $Setting->instagram }}">
                                                        <span class="text-danger">{{ $errors->first('instagram') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.Twitter') }} :</label>
                                                        <input type="text" class="form-control" name="twitter" value="{{ $Setting->twitter }}">
                                                        <span class="text-danger">{{ $errors->first('twitter') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('youtube') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.YouTube') }} :</label>
                                                        <input type="text" class="form-control" name="youtube" value="{{ $Setting->youtube }}">
                                                        <span class="text-danger">{{ $errors->first('youtube') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                                                        <label>{{ trans_db('dashboard.linkedin') }} :</label>
                                                        <input type="text" class="form-control" name="linkedin" value="{{ $Setting->linkedin }}">
                                                        <span class="text-danger">{{ $errors->first('linkedin') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-12">
                                                    <div class="form-group {{ $errors->has('address1') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.address1') }} : </label>
                                                        <input type="text" class="form-control" name="address1" value="{{ $Setting->address1 }}">
                                                        <span class="text-danger">{{ $errors->first('address1') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('address2') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.address2') }} : </label>
                                                        <input type="text" class="form-control" name="address2" value="{{ $Setting->address2 }}">
                                                        <span class="text-danger">{{ $errors->first('address2') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-6">
                                                    <div class="form-group {{ $errors->has('address3') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.address3') }} : </label>
                                                        <input type="text" class="form-control" name="address3" value="{{ $Setting->address3 }}">
                                                        <span class="text-danger">{{ $errors->first('address3') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-md-12">
                                                    <div class="form-group {{ $errors->has('header_code') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.header_code') }} : </label>
                                                        <textarea class="form-control" name="header_code" cols="30" rows="6">{{ $Setting->header_code }}</textarea>
                                                        <span class="text-danger">{{ $errors->first('header_code') }}</span>
                                                    </div>
                                                </div>

                                                <hr class="col-lg-12 v-divider v-theme--light" aria-orientation="horizontal" role="separator">
        
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.vendor_header_image') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:196 - {{ trans_db('dashboard.height') }}:36)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="vendor_header_image">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.vendor_header_image') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.vendor_header_image') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:196 - {{ trans_db('dashboard.height') }}:36)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="vendor_header_image">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.vendor_header_image') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                                        <label for="exampleInputEmail3">{{ trans_db('dashboard.video_link') }}</label>
                                                        {!! Form::text('video_link', $Setting->video_link, ['placeholder'=> '<iframe width="727" height="409" src="https://www.youtube.com/embed/dLwsoM3WnuQ" title="CAR TYRES | How It&#39;s Made" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>','class' => "form-control" ]) !!}
                                                        <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.video_file') }}</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile2" name="video_file">
                                                                    <label class="custom-file-label" for="customFile2" style="padding-right: 83px;">{{ trans_db('dashboard.video_file') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if (isset($Setting->video_file) && $Setting->video_file != null)
                                                    <div class="col-lg-4">
                                                        <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/settings/delete_video') }}">
                                                            <i data-feather='trash'></i>
                                                        </a>

                                                        <video controls width="300">
                                                            <source src="{{ asset('website/uploads/videos/' . $Setting->video_file) }}" type="video/mp4" style="width: 150px; height: 150px">
                                                        </video>
                                                    </div>      
                                                @endif

                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/vendor/welcome') }}/{{ $Setting->vendor_header_image }}" alt="">
                                                </div>

                                                <hr class="col-lg-12 v-divider v-theme--light" aria-orientation="horizontal" role="separator">

                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('intro_title1') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.intro_title1') }} : </label>
                                                        <input type="text" class="form-control" name="intro_title1" value="{{ $Setting->intro_title1 }}">
                                                        <span class="text-danger">{{ $errors->first('intro_title1') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('slug1') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.slug1') }} : </label>
                                                        <input type="text" class="form-control" name="slug1" value="{{ $Setting->slug1 }}">
                                                        <span class="text-danger">{{ $errors->first('slug1') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.image1') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:500 - {{ trans_db('dashboard.height') }}:500)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="image1">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.image1') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->image1 }}" alt="">
                                                </div>

                                                <hr class="v-divider v-theme--light" aria-orientation="horizontal" role="separator">

                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('intro_title2') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.intro_title2') }} : </label>
                                                        <input type="text" class="form-control" name="intro_title2" value="{{ $Setting->intro_title2 }}">
                                                        <span class="text-danger">{{ $errors->first('intro_title2') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('slug2') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.slug2') }} : </label>
                                                        <input type="text" class="form-control" name="slug2" value="{{ $Setting->slug2 }}">
                                                        <span class="text-danger">{{ $errors->first('slug2') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.image2') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:500 - {{ trans_db('dashboard.height') }}:500)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="image2">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.image2') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->image2 }}" alt="">
                                                </div>

                                                <hr class="v-divider v-theme--light" aria-orientation="horizontal" role="separator">

                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('intro_title3') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.intro_title3') }} : </label>
                                                        <input type="text" class="form-control" name="intro_title3" value="{{ $Setting->intro_title3 }}">
                                                        <span class="text-danger">{{ $errors->first('intro_title3') }}</span>
                                                    </div>
                                                </div>
        
                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('slug3') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.slug3') }} : </label>
                                                        <input type="text" class="form-control" name="slug3" value="{{ $Setting->slug3 }}">
                                                        <span class="text-danger">{{ $errors->first('slug3') }}</span>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.image3') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:500 - {{ trans_db('dashboard.height') }}:500)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="image3">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.image3') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->image3 }}" alt="">
                                                </div>

                                                <hr class="v-divider v-theme--light" aria-orientation="horizontal" role="separator">

                                                <div class="col-sm-6">
                                                    <div class="form-group {{ $errors->has('splash_title') ? 'has-error' : '' }}">
                                                        <label> {{ trans_db('dashboard.splash_title') }} : </label>
                                                        <input type="text" class="form-control" name="splash_title" value="{{ $Setting->splash_title }}">
                                                        <span class="text-danger">{{ $errors->first('splash_title') }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-md-12 product_image">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.splash_image') }}
                                                                    - <span style="color: red;">({{ trans_db('dashboard.width') }}:500 - {{ trans_db('dashboard.height') }}:500)</span>
                                                                </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile4" name="splash_image">
                                                                    <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.splash_image') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" style="text-align:center">
                                                    <img src="{{ asset('website/images/logo') }}/{{ $Setting->splash_image }}" alt="">
                                                </div>                                                

                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Save') }} </button>
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
        
@section('script')
    @include('dashboard.admin.layouts.script')

    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <script>
        $(document).ready(function(){

            var $modal = $('#modal');
            var image = document.getElementById('sample_image');
            var cropper;

            $('#customFile').change(function(event){
                var files = event.target.files;
                var done = function(url){
                    image.src = url;
                    $modal.modal({backdrop: 'static', keyboard: false}, 'show');
                };

                if(files && files.length > 0)
                {
                    reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1.50,
                    viewMode: 1,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:380,
                    height:290
                });

                canvas.toBlob(function(blob){
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        var base64data = reader.result;

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url:'{{ \LaravelLocalization::localizeUrl('admin-2023/blog/cropSlider') }}',
                            method:'POST',
                            data:{image:base64data},
                            success:function(data)
                            {
                                console.log(data);
                                $modal.modal('hide');
                                $('#uploaded_image').attr('src', data);
                                $('#cropped_image').val(data);
                            }
                        });
                    };
                });
            });

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        $(function () {
            $('input')
                .on('change', function (event) {
                    var $element = $(event.target);
                    var $container = $element.closest('.example');

                    if (!$element.data('tagsinput')) return;

                    var val = $element.val();
                    if (val === null) val = 'null';
                    var items = $element.tagsinput('items');

                    $('code', $('pre.val', $container)).html(
                        $.isArray(val)
                            ? JSON.stringify(val)
                            : '"' + val.replace('"', '\\"') + '"'
                    );
                    $('code', $('pre.items', $container)).html(
                        JSON.stringify($element.tagsinput('items'))
                    );
                })
                .trigger('change');
        });
    </script>
@endsection
        