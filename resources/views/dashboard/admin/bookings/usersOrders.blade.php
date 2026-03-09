@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

    @include('dashboard.admin.component.page_header' , ['translation' => $trans ])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <div class="row">
                                <div class="col-md-9">
                                    <form role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/reports/' . $route) }}" method="post">
                                        @csrf
                                        <table class="table text-center">
                                            <tbody>
                                            <tr>
                                                <td>{{ trans_db('dashboard.Period') }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group" style="direction: ltr !important;">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control float-right" id="reservation" name="timeRange">
                                                            <input type="hidden" name="dateFrom">
                                                            <input type="hidden" name="dateTo">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ trans_db('dashboard.User') }}</td>
                                                <td>
                                                    <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                                                        @php($users = \App\Models\User::active()->get())
                                                        <select name="user" class="form-control select2" style="width: 100%;">
                                                            <option value="">{{ trans_db('dashboard.User') }}</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{$user->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">{{ $errors->first('user') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-block btn-success">{{ trans_db('dashboard.Show') }}</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="col-md-3" style="text-align: center !important;">
                                    <span>{{ trans_db('dashboard.TotalOrder') }}</span>
                                    <h2>@if(isset($totalOrder)){{ $totalOrder }}@endif</h2>
                                </div>
                            </div>


{{--                            @php(\Illuminate\Support\Facades\Session::put('reports',$reports))--}}
                            @include('dashboard.admin.reports.usersOrdersTable', [ $reports , $route])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('script')

    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}
    {!! Html::script('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}
    {!! Html::script('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}
    {!! Html::script('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}
    {!! Html::script('admin/plugins/jszip/jszip.min.js') !!}
    {!! Html::script('admin/plugins/pdfmake/pdfmake.min.js') !!}
    {!! Html::script('admin/plugins/pdfmake/vfs_fonts.js') !!}
    {!! Html::script('admin/plugins/datatables-buttons/js/buttons.html5.min.js') !!}
    {!! Html::script('admin/plugins/datatables-buttons/js/buttons.print.min.js') !!}
    {!! Html::script('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}

    <script>

        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(document).ready(function(){
            $(document).on('change','.car_status',function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var car_id =$(this).attr('data-car-id');
                var status = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!! \LaravelLocalization::localizeUrl('admin-2023/cars/change_status') !!}',
                    data:{'car_id':car_id,status:status},
                    success:function(data) {
                        // console.log("success");
                    },
                    fail:function(xhr, status, error) {}
                });
            });
        });

    </script>

    <script>
        $(function() {
            $('input[name="timeRange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $("input[name='dateFrom']").val(start.format('YYYY-MM-DD'));
                $("input[name='dateTo']").val(end.format('YYYY-MM-DD'));
            });
        });


    </script>
@endsection
