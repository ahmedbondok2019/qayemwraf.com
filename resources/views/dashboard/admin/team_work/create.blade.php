@extends('dashboard.admin.layouts.app')

@section('style')
    
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}

    {!! Html::style('admin/app-assets/vendors/css/file-uploaders/dropzone.min.css') !!}
    @section('style1')
        {!! Html::style('admin/app-assets/css-rtl/plugins/forms/form-file-uploader.css') !!}
    @endsection

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

    
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }
        
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        input:checked + .slider {
          background-color: #f38921;
        }
        
        input:focus + .slider {
          box-shadow: 0 0 1px #f38921;
        }
        
        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }
        
        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }
        
        .slider.round:before {
          border-radius: 50%;
        }
    </style>

    <style>
        .select2-container--classic .select2-selection--single .select2-selection__arrow b, .select2-container--default .select2-selection--single .select2-selection__arrow b {
            padding-left: 0 !important;
        }
    </style>

    <style>
        .team_work-details-border {
            border: 1px solid #EBE9F1;
            border-radius: 0.357rem;
            margin: 3px -1px;
        }
    </style>
@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ trans_db("dashboard.Add New team_work") }}</h2>
                    </div>
                </div>
            </div>

            <div class="content-body">
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
                @php $random_id = \Illuminate\Support\Str::random(80); @endphp

                
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ trans_db('dashboard.Designs') }}</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" style="">
                        <div class="card-body">

                            <section id="dropzone-examples">
                                <!-- multi file upload starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">{{ trans_db('dashboard.team_work Images') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/team_works/uploadImages') }}" method="post" enctype="multipart/form-data" class="dropzone dropzone-area" id="dpz-multiple-files">
                                                    @csrf

                                                    <input type="hidden" name="random_id" value="{{ $random_id }}">
                                                    <div class="dz-message">{{ trans_db('dashboard.Drop files here or click to upload') }}</div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/team_work/createTeamWork') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Idea') }}</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans_db('dashboard.team_work Name') }}</label>
                                            <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.Name') }}" value="{{ old('title') }}" name="title" id="title" />
                                        </div>
                                    </div>
            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('idea') ? 'has-error' : '' }}">
                                            {!! Form::textarea('idea', old('idea'), ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('idea') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 team_work_image">
                                                <div class="form-group">
                                                    <label for="">{{ trans_db('dashboard.primary_image') }}
                                                        - <span style="color: red;">({{ trans_db('dashboard.width') }}:900 - {{ trans_db('dashboard.height') }}:1198)</span>
                                                    </label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile4" name="primary_image" accept="image/*">
                                                        <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.primary_image') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                            <label for="exampleInputEmail3">{{ trans_db('dashboard.video_link') }}</label>
                                            {!! Form::text('video_link', old('video_link'), ['placeholder'=> 'https://www.youtube.com/watch?v=14semTlwyUY','class' => "form-control" ]) !!}
                                            <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                        </div>
                                    </div>
                
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 team_work_image">
                                                <div class="form-group">
                                                    <label for="">{{ trans_db('dashboard.video_file') }}</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile2" name="video_file" accept="video/*">
                                                        <label class="custom-file-label" for="customFile2" style="padding-right: 83px;">{{ trans_db('dashboard.video_file') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Post') }}</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row">            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('posts') ? 'has-error' : '' }}">
                                            {!! Form::textarea('posts', old('posts'), ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('posts') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Sponsored') }}</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row">            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('sponsored') ? 'has-error' : '' }}">
                                            {!! Form::textarea('sponsored', old('sponsored'), ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('sponsored') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Report') }}</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row">            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('report') ? 'has-error' : '' }}">
                                            {!! Form::textarea('report', old('report'), ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('report') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Result') }}</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="row">            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('result') ? 'has-error' : '' }}">
                                            {!! Form::textarea('result', old('result'), ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('result') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content collapse show" style="">
                            <div class="card-body">
                                <div class="col-12 d-flex flex-sm-row flex-column">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">
                                        {{ trans_db('dashboard.Save') }}
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

@section('script')
    @include('dashboard.admin.layouts.script')

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Include Bootstrap JS (Summernote dependency) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Include Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script> --}}

    {!! Html::script('admin/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-number-input.js') !!}
    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    {!! Html::script('admin/app-assets/vendors/js/file-uploaders/dropzone.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-file-uploader.js') !!}

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,   // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                //focus: true    // set focus to editable area after initializing summernote
            });
        });
    </script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 32,
                    height: 32
                });
            }
        })
    </script>
@endsection
