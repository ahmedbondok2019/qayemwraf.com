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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Blog Categories') }}</h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <a href="{{ route('admin.blog_categories.create') }}" class="btn btn-primary">{{ trans_db('dashboard.Add New') }}</a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="blog-categories-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans_db('dashboard.Name') }}</th>
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
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#blog-categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.blog_categories.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            drawCallback: function() {
                if (feather) {
                    feather.replace();
                }
            }
        });

        $(document).on('change', '.status-switch', function() {
            let status = $(this).prop('checked') ? 1 : 0;
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.blog_categories.change_status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    toastr.success("{{ trans_db('dashboard.updated') }}");
                }
            });
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
