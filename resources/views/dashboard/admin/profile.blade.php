@extends('dashboard.admin.layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-fluid p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.Profile Settings') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Profile Settings') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class=" col-12 mx-auto">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">{{ trans_db('dashboard.Admin Profile') }}</h4>
                        </div>
                        <div class="card-body pt-2">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <div class="alert-body">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            <form class="form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xl bg-light-primary me-2">
                                                <div class="avatar-content" style="width: 80px; height: 80px; font-size: 2rem;">
                                                    {{ substr($admin->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="mb-0">{{ $admin->name }}</h4>
                                                <p class="text-muted mb-0">{{ $admin->email }}</p>
                                                <span class="badge rounded-pill badge-light-info mt-50">
                                                    {{ $admin->group->name ?? 'Administrator' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label font-weight-bold">{{ trans_db('dashboard.Name') }}</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label font-weight-bold">{{ trans_db('dashboard.Email') }}</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 mt-1 mb-1">
                                        <hr>
                                        <h5 class="mb-1">{{ trans_db('dashboard.Update Password') }} <small class="text-muted">(Leave blank if not changing)</small></h5>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label font-weight-bold">{{ trans_db('dashboard.New Password') }}</label>
                                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label font-weight-bold">{{ trans_db('dashboard.Confirm Password') }}</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary me-1">
                                            <i data-feather="save" class="me-25"></i> {{ trans_db('dashboard.Save Changes') }}
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary">{{ trans_db('dashboard.Reset') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-weight-bold { font-weight: 700; }
</style>
@endsection
