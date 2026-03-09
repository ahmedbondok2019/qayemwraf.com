@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>

    <style>

        .image_area {
            position: relative;
        }

        .modal img {
            display: block;
            max-width: 50%;
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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/brands/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.title') }}</label>
                                                {!! Form::text('title', old('title'), ['placeholder'=> trans_db('dashboard.title'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">(width:300 - height:300)</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="image">
                                                    <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }} </label>
                                                    @error('image') <span class="text-danger error">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <input type="hidden" name="cropped_image" id="cropped_image">
                                            <img src="" alt="" id="uploaded_image">
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


                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>
                                    <!-- users edit account form ends -->
                                </div>
                                <!-- Account Tab ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

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
                    aspectRatio: 1,
                    viewMode: .75,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:300,
                    height:300
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
                            url:'{{ \LaravelLocalization::localizeUrl("admin-2023/brands/cropBrand") }}',
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
@endsection
