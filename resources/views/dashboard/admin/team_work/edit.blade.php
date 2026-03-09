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

            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{ trans_db("dashboard.Edit team_work") }}</h2>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <a href="{{ \LaravelLocalization::localizeUrl('team_work/' . $details->id . '/' . \App\Http\Controllers\helper\helperController::make_slug($details->translations->title)) }}" class="btn btn-md btn-warning" target="_blank">
                                <i data-feather='eye'></i> {{ trans_db("dashboard.View team_work") }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                @php
                    $random_id = \Illuminate\Support\Str::random(80);
                @endphp

                <section id="dropzone-examples">
                    <!-- multi file upload starts -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.team_work Images') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/team_works/uploadImages') }}" method="post" enctype="multipart/form-data" class="dropzone dropzone-area" id="dpz-remove-thumb">
                                        <input type="hidden" name="random_id" value="{{ $details->id }}">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/team_work/updateTeamWork') }}" method="post" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.Name') }}" value="{{ $details->translations->title }}" name="title" id="title" />
                                        </div>
                                    </div>
            
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                            {!! Form::textarea('description', $details->translations->description, ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
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
                                            {!! Form::text('video_link', $details->translations->video_link , ['placeholder'=> 'https://www.youtube.com/watch?v=14semTlwyUY','class' => "form-control" ]) !!}
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
                                            {!! Form::textarea('posts', $details->translations->posts , ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
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
                                            {!! Form::textarea('sponsored', $details->translations->sponsored, ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('sponsored') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    
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
                                            {!! Form::textarea('report', $details->translations->report , ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
                                            <span class="text-danger">{{ $errors->first('report') }}</span>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    
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
                                            {!! Form::textarea('result', $details->translations->result , ['placeholder'=> trans_db('dashboard.description'),'class' => "form-control summernote" ,'rows'=> 3 ]) !!}
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
             $('#summernote').summernote({
                 height: 300,   // set editor height
                 minHeight: null, // set minimum height of editor
                 maxHeight: null, // set maximum height of editor
                 //focus: true    // set focus to editable area after initializing summernote
             });
         });
     </script>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script> --}}
    <script>
        // var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone(".dropzone",{ 
            maxFilesize: 2, // 2 mb
            // acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            // dictRemoveFile: ' Trash',
            // uploadMultiple: true,
            init: function() { 
                myDropzone = this;

                $.ajax({
                    url: '{{ route("admin.readFiles") }}',
                    type: 'get',
                    data:{id:"{{ $details->id }}"},
                    dataType: 'json',
                    success: function(response){

                        $.each(response, function(key,value) {
                            var mockFile = { id: value.id, name: value.name, size: value.size };

                            // myDropzone.emit("addedfile", mockFile);
                            // myDropzone.emit("thumbnail", mockFile, value.path);
                            // myDropzone.emit("complete", mockFile);
                            myDropzone.displayExistingFile(mockFile, value.path);
                        });
                    }
                });
            },
            removedfile: function(file) {
                var id = "";
                var file_name = "";

                console.log(file);
                console.log(file.processing);
                // console.log(file['id']);
                // x = confirm('Do you want to delete?');
                // if(x === false)  return false;

                if (file['id'] != null) {
                    id = file['id']; 
                }
                
                if (file.processing != undefined || file.processing != "undefined") {
                    file_name = file.name;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ \LaravelLocalization::localizeUrl('admin-2023/team_works/delete_image') }}",
                    data:{id:id,file_name:file_name,random_id:$("input[name=random_id]").val()},
                    type: 'post',
                    success: function(result){
                        if (result.status === true) {
                            console.log(file);
                            console.log(result.status);
                            // alert('deleted Successfully');
                        }
                    },
                    fail:function(xhr, status, error) {
                        // console.error();
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response){
                console.log(response);
            }
        });

        $('#dropzone').sortable({
            items: '.dz-image-preview',
            cancel: '.dz-image-preview:first-child',
            placeholder: 'sortable-placeholder',
            tolerance: 'pointer',
            start: function(event, ui) {

                // nitial placeholder setup to match the dragged item's size
                ui.placeholder.width(ui.item.width()).height(ui.item.height());
            },
            change: function(event, ui) {
                var isPlaceholderFirst = ui.placeholder.index() === 0;

                // show the first cover image's placeholder if dragged into it
                if (isPlaceholderFirst) {
                    ui.placeholder.addClass('cover-placeholder');
                } else {
                    ui.placeholder.removeClass('cover-placeholder');
                }
            },
            stop: function() {

                // update the files array based on new order
                const files = myDropzone.files;
                const sortedFiles = [];

                $('.dz-image-preview').each(function() {

                    // find the file unique data-id
                    const fileId = $(this).data('id');
                    const file = myDropzone.files.find(file => file.tempId === fileId);

                    // if file found, push to order array
                    if (file) {
                        sortedFiles.push(file);
                    }
                });

                myDropzone.files = sortedFiles;
            }
        });
    </script>

    <script>

        $(document).ready(function(){
            feather.replace();
            $("input[type=number]").TouchSpin({
                min: -999999.99,
                max: 999999.99
            });
            // $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            
            // $.ajax({
            //     type: "get",
            //     url: "{{ env('APP_URL') . 'api/app-2023/team_work_categories' }}",
            //     data:{id:"{{ $details->team_work_categories }}"},
            //     success:function(data) {

            //         $('#selected_team_work_categories').select2().val(data.results).trigger("change");
            //     },
            //     fail:function(xhr, status, error) {}
            // })
        });

        // $("input[type=number]").on('change' ,function() {
        //     $("input[type=number]").TouchSpin({
        //         min: -999999.99,
        //         max: 999999.99
        //     });
        //     alert($(this).val());return;
        // });

        $('#large-select-multi').select2({
            ajax: {
                url: "{{ env('APP_URL') . 'api/app-2023/options' }}",
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    
                    feather.replace();
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }
        });

        $('#selected_related_team_works').select2({
            ajax: {
                url: "{{ env('APP_URL') . 'api/app-2023/related_team_works' }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    
                    feather.replace();
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }
        });

        $('#mySelect2').find(':selected');
        $('#mySelect2').find(':selected').data('custom-attribute');

        ////////////////////// team_work category ///////////////////

        $('#selected_team_work_categories').select2({
            ajax: {
                url: "{{ env('APP_URL') . 'api/app-2023/team_work_categories' }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    feather.replace();
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }
        });

        $('#selected_team_work_categories').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
            var old_value = $("input[name=team_work_categories]").val();
            var new_value = $(this).val();
            $("input[name=team_work_categories]").val(old_value + ',' + new_value);
            $(this).trigger('change');
        });
        
        $('#selected_team_work_categories').on('select2:unselect', function (e) {
            $("input[name=team_work_categories]").val($(this).val());
            $(this).trigger('change');
        });

        ////////////////////// team_work category ///////////////////

        ////////////////////// related team_works ///////////////////

        $('#selected_related_team_works').on('select2:unselect', function (e) {
            $("input[name=related_team_works]").val($(this).val());
            $(this).trigger('change');
        });

        $('#selected_related_team_works').on('select2:select', function (e) {
            var old_value = $("input[name=related_team_works]").val();
            var new_value = $(this).val();
            $("input[name=related_team_works]").val(old_value + ',' + new_value);
            $(this).trigger('change');
        });

        $('#large-select-multi').on('select2:unselect', function (e) {
            $(this).trigger('change');
        });
        
        ////////////////////// related team_works ///////////////////

        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function (idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }
        
        $('#large-select-multi').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data.id);

            var old_value = $("input[name=team_work_options]").val();
            var new_value = $(this).val();
            $("input[name=team_work_options]").val(old_value + ',' + new_value);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'post',
                url:"{{ \LaravelLocalization::localizeUrl('admin-2023/team_works/getteam_workOptionItems') }}",
                data:{id:data.id},
                success:function(data) {
                    $(".option-items").append(data.data);
                    feather.replace();
                    $("input[type=number]").TouchSpin({
                        min: -999999.99,
                        max: 999999.99
                    });
                },
                fail:function(xhr, status, error) {}
            });
        });

        function removeOption(e, id) {
            $(e).closest('div.team_work_option').remove();
            var selectedOption = [];
            $('.option_id').each(function(){
                selectedOption.push($(this).val());
            });

            $('#large-select-multi').val(selectedOption).trigger('change');
            $("input[name=team_work_options]").val(selectedOption);
            console.log(selectedOption);
        }

        function removeItem(e) {
            $(e).closest('tr').remove();
        }
        
    </script>
    
    <script>

        function removeNewImage(e) {
            $(e).closest('div.images').remove();
        }

        $('.add-image').on('click' , function () {
            var count = document.getElementsByClassName('news_team_work_create').length;
            var new_image = '<div class="row ml-2 news_team_work_create">\n' +
                '<div class="col-md-9 team_work_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }} - <span style="color: red;">(width:1000 - height:1000)</span></label>\n' +
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
            $(e).closest('div.news_team_work_create').remove();
        }
    </script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 32,
                    height: 32
                });
            }

            $("input[type=number]").TouchSpin({
                min: -999999.99,
                max: 999999.99
            });
        })
    </script>

@endsection
