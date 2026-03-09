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
                            <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/privacy/update') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-12">
                                    <div class="card-header">
                                        <h4>{{ trans_db('dashboard.privacy') }}</h4>
                                    </div>
                                    <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
                                                    <label>{{ trans_db('dashboard.Description') }}<span>(*)</span>:</label>
                                                    <textarea rows="8" class="form-control" placeholder="{{ trans_db('dashboard.description') }}" id="privacy" name="privacy">{{ $Setting->privacy }}</textarea>
                                                    <script>CKEDITOR.replace('privacy');</script>
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
@endsection
