@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}

    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}

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

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/team/addTeamTrans') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <input type="hidden" name="team_id" value="{{ $id }}">
                            @php($maxView = \App\Models\Team::select('view_index')->max('view_index'))
                            <input type="hidden" name="view_index" value="{{ $maxView }}">

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="col-md-12">
                                                <div class="form-group {{ $errors->has('team_name') ? 'has-error' : '' }}">
                                                    <label for="exampleInputEmail1">{{ trans_db('dashboard.team_name') }}</label>
                                                    {!! Form::text('team_name', old('team_name'), ['placeholder'=> trans_db('dashboard.team_name'),'class' => "form-control" ]) !!}
                                                    <span class="text-danger">{{ $errors->first('team_name') }}</span>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12">
                                                <div class="form-group {{ $errors->has('team_position') ? 'has-error' : '' }}">
                                                    <label for="exampleInputEmail1">{{ trans_db('dashboard.team_position') }}</label>
                                                    {!! Form::text('team_position', old('team_position'), ['placeholder'=> trans_db('dashboard.team_position'),'class' => "form-control" ]) !!}
                                                    <span class="text-danger">{{ $errors->first('team_position') }}</span>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="col-lg-12">
                                                <div class="form-group {{ $errors->has('member_type') ? 'has-error' : '' }}">
                                                    <label for="">{{ trans_db('dashboard.member_type') }}</label>
                                                    <select name="member_type" class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        <option value="1">{{ trans_db('dashboard.manager') }}</option>
                                                        <option value="2">{{ trans_db('dashboard.employer') }}</option>
                                                    </select>
                                                    <span class="text-danger">{{ $errors->first('member_type') }}</span>
                                                </div>
                                            </div> --}}

                                            {{-- <div class="col-md-12">
                                                <h2>{{ trans_db('dashboard.Images') }}</h2>
                                                <div class="row">
                                                    <div class="col-md-9 car_image">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">({{ trans_db('dashboard.width') }}:800 - {{ trans_db('dashboard.height') }}:533)</span></label>
                                                            <input type="file" id="exampleInputFile" name="image[]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row images"></div>
                                            </div> --}}
                                        </div>
                                        @if ($Details->member_type == '1')
                                            <div class="col-lg-6">
                                                <div class="col-md-12 manager_only">
                                                    <div class="form-group {{ $errors->has('team_description') ? 'has-error' : '' }}">
                                                        <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
                                                        <label for="exampleInputEmail1">{{ trans_db('dashboard.team_description') }}</label>
                                                        {!! Form::textarea('team_description', old('team_description'), ['placeholder'=> trans_db('dashboard.team_description'),'class' => "form-control" ,'rows'=> 3 , 'id' => 'team_description' ]) !!}
                                                        <span class="text-danger">{{ $errors->first('team_description') }}</span>
                                                        <script>CKEDITOR.replace('team_description');</script>
                                                    </div>
                                                </div>
                                            </div>    
                                        @endif
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

    {!! Html::script('admin/plugins/select2/js/select2.full.min.js') !!}
@endsection
