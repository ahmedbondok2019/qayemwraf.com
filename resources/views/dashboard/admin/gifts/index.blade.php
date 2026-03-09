@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

@endsection

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ trans_db('dashboard.Gift Requests') }}</h2>
                        </div>

                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans_db('dashboard.Order') }} #</th> <!-- Using a likely existing key or just Order # -->
                                        <th>{{ trans_db('dashboard.User') }}</th>
                                        <th>{{ trans_db('dashboard.BookDetails') }}</th> <!-- Using BookDetails key from dashboard.php -->
                                        <th>{{ trans_db('dashboard.Date') }}</th> <!-- Using Order Date key if Date doesn't exist, checking dashboard.php had 'Order Date' -->
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
            ajax: "{{ route('admin.gifts.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'id', name: 'id'},
                {data: 'user_name', name: 'user.name'},
                {data: 'book_name', name: 'book_name', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $(document).on('change', '.change-status', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.gifts.update_status') }}",
                data: {'status': status, 'id': id, '_token': "{{ csrf_token() }}"},
                success: function(data){
                    console.log(data.success)
                    if(data.success){
                         toastr.success(data.message);
                    } else {
                         toastr.error(data.message);
                    }
                },error: function(data){
                    console.log(data);
                    if (data.responseJSON && data.responseJSON.message) {
                        console.log(data.responseJSON.message);
                        toastr.error(data.responseJSON.message);
                    } else {
                        console.log(data.responseText);
                        toastr.error('{{ trans_db("dashboard.error") }}');
                    }
                }
            });
        });
        
      });
    </script>
@endsection
