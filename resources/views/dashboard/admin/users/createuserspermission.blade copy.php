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
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/StorePermission') }}" method="post">
                                        @csrf

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
                                                            <input type="text" class="form-control" name="name" value="">
                                                        </div>
                                                    </div>

                                                    <br/>

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
                                                            
                                                            @php
                                                                $permissionName = array();
                                                                
                                                                $permissions = \App\Models\Permission::get()->toArray();
                                                                $PermissionRow = array_chunk($permissions, 4);
                                                                $count_arrays=count($PermissionRow);
                                                            @endphp
                                                            
                                                            @for ($i=0; $i < $count_arrays; $i++)
                                                                @php
                                                                    $fullName = explode('_', $PermissionRow[$i][0]['name']);
                                                                    $permissionName[] = $fullName[0];

                                                                    $first = explode('_', $PermissionRow[$i][1]['name']);
                                                                    $second = explode('_', $PermissionRow[$i][2]['name']);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ trans_db('dashboard.' . $fullName[0]) }}</td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="admin-read{{ $PermissionRow[$i][0]['id'] }}" name="permission_role[]" value="{{ $PermissionRow[$i][0]['id'] }}"/>
                                                                            <label class="custom-control-label" for="admin-read{{ $PermissionRow[$i][0]['id'] }}"></label>
                                                                        </div>
                                                                    </td>
                                                                    @if ($first[1] != $second[1])
                                                                        @if (isset($PermissionRow[$i][1]['id']))
                                                                            <td>
                                                                                <div class="custom-control custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="admin-write{{ $PermissionRow[$i][1]['id'] }}" name="permission_role[]" value="{{ $PermissionRow[$i][1]['id'] }}"/>
                                                                                    <label class="custom-control-label" for="admin-write{{ $PermissionRow[$i][1]['id'] }}"></label>
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                        @if (isset($PermissionRow[$i][2]['id']))
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="admin-create{{ $PermissionRow[$i][2]['id'] }}" name="permission_role[]" value="{{ $PermissionRow[$i][2]['id'] }}"/>
                                                                                <label class="custom-control-label" for="admin-create{{ $PermissionRow[$i][2]['id'] }}"></label>
                                                                            </div>
                                                                        </td>
                                                                        @endif
                                                                        @if (isset($PermissionRow[$i][3]['id']))
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="admin-delete{{ $PermissionRow[$i][3]['id'] }}" name="permission_role[]" value="{{ $PermissionRow[$i][3]['id'] }}"/>
                                                                                <label class="custom-control-label" for="admin-delete{{ $PermissionRow[$i][3]['id'] }}"></label>
                                                                            </div>
                                                                        </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                            @endfor

                                    
                                                            {{-- <tr>
                                                            <td>{{ trans_db('dashboard.accounts') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="admin-read" name="permission_role[]" value="11"/>
                                                                    <label class="custom-control-label" for="admin-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="admin-write" name="permission_role[]" value="13"/>
                                                                    <label class="custom-control-label" for="admin-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="admin-create" name="permission_role[]" value="10"/>
                                                                    <label class="custom-control-label" for="admin-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="admin-delete" name="permission_role[]" value="12"/>
                                                                    <label class="custom-control-label" for="admin-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr> --}}
                                                            {{-- <tr>
                                                            <td>{{ trans_db('dashboard.Permission') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="staff-read" name="permission_role[]" value="15" />
                                                                    <label class="custom-control-label" for="staff-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="staff-write" name="permission_role[]" value="17" />
                                                                    <label class="custom-control-label" for="staff-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="staff-create" name="permission_role[]" value="14" />
                                                                    <label class="custom-control-label" for="staff-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="staff-delete" name="permission_role[]" value="16" />
                                                                    <label class="custom-control-label" for="staff-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr> --}}
                                                            {{-- <tr>
                                                            <td>{{ trans_db('dashboard.sliders') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="author-read" checked name="permission_role[]" value="29" />
                                                                    <label class="custom-control-label" for="author-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="author-write" name="permission_role[]" value="31" />
                                                                    <label class="custom-control-label" for="author-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="author-create" checked name="permission_role[]" value="28" />
                                                                    <label class="custom-control-label" for="author-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="author-delete" name="permission_role[]" value="30" />
                                                                    <label class="custom-control-label" for="author-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr> --}}
                                                            {{-- <tr>
                                                            <td>{{ trans_db('dashboard.Products') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="contributor-read" name="permission_role[]" value="21" />
                                                                    <label class="custom-control-label" for="contributor-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="contributor-write" name="permission_role[]" value="23" />
                                                                    <label class="custom-control-label" for="contributor-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="contributor-delete" name="permission_role[]" value="22" />
                                                                    <label class="custom-control-label" for="contributor-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.balance') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Doctors-read" name="permission_role[]" value="25" />
                                                                    <label class="custom-control-label" for="Doctors-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Doctors-write" name="permission_role[]" value="27" />
                                                                    <label class="custom-control-label" for="Doctors-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Doctors-create" name="permission_role[]" value="24" />
                                                                    <label class="custom-control-label" for="Doctors-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Doctors-delete" name="permission_role[]" value="26" />
                                                                    <label class="custom-control-label" for="Doctors-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.Category') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Specialist-read" name="permission_role[]" value="41"/>
                                                                    <label class="custom-control-label" for="Specialist-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Specialist-write" name="permission_role[]" value="43"/>
                                                                    <label class="custom-control-label" for="Specialist-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Specialist-create" name="permission_role[]" value="40"/>
                                                                    <label class="custom-control-label" for="Specialist-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Specialist-delete" name="permission_role[]" value="42"/>
                                                                    <label class="custom-control-label" for="Specialist-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.Setting') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Settings-read" name="permission_role[]" value="7"/>
                                                                    <label class="custom-control-label" for="Settings-read"></label>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.languages') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="languages-read" name="permission_role[]" value="48"/>
                                                                    <label class="custom-control-label" for="languages-read"></label>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.reports') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Reports-read" name="permission_role[]" value="8"/>
                                                                    <label class="custom-control-label" for="Reports-read"></label>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                            <td>{{ trans_db('dashboard.Support') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Support-read" name="permission_role[]" value="6"/>
                                                                    <label class="custom-control-label" for="Support-read"></label>
                                                                </div>
                                                            </td>
                                                            </tr> --}}
                                                            {{-- <tr>
                                                            <td>{{ trans_db('dashboard.Page') }}</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Coupons-read" name="permission_role[]" value="53"/>
                                                                    <label class="custom-control-label" for="Coupons-read"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Coupons-write" name="permission_role[]" value="55"/>
                                                                    <label class="custom-control-label" for="Coupons-write"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Coupons-create" name="permission_role[]" value="52"/>
                                                                    <label class="custom-control-label" for="Coupons-create"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="Coupons-delete" name="permission_role[]" value="54"/>
                                                                    <label class="custom-control-label" for="Coupons-delete"></label>
                                                                </div>
                                                            </td>
                                                            </tr> --}}
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
