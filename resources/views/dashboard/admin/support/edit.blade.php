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

            <div class="content-body">
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
                
                <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/customer_messages/update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        

                        <div class="card-content" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" value="{{ $customer_messages->id }}">
                                        <div class="form-group {{ $errors->has('contact_name') ? 'has-error' : '' }}">
                                            <label> {{ trans_db('dashboard.User') }} </label>
                                            <input type="text" class="form-control" name="contact_name" value="{{ $customer_messages->contact_name }}" disabled>
                                            <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('contact_email') ? 'has-error' : '' }}">
                                            <label> {{ trans_db('dashboard.Email') }} </label>
                                            <input type="email" class="form-control" name="contact_email" value="{{ $customer_messages->contact_email }}" disabled>
                                            <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('contact_phone') ? 'has-error' : '' }}">
                                            <label> {{ trans_db('dashboard.Phone') }} </label>
                                            <input type="email" class="form-control" name="contact_phone" value="{{ $customer_messages->contact_phone }}" disabled>
                                            <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label> {{ trans_db('dashboard.MessageDescription') }} </label>
                                            <textarea name="message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" disabled>{{ $customer_messages->message }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                            <label for="">{{ trans_db('dashboard.Status') }}</label>
                                            @if($customer_messages->status == 0)
                                                <h3 class="btn btn-danger">{{ trans_db('dashboard.Waiting') }} </h3>
                                            @else
                                                <h3 class="btn btn-success">{{ trans_db('dashboard.Reviewed') }} </h3>
                                            @endif
                                        </div>
                                    </div>

                                    <hr>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label style="color: red;font-size: 20px;"> {{ trans_db('dashboard.Replay') }} </label>
                                    <textarea name="reply" class="mytextarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $customer_messages->reply }}</textarea>
                                    <input type="hidden" name="reply_user_id" value="{{ $customer_messages->reply_staff_id }}">
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
