@extends('dashboard.admin.layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Users') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Users') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{ trans_db('dashboard.Add New') }}</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="datatables-basic table" id="users-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans_db('dashboard.Image') }}</th>
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
            </section>
            <!--/ Basic table -->
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                language: {
                    url: "{{ asset('dashboard/assets/js/datatables-ar.json') }}" // Assuming you have Arabic translation or let it default
                },
                drawCallback: function() {
                    if (feather) {
                        feather.replace();
                    }
                }
            });

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: "{{ trans_db('dashboard.Are you sure?') }}",
                    text: "{{ trans_db('dashboard.AreYouSureToDelete') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ trans_db('dashboard.Delete') }}",
                    cancelButtonText: "{{ trans_db('dashboard.Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.users.index') }}/" + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire(
                                    "{{ trans_db('dashboard.deleted') }}",
                                    "{{ trans_db('dashboard.Success') }}",
                                    'success'
                                )
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    "{{ trans_db('dashboard.error') }}",
                                    xhr.responseJSON.message || "{{ trans_db('dashboard.error') }}",
                                    'error'
                                )
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
