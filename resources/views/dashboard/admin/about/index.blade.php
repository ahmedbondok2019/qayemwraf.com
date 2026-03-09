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
                            <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/about/update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ optional($about)->id }}">
                                <input type="hidden" name="about_id" value="{{ optional(optional($about)->AboutTranslation)->about_id }}">

                                <div class="col-md-12">
                                    <div class="card-header">
                                        <h4>{{ trans_db('dashboard.about') }}</h4>
                                    </div>
                                    <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ trans_db('dashboard.Title') }}<span>(*)</span>:</label>
                                                    {!! Form::text('slug', optional(optional($about)->AboutTranslation)->slug, ['placeholder'=> trans_db('dashboard.video_link'),'class' => "form-control" ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                                    <label for="exampleInputEmail3">{{ trans_db('dashboard.video_link_youtube') }}</label>
                                                    {!! Form::text('video_link', optional(optional($about)->AboutTranslation)->video_link, ['placeholder'=> trans_db('dashboard.video_link_youtube'),'class' => "form-control" ]) !!}
                                                    <span class="text-danger">{{ $errors->first('video_link') }}</span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ trans_db('dashboard.Description') }}<span>(*)</span>:</label>
                                                    <textarea rows="3" class="form-control tinymce-editor" placeholder="{{ trans_db('dashboard.description') }}" id="description" name="description">{{ optional(optional($about)->AboutTranslation)->description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ trans_db('dashboard.mission') }}<span>(*)</span>:</label>
                                                    <textarea rows="3" class="form-control tinymce-editor" placeholder="{{ trans_db('dashboard.mission') }}" name="mission">{{ optional(optional($about)->AboutTranslation)->mission }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ trans_db('dashboard.vision') }}<span>(*)</span>:</label>
                                                    <textarea rows="3" class="form-control tinymce-editor" placeholder="{{ trans_db('dashboard.vision') }}" name="vision">{{ optional(optional($about)->AboutTranslation)->vision }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ trans_db('dashboard.history') }}<span>(*)</span>:</label>
                                                    <textarea rows="3" class="form-control tinymce-editor" placeholder="{{ trans_db('dashboard.history') }}" name="history">{{ optional(optional($about)->AboutTranslation)->history }}</textarea>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="direction: ltr !important;">
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

                                            <div class="row p-2 border rounded m-2 bg-light" style="max-width: -webkit-fill-available;">
                                                <div class="col-lg-4">
                                                            <img src="{{ asset('website/images/about/' . optional(optional($about)->AboutTranslation)->image) }}" alt="" style="max-width: -webkit-fill-available">
                                                </div>
                                                <div class="col-lg-8">
                                                            <div class="col-lg-4">
                                                                <input type="hidden" name="cropped_image" id="cropped_image">
                                                                <img src="" alt="" id="uploaded_image">
                                                            </div>
                    
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">(width:1170 - height:453)</span></label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="customFile" name="image">
                                                                        <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }} </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                </div>
                                            </div>

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
                    aspectRatio: 2.58,
                    viewMode: 1,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:1170,
                    height:454
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
