@extends('dashboard.admin.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Contacts') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="contacts-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans_db('dashboard.Name') }}</th>
                                                <th>{{ trans_db('dashboard.Email') }}</th>
                                                <th>{{ trans_db('dashboard.Status') }}</th>
                                                <th>{{ trans_db('dashboard.Actions') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#contacts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.contacts.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                drawCallback: function() {
                    if (feather) {
                        feather.replace();
                    }
                }
            });

            $(document).on('click', '.confirm-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                if (confirm("{{ trans_db('dashboard.Are you sure?') }}")) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
