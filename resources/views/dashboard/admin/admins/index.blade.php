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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Admins Management') }}</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">{{ trans_db('dashboard.Add New Admin') }}</a>
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
                                            <th>{{ trans_db('dashboard.Email') }}</th>
                                            <th>{{ trans_db('dashboard.Role') }}</th>
                                            <th>{{ trans_db('dashboard.Status') }}</th>
                                            <th>{{ trans_db('dashboard.Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td><span class="badge badge-light-info">{{ $admin->group->name ?? 'No Role' }}</span></td>
                                            <td>
                                                @if($admin->status)
                                                <span class="badge badge-light-success">{{ trans_db('dashboard.Active') }}</span>
                                                @else
                                                <span class="badge badge-light-danger">{{ trans_db('dashboard.Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                @if($admin->name != 'admin' && $admin->id != auth('admin')->id())
                                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" class="d-inline">
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
                                {{ $admins->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
