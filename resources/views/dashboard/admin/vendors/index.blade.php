@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') !!}

    <!-- BEGIN: Page CSS-->
{{--    {!! Html::style('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') !!}--}}
    {{-- {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!} --}}
    <!-- END: Page CSS-->

    <style>
        /* .dark-layout .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th, .dark-layout .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th */
        /* .dark-layout .table , .dark-layout .table thead , .dark-layout .table thead tr th:first { */
        .btrr{    
            border-top-right-radius: 20% !important;
        }
        .btlr{    
            border-top-left-radius: 20% !important;
        }
        .dark-layout .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th, .dark-layout .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th {
            background-color: #161d31 !important;
        }
    </style>
@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="dt-buttons btn-group flex-wrap">
                                @if (in_array('10',\Illuminate\Support\Facades\Session::get("permissionData")))
                                    <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/create') }}" class="btn add-new btn-primary mt-50" tabindex="0"
                                       aria-controls="DataTables_Table_0" type="button">
                                        <span>{{ trans_db('dashboard.Add New vendor') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <table id="example1" class="table table-bordered table-striped btrr btlr">
                                <thead class="btrr btlr">
                                <tr class="btrr btlr">
                                    <th class="btrr"># </th>
                                    <th> {{ trans_db('dashboard.Store Name') }} </th>
                                    <th> {{ trans_db('dashboard.vendor Name') }} </th>
                                    <th> {{ trans_db('dashboard.Phone') }} </th>
                                    <th> {{ trans_db('dashboard.Register Date') }} </th>
                                    @if (in_array('13',\Illuminate\Support\Facades\Session::get("permissionData")))
                                        <th> {{ trans_db('dashboard.Update') }} </th>
                                    @endif
                                    @if (in_array('12',\Illuminate\Support\Facades\Session::get("permissionData")))
                                        <th class="btlr"> {{ trans_db('dashboard.delete') }} </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($vendors as $vendor)
                                    @if (in_array('23',\Illuminate\Support\Facades\Session::get("permissionData")))
                                        @php($editUrl = \LaravelLocalization::localizeUrl('admin-2023/vendors/edit/' . $vendor->id))
                                    @else
                                        @php($editUrl = '#')
                                    @endif
                                    <tr>
                                        <td><a href="{{ $editUrl }}">{{$vendor->id}}</a></td>
                                        <td><a href="{{ $editUrl }}">{{$vendor->name}}</a></td>
                                        <td><a href="{{ $editUrl }}">{{$vendor->full_name}}</a></td>
                                        <td><a href="{{ $editUrl }}">{{$vendor->phone}}</a></td>
                                        <td><a href="{{ $editUrl }}">{{$vendor->created_at}}</a></td>
                                        @if (in_array('23',\Illuminate\Support\Facades\Session::get("permissionData")))
                                            <td><a href="{{ $editUrl }}" class="btn btn-success">{{ trans_db('dashboard.Update') }}</a></td>
                                        @endif

                                        @if (in_array('22',\Illuminate\Support\Facades\Session::get("permissionData")))
                                            <td>
                                                <a onclick="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')"
                                                   href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/delete') }}/{{$vendor->id}}"
                                                   class="btn btn-danger">{{ trans_db('dashboard.delete') }}
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (in_array('20',\Illuminate\Support\Facades\Session::get("permissionData")))
            <div class="modal modal-slide-in new-vendor-modal fade" id="modals-slide-in">
                <div class="modal-dialog">
                    <form class="add-new-vendor modal-content pt-0" action="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/createvendor') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New vendor</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">vendor name</label>
                                <input type="text" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="new vendor" aria-label="jdoe1" aria-describedby="basic-icon-default-uname2" name="vendor_name" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">mobile number</label>
                                <input type="text" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="*************" aria-label="*********" aria-describedby="basic-icon-default-uname2" name="mobile_number" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">civil ID</label>
                                <input type="text" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="2808505020202" aria-label="2808505020202" aria-describedby="basic-icon-default-uname2" name="civil_ID" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="basic-icon-default-uname">date of birth</label>
                                <input type="date" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="19/06/1982" aria-label="19/06/1982" aria-describedby="basic-icon-default-uname2" name="date_birth" />
                            </div>
                            <button type="submit" class="btn btn-primary mr-1 data-submit">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('script')
    {!! Html::script('admin/app-assets/vendors/js/vendors.min.js') !!}

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

    {!! Html::script('admin/app-assets/js/core/app-menu.js') !!}
    {!! Html::script('admin/app-assets/js/core/app.js') !!}

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
                    url:'{!!URL::to('admin-2023/vendors/change_status')!!}',
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



