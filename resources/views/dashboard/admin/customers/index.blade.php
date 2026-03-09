@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {{-- {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    <!-- BEGIN: Page CSS-->
    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!} --}}
    <!-- END: Page CSS-->

@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/deleteMulti' . $routeForm) }}" method="post">
                        @csrf
                        <div class="card">
                            {{-- <div class="card-header">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <button class="btn add-new btn-primary mt-50" tabindex="0"
                                            aria-controls="DataTables_Table_0" type="button"
                                            data-toggle="modal" data-target="#modals-slide-in">
                                        <span>{{ trans_db('dashboard.Add New User') }}</span>
                                    </button>
                                </div>
                                <input type="submit" value="{{ trans_db('dashboard.MultiDelete') }}" name="submit" class="btn btn-danger">
                            </div> --}}

                            <!-- /.card-header -->
                            <div class="card-body">
                                @livewire('dashboard.admin.users')
                            </div>
                        </div>
                    </form>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        {{-- @if (in_array('10', \App\Http\Controllers\helper\HelperController::getPermissions()))
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog">
                    <form class="add-new-user modal-content pt-0" action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/createUser') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">{{ trans_db('dashboard.New User') }}</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">{{ trans_db('dashboard.Name') }}</label>
                                <input type="text" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="new user" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="name" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">{{ trans_db('dashboard.Email') }}</label>
                                <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="john@example.com" aria-label="john@example.com" aria-describedby="basic-icon-default-email2" name="email" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">{{ trans_db('website.password') }}</label>
                                <input type="password" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="********" aria-label="******" aria-describedby="basic-icon-default-uname2" name="password" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-email">Password Confirmation</label>
                                <input type="password" id="basic-icon-default-email" class="form-control dt-uname" placeholder="*******" aria-label="******" aria-describedby="basic-icon-default-uname2" name="password_confirmation" />
                                <small class="form-text text-muted"> You can use letters, numbers </small>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user-role">{{ trans_db('dashboard.Role') }}</label>
                                <select class="form-control" name="admin" id="user-role" >
                                    @php($permission_name = \App\Models\Group::all())
                                    @foreach($permission_name as $all_per)
                                        <option value="{{ $all_per->id }}"> {{ $all_per->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mr-1 data-submit">{{ trans_db('dashboard.Save') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">{{ trans_db('dashboard.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif --}}
    </div>
    <!-- END: Content-->
@endsection

@section('script')
    {!! Html::script('admin/app-assets/vendors/js/vendors.min.js') !!}

    <!-- BEGIN: Page Vendor JS-->
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') !!}--}}
{{--    {!! Html::script('admin/app-assets/vendors/js/forms/validation/jquery.validate.min.js') !!}--}}



    {!! Html::script('admin/old/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}
    {!! Html::script('admin/old/plugins/jszip/jszip.min.js') !!}
    {!! Html::script('admin/old/plugins/pdfmake/pdfmake.min.js') !!}
    {!! Html::script('admin/old/plugins/pdfmake/vfs_fonts.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.html5.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.print.min.js') !!}
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}

    <script>

        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                order: [[0, 'desc']],
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    {!! Html::script('admin/app-assets/js/core/app-menu.js') !!}
    {!! Html::script('admin/app-assets/js/core/app.js') !!}
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
{{--    {!! Html::script('admin/app-assets/js/scripts/pages/app-user-list.js') !!}--}}
    <!-- END: Page JS-->

{{--    <script>--}}
{{--        $(window).on('load', function() {--}}
{{--            if (feather) {--}}
{{--                feather.replace({--}}
{{--                    width: 14,--}}
{{--                    height: 14--}}
{{--                });--}}
{{--            }--}}
{{--        })--}}
{{--    </script>--}}

    <script>

        $(document).ready(function(){
            $(document).on('change','.user_status',function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var user_id =$(this).attr('data-user-id');
                var user_status = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!!URL::to('admin-2023/users/change_status')!!}',
                    data:{'user_id':user_id,user_status:user_status},
                    success:function(data) {
                        // console.log("success");
                    },
                    fail:function(xhr, status, error) {}
                });
            });
        });

    </script>

@endsection



