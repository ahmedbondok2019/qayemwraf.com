@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    <!-- BEGIN: Page CSS-->
{{--    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}--}}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}
    <!-- END: Page CSS-->

@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">                
                <div class="col-lg-6 p-2">
                    <div class="dt-buttons btn-group flex-wrap">
                        @if (in_array('20',\Illuminate\Support\Facades\Session::get("permissionData")))
                           <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/team_work/addteam_work') }}" class="btn add-new btn-primary mt-50" tabindex="0">
                               <span>{{ trans_db('dashboard.Add New team_work') }}</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    @livewire('dashboard.admin.team-works')
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>

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





    {{-- {!! Html::script('admin/old/plugins/datatables/jquery.dataTables.min.js') !!}
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
    {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.colVis.min.js') !!} --}}

    {{-- <script>

        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": true,
                searching: false, paging: false,
                order: [[0, 'desc']],
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script> --}}

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
            $(document).on('change','.team_work_status',function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var team_work_id =$(this).attr('data-team_work-id');
                var team_work_status = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!!URL::to('admin-2023/team_work/change_status')!!}',
                    data:{'team_work_id':team_work_id,team_work_status:team_work_status},
                    success:function(data) {
                        // console.log("success");
                    },
                    fail:function(xhr, status, error) {}
                });
            });
        });
        
        $(document).ready(function(){
            $(document).on('change','.team_work_vendor',function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var team_work_id =$(this).attr('data-vendor-id');
                var vendor_id = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!!URL::to('admin-2023/team_work/change_vendor')!!}',
                    data:{'team_work_id':team_work_id,vendor_id:vendor_id},
                    success:function(data) {
                        // console.log("success");
                    },
                    fail:function(xhr, status, error) {}
                });
            });
        });

    </script>

@endsection




