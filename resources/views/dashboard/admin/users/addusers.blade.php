@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> {{ trans_db('dashboard.accounts') }} </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 > {{ trans_db('dashboard.Newaccount') }} </h3>
                        </div>

                        @if (session('msg'))
                            <div class="card-body">
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('msg') }}
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/createUser') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="col-md-12">
                                <div class="card-body">
                                    <input type="hidden" name="id">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> {{ trans_db('dashboard.AccountName') }} </label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> {{ trans_db('dashboard.Email') }} </label>
                                                <input id="email" type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label> {{ trans_db('dashboard.Password') }} </label>
                                                <input class="form-control" type="password" value="" name="password">
                                            </div>
                                        </div>
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label> {{ trans_db('dashboard.PasswordConfirmation') }} </label>--}}
{{--                                                <input class="form-control" type="password" value="" name="password_confirmation">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- select -->
                                            <div class="form-group">
                                                <label> {{ trans_db('dashboard.AllPermission') }} </label>
                                                <select class="form-control" name="admin">
                                                    <option value="">  {{ trans_db('dashboard.AllGr') }} </option>
                                                    @php($permission_name = \App\Models\Group::all())
                                                    @foreach($permission_name as $all_per)
                                                        <option value="{{ $all_per->id }}"> {{ $all_per->name }}</option>
                                                    @endforeach
                                                </select>
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
@endsection
