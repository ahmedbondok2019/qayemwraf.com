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

                            <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/team/update') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <input type="hidden" name="view_index" value="{{ $Details->TeamTranslation->view_index }}">
                            <input type="hidden" name="team_id" value="{{ $id }}">
                            <input type="hidden" name="manager_type" value="{{ $Details->TeamTranslation->member_type }}">


                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('team_name') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.team_name') }}</label>
                                                {!! Form::text('team_name',  $Details->TeamTranslation->team_name, ['placeholder'=> trans_db('dashboard.team_name'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('team_name') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('team_position') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.team_position') }}</label>
                                                {!! Form::text('team_position', $Details->TeamTranslation->team_position, ['placeholder'=> trans_db('dashboard.team_position'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('team_position') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('facebook_link') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.facebook_link') }}</label>
                                                {!! Form::text('facebook_link', $Details->facebook_link, ['placeholder'=> trans_db('dashboard.facebook_link'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('facebook_link') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('twitter_link') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.twitter_link') }}</label>
                                                {!! Form::text('twitter_link', $Details->twitter_link, ['placeholder'=> trans_db('dashboard.twitter_link'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('twitter_link') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('instagram_link') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.instagram_link') }}</label>
                                                {!! Form::text('instagram_link', $Details->instagram_link, ['placeholder'=> trans_db('dashboard.instagram_link'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('instagram_link') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('member_type') ? 'has-error' : '' }}">
                                                <label for="">{{ trans_db('dashboard.member_type') }}</label>
                                                <select name="member_type" class="form-control select2" style="width: 100%;">
                                                    <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                    <option value="1" {{ $Details->TeamTranslation->member_type == 1 ? "selected" : "" }}>{{ trans_db('dashboard.manager') }}</option>
                                                    <option value="2" {{ $Details->TeamTranslation->member_type == 2 ? "selected" : "" }}>{{ trans_db('dashboard.employer') }}</option>
                                                </select>
                                                <span class="text-danger">{{ $errors->first('member_type') }}</span>
                                            </div>
                                        </div>

                                            <div class="col-lg-12 manager_only">
                                                <div class="form-group {{ $errors->has('team_description') ? 'has-error' : '' }}">
                                                    <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
                                                    <label for="exampleInputEmail1">{{ trans_db('dashboard.team_description') }}</label>
                                                    {!! Form::textarea('team_description', $Details->TeamTranslation->team_description, ['placeholder'=> trans_db('dashboard.team_description'),'class' => "form-control" ,'rows'=> 3 , 'id' => 'team_description' ]) !!}
                                                    <span class="text-danger">{{ $errors->first('team_description') }}</span>
                                                    <script>CKEDITOR.replace('team_description');</script>
                                                </div>
                                            </div>

                                            <hr/>

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
                                                            <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">(width:270 - height:240)</span></label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="image[]">
                                                                <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }} </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="row">
                                            @foreach($Details->TeamImages as $image)
                                            <div class="col-lg-3 m-2">
                                                <a onclick="return confirm('<?php echo trans_db('dashboard.AreYouSureToDelete'); ?>')" href="{{ \LaravelLocalization::localizeUrl('admin-2023/teams/delete/image/' . $image->id) }}">
                                                    <i class="fa fa-trash danger" aria-hidden="true"></i>
                                                    <img src="{{ asset('website/images/teams/' . $image->image) }}" alt="">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')

    @include('dashboard.admin.layouts.script')

    {{-- {!! Html::script('admin/plugins/select2/js/select2.full.min.js') !!} --}}


    <script>
        // $(function () {
        //     //Initialize Select2 Elements
        //     $('.select2').select2()
        // });

    </script>
    
    <script>

        $(document).ready(function () {
            var member_type = $('input[name=manager_type]').val();
            if (member_type == 1){
                $('.manager_only').show();
            }else{
                $('.manager_only').hide();  
            }
        });

        $('select[name=member_type]').on('change' , function () {
            if ($(this).val() == 1){
                $('.manager_only').show();
            }else{
                $('.manager_only').hide();  
            }
        });

    </script>

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
                    aspectRatio: 0.89,
                    viewMode: 1,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:270,
                    height:240
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
                            url:'{{ \LaravelLocalization::localizeUrl('admin-2023/team/cropTeam') }}',
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
