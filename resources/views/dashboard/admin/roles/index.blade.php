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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Roles Management') }}</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">{{ trans_db('dashboard.Add New Role') }}</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans_db('dashboard.Name') }}</th>
                                            <th>{{ trans_db('dashboard.Permissions Count') }}</th>
                                            <th>{{ trans_db('dashboard.Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td><span class="badge badge-light-primary">{{ $role->permissions_count ?? $role->permissions->count() }}</span></td>
                                            <td>
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                @if($role->id != 1)
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                                        <i data-feather="trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
