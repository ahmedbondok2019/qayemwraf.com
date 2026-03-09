@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ trans_db('dashboard.Orders') }}</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans_db('dashboard.Order') }} #</th>
                                        <th>{{ trans_db('dashboard.User') }}</th>
                                        <th>{{ trans_db('dashboard.Details') }}</th>
                                        <th>{{ trans_db('dashboard.Total') }}</th>
                                        <th>{{ trans_db('dashboard.Date') }}</th>
                                        <th>{{ trans_db('dashboard.Status') }}</th>
                                        <th>{{ trans_db('dashboard.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script type="text/javascript">
      $(function () {
        
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.orders.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'id', name: 'id'},
                {data: 'user_name', name: 'user_name'},
                {data: 'details', name: 'details', orderable: false},
                {data: 'total_formatted', name: 'total'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[5, 'desc']]
        });

        $(document).on('change', '.change-status', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.orders.update_status') }}",
                data: {'status': status, 'id': id, '_token': "{{ csrf_token() }}"},
                success: function(data){
                    if(data.success){
                         toastr.success(data.message);
                    } else {
                         toastr.error(data.message);
                    }
                },error: function(data){
                    toastr.error('{{ trans_db("dashboard.error") }}');
                }
            });
        });
        
      });
    </script>
@endsection
