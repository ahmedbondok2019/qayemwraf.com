@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
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

                                    <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/profit_group/update') }}" method="post" enctype="multipart/form-data" role="form">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $details->id }}">


                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                            <label class="form-label" for="basic-icon-default-name">{{ trans_db('dashboard.Title') }}</label>
                                                            <input type="text" id="basic-icon-default-name" class="form-control dt-uname" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="title" value="{{ $details->title }}"/>
                                                            @error('title') <span class="text-danger error">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                                                            <label class="form-label" for="basic-icon-default-value">{{ trans_db('dashboard.value') }}</label>
                                                            <input type="text" id="basic-icon-default-value" class="form-control dt-uname" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="value" value="{{ $details->value }}"/>
                                                            @error('value') <span class="text-danger error">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-lg-6">
                                                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                                            <label class="form-label">{{ trans_db('dashboard.status') }}</label>
                                                            <select class="form-control form-select-lg" name="type" id="select2-basic" wire:model="type">
                                                                <option value="1" {{ $details->type == 1 ? "selected" : "" }}>{{ trans_db("dashboard.percentage") }}</option>
                                                                <option value="2" {{ $details->type == 2 ? "selected" : "" }}>{{ trans_db("dashboard.fixed") }}</option>
                                                            </select>
                                                            @error('type') <span class="text-danger error">{{ $message }}</span> @enderror
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
