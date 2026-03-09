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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/faqs/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            @php($maxView = \App\Models\Faq::select('view_index')->max('view_index'))
                            <input type="hidden" name="view_index" value="{{ $maxView }}">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.FaqName') }}</label>
                                                {!! Form::text('title', old('title'), ['placeholder'=> trans_db('dashboard.FaqName'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 manager_only">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.Description') }}</label>
                                                {!! Form::textarea('description', old('description'), ['placeholder'=> trans_db('dashboard.Description'),'class' => "form-control" ,'rows'=> 3 , 'id' => 'description' ]) !!}
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                                <script>CKEDITOR.replace('description');</script>
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
