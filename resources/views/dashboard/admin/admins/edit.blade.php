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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Edit Admin') }}: {{ $admin->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">{{ trans_db('dashboard.Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">{{ trans_db('dashboard.Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password">{{ trans_db('dashboard.Password') }} ({{ trans_db('dashboard.Leave blank to keep current') }})</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation">{{ trans_db('dashboard.Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="permission_group">{{ trans_db('dashboard.Role') }}</label>
                                <select name="permission_group" id="permission_group" class="form-control @error('permission_group') is-invalid @enderror" required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('permission_group', $admin->permission_group) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('permission_group') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">{{ trans_db('dashboard.Status') }}</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" {{ old('status', $admin->status) == '1' ? 'selected' : '' }}>{{ trans_db('dashboard.Active') }}</option>
                                    <option value="0" {{ old('status', $admin->status) == '0' ? 'selected' : '' }}>{{ trans_db('dashboard.Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
