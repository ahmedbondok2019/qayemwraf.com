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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Edit Role') }}: {{ $role->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ trans_db('dashboard.Role Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <hr>
                                <h4>{{ trans_db('dashboard.Permissions') }}</h4>
                                
                                <div class="row mt-2">
                                    <div class="col-12 mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label" for="checkAll"><strong>{{ trans_db('dashboard.Select All') }}</strong></label>
                                        </div>
                                    </div>
                                    @foreach($permissions as $group => $items)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border shadow-none">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">{{ trans_db('dashboard.' . $group) }}</h5>
                                            </div>
                                            <div class="card-body pt-1">
                                                @foreach($items as $permission)
                                                <div class="custom-control custom-checkbox mb-1">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                           class="custom-control-input permission-checkbox" id="perm_{{ $permission->id }}">
                                                    <label class="custom-control-label" for="perm_{{ $permission->id }}">{{ str_replace(['_read', '_create', '_update', '_delete'], [trans_db('dashboard.read'), trans_db('dashboard.create'), trans_db('dashboard.update'), trans_db('dashboard.delete')], $permission->name) }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-3 text-right">
                                    <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#checkAll').click(function(){
        $('.permission-checkbox').prop('checked', this.checked);
    });
</script>
@endsection
