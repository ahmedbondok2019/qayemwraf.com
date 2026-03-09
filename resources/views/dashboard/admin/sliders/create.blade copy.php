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
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/sliders/createSlider') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Title') }}</label>
                                                    <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.Title') }}" value="" name="title" id="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Link') }}</label>
                                                    <input type="text" class="form-control" placeholder="https://www.example.com" value="" name="link" id="email" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.slug') }}</label>
                                                    <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.slug') }}" value="" name="slug"/>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">{{ trans_db('dashboard.Location') }}</label>
                                                    <select class="form-control" id="location" name="location">
                                                        <option value="1">{{ trans_db('dashboard.Top') }}</option>
                                                        <option value="2">{{ trans_db('dashboard.Bottom') }}</option>
                                                    </select>
                                                </div>
                                            </div> --}}

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
    
                                            <div class="col-lg-12">
                                                <div class="row p-2 border rounded m-2 bg-light">
                                                
                                                    <div class="col-lg-8">
                                                        <input type="hidden" name="cropped_image" id="cropped_image">
                                                        <img src="" alt="" id="uploaded_image" style="max-width: -webkit-fill-available;">
                                                    </div>
        
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">(width:1920 - height:970)</span></label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                                                <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }} </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4 slider_image">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.Image') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                                                <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 images"></div>
                                                </div>
                                            </div> --}}


                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">
                                                    {{ trans_db('dashboard.Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
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
                    $modal.modal({backdrop: 'static', keyboard: false}, 'show');p: 'static', keyboard: false}, 'show');p: 'static', keyboard: false}, 'show');
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
                    aspectRatio: 1.98,
                    viewMode: 1,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:1920,
                    height:970
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
                            url:'{{ \LaravelLocalization::localizeUrl('cropSlider') }}',
                            method:'POST',
                            data:{image:base64data,width:'1920',height:'970'},
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

    <script>
        function removeNewImage(e) {
            $(e).closest('div.images').remove();
        }

        $('.add-image').on('click' , function () {
            var count = document.getElementsByClassName('news_slider_create').length;
            var new_image = '<div class="row news_slider_create">\n' +
                '<div class="col-md-6 slider_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }}</label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="image[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.Image") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-4">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeRenewImages(this)"><i class="fa fa-remove"></i> <?php echo trans_db('dashboard.delete'); ?>  </a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';

            $('.images').append(new_image);
        });

        function removeRenewImages(e) {
            $(e).closest('div.news_slider_create').remove();
        }
    </script>
@endsection
