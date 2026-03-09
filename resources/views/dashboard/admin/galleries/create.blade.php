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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/gallery/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            @php($maxView = \App\Models\Gallery::select('view_index')->max('view_index'))
                            <input type="hidden" name="view_index" value="{{ $maxView }}">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('gallery_name') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.GalleryName') }}</label>
                                                {!! Form::text('gallery_name', old('gallery_name'), ['placeholder'=> trans_db('dashboard.GalleryName'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('gallery_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('gallery_location') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.GalleryLocation') }}</label>
                                                {!! Form::text('gallery_location', old('gallery_location'), ['placeholder'=> trans_db('dashboard.GalleryLocation'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('gallery_location') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('gallery_date') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.GalleryDate') }}</label>
                                                {!! Form::text('gallery_date', old('gallery_date'), ['placeholder'=> trans_db('dashboard.GalleryDate'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('gallery_date') }}</span>
                                            </div>
                                        </div>

                                    </div>

                                    <hr/>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row m-2">
                                                    <div class="col-md-12 gallery_image">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.Image') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="image[]">
                                                                <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row images"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <a class="btn btn-success add-image">{{ trans_db('dashboard.new_image') }} </a>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="row m-2">
                                                    <div class="col-md-12 gallery_image">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.video_file') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="video[]">
                                                                <label class="custom-file-label" for="customFile">{{ trans_db('dashboard.video_file') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row videos"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <a class="btn btn-success add-video">{{ trans_db('dashboard.new_video') }} </a>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                        
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row m-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">{{ trans_db('dashboard.links') }}</label>
                                                                <input type="text" class="form-control" name="link[]" placeholder="{{ trans_db('dashboard.links') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row links"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <a class="btn btn-success add-link">{{ trans_db('dashboard.new_link') }} </a>
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

    {!! Html::script('admin/plugins/select2/js/select2.full.min.js') !!}


    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });

    </script>

    <script>

function removeNewImage(e) {
            $(e).closest('div.images').remove();
        }

        $('.add-image').on('click' , function () {
            var count = document.getElementsByClassName('news_gallery_create').length;
            var new_image = '<div class="row ml-2 news_gallery_create">\n' +
                '<div class="col-md-9 gallery_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }} - <span style="color: red;">(width:800 - height:533)</span></label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="image[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.Image") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-2">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeRenewImages(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';

            $('.images').append(new_image);
        });

        function removeRenewImages(e) {
            $(e).closest('div.news_gallery_create').remove();
        }

    </script>

    <script>

        function removeNewVideo(e) {
            $(e).closest('div.videos').remove();
        }

        $('.add-video').on('click' , function () {
            var count = document.getElementsByClassName('news_galleries_video').length;
            var new_video = '<div class="row ml-2 news_galleries_video">\n' +
                '<div class="col-md-9 gallery_video">\n' +
                '<label>{{ trans_db("dashboard.video_file") }} - <span style="color: red;">(width:800 - height:533)</span></label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="video[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.video_file") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-2">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeVideogalleries(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>';

            $('.videos').append(new_video);
        });

        function removeVideogalleries(e) {
            $(e).closest('div.news_galleries_video').remove();
        }

    </script>

<script>

    function removeNewLink(e) {
        $(e).closest('div.links').remove();
    }

    $('.add-link').on('click' , function () {
        var count = document.getElementsByClassName('news_galleries_link').length;
        var new_link = '<div class="row ml-2 news_galleries_link">\n' +
            '<div class="col-md-9 gallery_link">\n' +
            '<label for="">{{ trans_db("dashboard.links") }}</label>\n' +
            '<input type="text" class="form-control" name="link[]" placeholder="{{ trans_db("dashboard.links") }}">\n' +
            '</div>\n' +
            '<div class="col-md-3 pt-2">\n' +
            '<div class="form-group">\n' +
            '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeLinkgalleries(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
            '</div>\n' +
            '</div>\n' +
            '</div>';

        $('.links').append(new_link);
    });

    function removeLinkgalleries(e) {
        $(e).closest('div.news_galleries_link').remove();
    }

</script>
@endsection
