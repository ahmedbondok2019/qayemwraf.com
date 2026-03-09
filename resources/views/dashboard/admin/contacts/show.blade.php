@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Contact Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Name') }}:</div>
                                    <div class="col-md-10">{{ $contact->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Email') }}:</div>
                                    <div class="col-md-10">{{ $contact->email }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Phone') }}:</div>
                                    <div class="col-md-10">{{ $contact->phone ?? '---' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Subject') }}:</div>
                                    <div class="col-md-10">{{ $contact->subject ?? '---' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Message') }}:</div>
                                    <div class="col-md-10">
                                        <div class="p-2 border rounded bg-light">
                                            {!! nl2br(e($contact->message)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 font-weight-bold">{{ trans_db('dashboard.Date') }}:</div>
                                    <div class="col-md-10">{{ $contact->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">{{ trans_db('dashboard.Back') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
