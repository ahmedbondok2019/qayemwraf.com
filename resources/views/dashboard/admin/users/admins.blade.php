@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {{-- {!! Html::style('admin/old/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/old/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!} --}}

    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    <!-- BEGIN: Page CSS-->
    {{-- {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}
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

                    
                    {{-- @include('livewire.dashboard.modals.admins.create-admin-modals') --}}
                    {{-- @include('livewire.dashboard.modals.admins.update-admin-modals') --}}

                    {{-- <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/users/deleteMulti' . $routeForm) }}" method="post"> --}}
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h2>{{ trans_db('dashboard.users') }}</h2>
                                    </div>
        
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        @livewire('dashboard.admin.admins')
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                @livewire('dashboard.admin.add-admin')
                            </div>
                        </div>
                        
                        
                    {{-- </form> --}}

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>



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



    {{-- {!! Html::script('admin/old/plugins/datatables/jquery.dataTables.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/jszip/jszip.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/pdfmake/pdfmake.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/pdfmake/vfs_fonts.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.html5.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.print.min.js') !!} --}}
    {{-- {!! Html::script('admin/old/plugins/datatables-buttons/js/buttons.colVis.min.js') !!} --}}

    <script>

        // $(function () {
        //     $("#example1").DataTable({
        //         "responsive": true, "lengthChange": false, "autoWidth": false,
        //         order: [[0, 'desc']],
        //         "buttons": ["copy", "csv", "excel", "pdf", "print"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
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

    <script>
        window.addEventListener('close-modal', event => {

            $('#modals_slide_in').modal('hide');
            $('#modals_slide_in_update').modal('hide');
            $('#deleteStudentModal').modal('hide');
        })
    </script>

    
    <script>
        $(document).ready(function(){
            $("#showEnterCodeModal").on('hidden.bs.modal', function(){
                livewire.emit('onCloseModal');
            });
        });
    </script>


@endsection