@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('dashboard.admin.component.page_error' , ['errors' => $errors])
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/UpdatePermission') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$PermissionGroupsDetails->id}}">

                                        @php
                                            $user_pers =\App\Models\GroupPermission::where('group_id',\Illuminate\Support\Facades\Auth::user()->permission_group)->pluck('permission_id');
                                            $permissionss = \App\Models\Permission::whereIn('id', $user_pers)->where('status', 1)->get();
                                            $groups = $permissionss->groupBy('parent_permission');
                                
                                            $permissions = array();
                                            $permissionNames = array();
                                            $permissionNamess = array();
                                        @endphp

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive border rounded mt-1">
                                                    <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                        <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                        <span class="align-middle">{{ trans_db('dashboard.Edit Permission Group') }}</span>
                                                    </h6>

                                                    <hr>

                                                    <div class="col-sm-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label> {{ trans_db('dashboard.AllGrName') }} </label>
                                                            <input type="text" class="form-control" name="name" value="{{ $PermissionGroupsDetails->name }}">
                                                        </div>
                                                    </div>

                                                    <br/>
                                                    
                                                    <?php $group_array = array(); ?>
                                                    @foreach($PermissionGroupsDetails->permission as $per)
                                                        <?php
                                                        if (isset($per)){
                                                            $permission = \App\Models\Permission::where('id', $per->permission_id)->pluck('id');
                                                            if (isset($permission[0])){
                                                                $group_array[] = $permission[0];
                                                            }
                                                        }
                                                        ?>
                                                    @endforeach


                                                    <table class="table table-striped table-borderless">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>{{ trans_db('dashboard.Module') }}</th>
                                                            <th>{{ trans_db('dashboard.Read') }}</th>
                                                            <th>{{ trans_db('dashboard.Write') }}</th>
                                                            <th>{{ trans_db('dashboard.Create') }}</th>
                                                            <th>{{ trans_db('dashboard.Delete') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($groups as $key => $group)
                                                            <tr>
                                                                <td>{{ trans_db('dashboard.' . $key) }}</td>
                                                                @foreach($group as $i => $items)
                                                                    @php
                                                                        $permissions[] = $items['name'];
                                                                        if(str_contains($items['name'] , '_read')){ $fullNames = str_replace('_read', '', $items['name']); $type = "read"; }
                                                                        if(str_contains($items['name'] , '_create')){ $fullNames = str_replace('_create', '', $items['name']); $type = "create"; }
                                                                        if(str_contains($items['name'] , '_update')){ $fullNames = str_replace('_update', '', $items['name']); $type = "update"; }
                                                                        if(str_contains($items['name'] , '_delete')){ $fullNames = str_replace('_delete', '', $items['name']); $type = "delete"; }
                                                                    @endphp

                                                                    {{-- @if (!in_array($fullNames , $permissionNames)) --}}
                                                                        @php
                                                                            $permissionNames[] = $fullNames;
                                                                        @endphp
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="admin-{{ $type }}{{ $items['id'] }}" name="permission_role[]" value="{{ $items['id'] }}" @if(in_array($items['id'], $group_array)) checked @endif/>
                                                                                <label class="custom-control-label" for="admin-{{ $type }}{{ $items['id'] }}"></label>
                                                                            </div>
                                                                        </td>
                                                                    {{-- @endif --}}
                                                                    
                                                                @endforeach
                                                            </tr>
                                                           @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">{{ trans_db('dashboard.Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
