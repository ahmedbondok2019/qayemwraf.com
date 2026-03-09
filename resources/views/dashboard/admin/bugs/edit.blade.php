@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.Messages') }}</h2>
                    </div>
                </div>
            </div>
            body	
            notification
            <div class="content-body">
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
                
                <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        

                        <div class="card-content" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="hidden" name="id" value="{{ $log_apis->id }}">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label> {{ trans_db('dashboard.User') }} </label>
                                            <input type="text" class="form-control" value="{{ optional(\App\Models\User::find($log_apis->user_id))->name }}">
                                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                                            <label> {{ trans_db('dashboard.Url') }} </label>
                                            <input type="text" class="form-control" value="{{ $log_apis->url }}" disabled>
                                            <span class="text-danger">{{ $errors->first('url') }}</span>
                                        </div>
                                    </div>
    
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                            <label for="">{{ trans_db('dashboard.Status') }}</label>
                                            @if($log_apis->status == 0)
                                                <h3 class="btn btn-danger">{{ trans_db('dashboard.Waiting') }} </h3>
                                            @else
                                                <h3 class="btn btn-success">{{ trans_db('dashboard.Reviewed') }} </h3>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label> {{ trans_db('dashboard.Description') }} </label>
                                            <textarea id="exampleFormControlTextarea1" class="form-control" style="height: 200px;text-align: left;font-size: 22px;">{{ $log_apis->body }}</textarea>
                                        </div>
                                    </div>

                                    

                                    <hr>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label style="color: red;font-size: 20px;"> {{ trans_db('dashboard.Replay') }} </label>
                                            <textarea name="reply"  id="exampleFormControlTextarea1" row="2" class="form-control" >{{ $log_apis->reply }}</textarea>
                                            <input type="text" name="reply_user_id" value="{{ optional(\App\Models\Admin::find($log_apis->reply_user_id))->name }}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                   

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Send') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
