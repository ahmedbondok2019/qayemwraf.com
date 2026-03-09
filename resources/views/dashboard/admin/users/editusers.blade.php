@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}

    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}

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
{{--                            <ul class="nav nav-pills" role="tablist">--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">--}}
{{--                                        <i data-feather="user"></i><span class="d-none d-sm-block">Account</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
                            <div class="tab-content">
                                <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/updateAdmin') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $userdetails->id }}">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Name') }}</label>
                                                    <input type="text" class="form-control" placeholder="Name" value="{{$userdetails->name}}" name="name" id="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Email') }}</label>
                                                    <input type="email" class="form-control" placeholder="Email" value="{{$userdetails->email}}" name="email" id="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">{{ trans_db('dashboard.Status') }}</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" {{ $userdetails->status == 1 ? "selected" : "" }}>{{ trans_db('dashboard.active') }}</option>
                                                        <option value="0" {{ $userdetails->status == 0 ? "selected" : "" }}>{{ trans_db('dashboard.Under review') }}</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mt-2">
                                                        <input type="checkbox" class="custom-control-input" id="gift_page_enabled" name="gift_page_enabled" value="1" {{ $userdetails->gift_page_enabled ? 'checked' : '' }} />
                                                        <label class="custom-control-label" for="gift_page_enabled">{{ trans_db('dashboard.gift_page_enabled') }}</label>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($type != 'client')
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="role">{{ trans_db('dashboard.Role') }}</label>
                                                        <select class="form-control" id="role" name="permission_group">
                                                            @php($permission_name = \App\Models\Group::all())
                                                            @foreach($permission_name as $all_per)
                                                                <option value="{{ $all_per->id }}" {{ $userdetails->permission_group == $all_per->id ? 'selected':'' }}> {{ $all_per->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label" for="basic-icon-default-uname">{{ trans_db('website.password') }}</label>
                                                        <input type="password" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="********" aria-label="******" aria-describedby="basic-icon-default-uname2" name="password" />
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($type == 'client')
                                                <div class="col-md-12">
                                                    <div class="row" id="table-hover-row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">{{ trans_db("website.Addresses") }}</h4>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>{{ trans_db("dashboard.address") }}</th>
                                                                                <th>{{ trans_db("dashboard.area") }}</th>
                                                                                <th>{{ trans_db("dashboard.city") }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($userdetails->address as $address)
                                                                                <tr>
                                                                                    <td>{{ $address->address }}</td>
                                                                                    <td>{{ optional(\App\Models\AreaTranslation::where('area_id', $address->area)->first())->title }}</td>
                                                                                    <td>{{ optional(\App\Models\CityTranslation::where('city_id', $address->city)->first())->title }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
{{--                                            <div class="col-md-4">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label class="form-label" for="basic-icon-default-email">Password Confirmation</label>--}}
{{--                                                    <input type="password" id="basic-icon-default-email" class="form-control dt-uname" placeholder="*******" aria-label="******" aria-describedby="basic-icon-default-uname2" name="password_confirmation" />--}}
{{--                                                    <small class="form-text text-muted"> You can use letters, numbers </small>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">{{ trans_db('dashboard.Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
                                </div>
                                <!-- Account Tab ends -->
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
