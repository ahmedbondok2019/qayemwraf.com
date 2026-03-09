@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
        
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

@endsection

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">{{ trans_db("dashboard.Add New product") }}</h2>
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

            <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/products/addProductTrans') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <input type="hidden" name="id" value="{{ $id }}">
                                        
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
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
                                            <label for="name">{{ trans_db('dashboard.product Name') }}</label>
                                            <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.Name') }}" value="{{ old('title') }}" name="title" id="title" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 product_image">
                                                <div class="form-group">
                                                    <label for="">{{ trans_db('dashboard.primary_image') }}
                                                        - <span style="color: red;">({{ trans_db('dashboard.width') }}:500 - {{ trans_db('dashboard.height') }}:500)</span>
                                                    </label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile4" name="primary_image">
                                                        <label class="custom-file-label" for="customFile4" style="padding-right: 83px;">{{ trans_db('dashboard.primary_image') }}</label>
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
                            <h4 class="card-title">{{ trans_db('dashboard.Extra Information') }}</h4>
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
                                    <div class="col-lg-6">
                                        <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                            <label for="exampleInputEmail3">{{ trans_db('dashboard.video_link') }}</label>
                                            {!! Form::text('video_link', old('video_link'), ['placeholder'=> 'https://www.youtube.com/watch?v=14semTlwyUY','class' => "form-control" ]) !!}
                                            <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                        </div>
                                    </div>
                
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 product_image">
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
                
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 product_image">
                                                <div class="form-group">
                                                    <label for="">{{ trans_db('dashboard.pdf_file') }}</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile3" name="pdf_file">
                                                        <label class="custom-file-label" for="customFile3" style="padding-right: 83px;">{{ trans_db('dashboard.pdf_file') }}</label>
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
                            <h4 class="card-title">{{ trans_db('dashboard.Description') }}</h4>
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
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                {{-- <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script> --}}
                                                {{-- <label for="exampleInputEmail1">{{ trans_db('dashboard.Description') }}</label> --}}
                                                {!! Form::textarea('description', old('description'), ['placeholder'=> trans_db('dashboard.Description'),'class' => "form-control" , 'id' => 'summernote' ,'rows'=> 3 ]) !!}
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                                {{-- <script>CKEDITOR.replace('description');</script> --}}
                                            </div>
                                        </div>
                
                                        <div class="col-md-4">
                                            <label for="textarea">{{ trans_db('dashboard.meta_title') }}</label>
                                            <textarea class="form-control" rows="3" placeholder="{{ trans_db('dashboard.Enter ...') }}" name="meta_title">{{ old('meta_title') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="textarea">{{ trans_db('dashboard.meta_description') }}</label>
                                            <textarea class="form-control" rows="3" placeholder="{{ trans_db('dashboard.Enter ...') }}" name="meta_description">{{ old('meta_description') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="textarea">{{ trans_db('dashboard.meta_keywords') }}</label>
                                            <textarea class="form-control" rows="3" placeholder="{{ trans_db('dashboard.Enter ...') }}" name="meta_keywords">{{ old('meta_keywords') }}</textarea>
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
     <script>
         $(document).ready(function() {
             $('#summernote').summernote({
                 height: 300,   // set editor height
                 minHeight: null, // set minimum height of editor
                 maxHeight: null, // set maximum height of editor
                 focus: true    // set focus to editable area after initializing summernote
             });
         });
     </script>

    <script>

        function removeNewImage(e) {
            $(e).closest('div.images').remove();
        }

        $('.add-image').on('click' , function () {
            var count = document.getElementsByClassName('news_product_create').length;
            var new_image = '<div class="row mr-2 news_product_create">\n' +
                '<div class="col-md-9 product_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }} - <span style="color: red;">(width:800 - height:533)</span></label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="image[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.Image") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-4">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeRenewImages(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';

            $('.images').append(new_image);
        });

        function removeRenewImages(e) {
            $(e).closest('div.news_product_create').remove();
        }

    </script>
@endsection
