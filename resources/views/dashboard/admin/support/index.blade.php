@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>
    @include('dashboard.admin.component.page_header' , ['translation' => $type ])

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="dt-buttons btn-group flex-wrap">
                                    <a href="#" class="btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                        <span>{{ trans_db('dashboard.Support') }}</span>
                                    </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> {{ trans_db('dashboard.Name') }} </th>
                                    <th> {{ trans_db('dashboard.Status') }} </th>
                                    <th> {{ trans_db('dashboard.Update') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($customer_messages as $msg)
{{--                                    <tr style="{{ \App\Http\Controllers\admin\CustomerController::GetFileStatus($msg->status)['style'] }}">--}}
                                    <tr>
                                        <td>{{$msg->id}}</td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/customer_messages/editcontacts') }}/{{$msg->id}}">{{$msg->contact_name}}</a></td>
                                        <td>
                                            <span> {{ \App\Http\Controllers\Admin\CustomerMessageController::GetFileStatus($msg->status)['trans'] }} </span>
                                        </td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/customer_messages/editcontacts') }}/{{$msg->id}}" class="btn btn-success">{{ trans_db('dashboard.Update') }}</a></td>
                                        <td><a onclick="return confirm(<?php echo 'Are You Sure To Delete ?'; ?>)" href="{{ \LaravelLocalization::localizeUrl('admin-2023/customer_messages/delete') }}/{{$msg->id}}" class="btn btn-danger">{{ trans_db('dashboard.delete') }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th> # </th>
                                    <th> {{ trans_db('dashboard.Name') }} </th>
                                    <th> {{ trans_db('dashboard.Status') }} </th>
                                    <th> {{ trans_db('dashboard.Update') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </tr>
                                </tfoot>
                            </table>
                            {{ $customer_messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
