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
                                    <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/reviews/update') }}" method="post" enctype="multipart/form-data" role="form">
                                        @csrf

                                        {{-- <input type="hidden" name="view_index" value="{{ $Details->ReviewTranslation->view_index }}"> --}}
                                        <input type="hidden" name="review_id" value="{{ $id }}">
                                        <input type="hidden" name="id" value="{{ $Details->ReviewTranslation->id }}">

                                        <div class="col-md-12">
                                            <div class="card-body"style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                            <label for="exampleInputEmail1">{{ trans_db('dashboard.Review_Name') }}</label>
                                                            {!! Form::text('title', $Details->ReviewTranslation->title , ['placeholder'=> trans_db('dashboard.Review_Name'),'class' => "form-control" ]) !!}
                                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group {{ $errors->has('youtube_link') ? 'has-error' : '' }}">
                                                            <label for="exampleInputEmail1">{{ trans_db('dashboard.youtube_link') }}</label>
                                                            {!! Form::text('youtube_link', $Details->ReviewTranslation->youtube_link, ['placeholder'=> trans_db('dashboard.youtube_link'),'class' => "form-control" ]) !!}
                                                            <span class="text-danger">{{ $errors->first('youtube_link') }}</span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                            <label for="exampleInputEmail1">{{ trans_db('dashboard.slug') }}</label>
                                                            {!! Form::text('slug', $Details->ReviewTranslation->slug, ['placeholder'=> trans_db('dashboard.slug'),'class' => "form-control" ]) !!}
                                                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                                                        </div>
                                                    </div> --}}

                                                    {{-- <div class="col-lg-4">
                                                        <label for="textarea">{{ trans_db('dashboard.meta_title') }}</label>
                                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="meta_title">{{ $Details->ReviewTranslation->meta_title }}</textarea>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="textarea">{{ trans_db('dashboard.meta_description') }}</label>
                                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="meta_description">{{ $Details->ReviewTranslation->meta_description }}</textarea>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="textarea">{{ trans_db('dashboard.meta_keywords') }}</label>
                                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="meta_keywords">{{ $Details->ReviewTranslation->meta_keywords }}</textarea>
                                                    </div> --}}

                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label> {{ trans_db('dashboard.Description') }}</label>
                                                            <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
                                                            <textarea class="form-control" id="description" name="description" >{{ $Details->ReviewTranslation->description }}</textarea>
                                                            <script>CKEDITOR.replace('description');</script>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <img src="{{ asset('website/images/Review') }}/{{ $Details->ReviewTranslation->image }}" alt="" style="height: 140px;width:140px;">
                                                    </div>

                                                    {{-- <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="direction: ltr !important;">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Crop Image Before Upload</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="img-container">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <img src="" id="sample_image" />
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="preview"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                    <div class="row p-2 border rounded m-2 bg-light">
                                                    
                                                        <div class="col-lg-4">
                                                            <input type="hidden" name="cropped_image" id="cropped_image">
                                                            <img src="" alt="" id="uploaded_image">
                                                        </div>
                
                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">(width:70 - height:70)</span></label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" name="image">
                                                                    <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }} </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">{{ trans_db('dashboard.video_file') }}</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="customFile12" name="video">
                                                                        <label class="custom-file-label" for="customFile12" style="padding-right: 83px;">{{ trans_db('dashboard.video_file') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if (isset($Details->ReviewTranslation->video) && $Details->ReviewTranslation->video != null)
                                                        <div class="col-lg-4">
                                                            <video controls width="300">
                                                                <source src="{{ asset('website/uploads/videos/reviews/' . $Details->ReviewTranslation->video) }}" type="video/mp4" style="width: 150px; height: 150px">
                                                            </video>
                                                        </div>      
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </section>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
        </div>
            <!-- /.content -->
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
                            aspectRatio: 1,
                            viewMode: 1,
                            preview:'.preview'
                        });
                    }).on('hidden.bs.modal', function(){
                        cropper.destroy();
                        cropper = null;
                    });
        
                    $('#crop').click(function(){
                        canvas = cropper.getCroppedCanvas({
                            width:70,
                            height:70
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
                                    url:'{{ \LaravelLocalization::localizeUrl('admin-2023/reviews/cropReview') }}',
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
        