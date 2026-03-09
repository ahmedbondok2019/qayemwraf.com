@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

<style>
    /* .dark-layout .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th, .dark-layout .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th */
    /* .dark-layout .table , .dark-layout .table thead , .dark-layout .table thead tr th:first { */
    .btrr{    
        border-top-right-radius: 25px !important;
    }
    .btlr{    
        border-top-left-radius: 25px !important;
    }
    .dark-layout .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th, .dark-layout .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th {
        background-color: #161d31 !important;
    }
</style>

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>
    @include('dashboard.admin.component.page_header' , ['translation' => trans_db('dashboard.bugs') ])

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="dt-buttons btn-group flex-wrap">
                                    <a href="#" class="btn add-new btn-primary mt-50" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                        <span>{{ trans_db('dashboard.bugs') }}</span>
                                    </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <table id="example1" class="table table-bordered table-striped btrr btlr">
                                <thead class="btrr btlr">
                                <tr class="btrr">
                                    <th class="btrr"> # </th>
                                    <th> {{ trans_db('dashboard.Name') }} </th>
                                    <th> {{ trans_db('dashboard.Order') }} </th>
                                    <th> {{ trans_db('dashboard.Date') }} </th>
                                    <th> {{ trans_db('dashboard.Status') }} </th>
                                    <th> {{ trans_db('dashboard.Update') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </th class="btlr">
                                </thead>
                                <tbody>
                                @foreach ($log_apis as $msg)
{{--                                    <tr style="{{ \App\Http\Controllers\admin\CustomerController::GetFileStatus($msg->status)['style'] }}">--}}
                                    <tr>
                                        <td>{{$msg->id}}</td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/edit') }}/{{$msg->id}}">{{ optional(\App\Models\User::find($msg->user_id))->name }}</a></td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/edit') }}/{{$msg->id}}">{{ $msg->order_id }}</a></td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/edit') }}/{{$msg->id}}">{{ $msg->created_at }}</a></td>
                                        <td>
                                            <span> {{ \App\Http\Controllers\Admin\CustomerMessageController::GetFileStatus($msg->status)['trans'] }} </span>
                                        </td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/edit') }}/{{$msg->id}}" class="btn btn-success">{{ trans_db('dashboard.Update') }}</a></td>
                                        <td><a onclick="return confirm(<?php echo 'Are You Sure To Delete ?'; ?>)" href="{{ \LaravelLocalization::localizeUrl('admin-2023/bugs/delete') }}/{{$msg->id}}" class="btn btn-danger">{{ trans_db('dashboard.delete') }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    {{ $log_apis->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
