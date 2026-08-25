@extends('dashboard.admin.layouts.app')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Products') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Products') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <a href="{{ route('admin.products.import') }}" class="btn btn-outline-primary mr-1">
                            <i data-feather="upload"></i> {{ trans_db('dashboard.Import Products') }}
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i data-feather="plus"></i> {{ trans_db('dashboard.Add New') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-3 shadow-sm border-0" style="border-radius: 12px;">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" id="products-table" style="width: 100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 4%;">#</th>
                                                <th style="width: 6%;">{{ trans_db('dashboard.Image') }}</th>
                                                <th style="width: 25%;">{{ trans_db('dashboard.Name') }}</th>
                                                <th style="width: 12%;">{{ trans_db('dashboard.SKU') }}</th>
                                                <th style="width: 18%;">{{ trans_db('dashboard.Categories') }}</th>
                                                <th style="width: 10%;">{{ trans_db('dashboard.Price') }}</th>
                                                <th style="width: 7%;">{{ trans_db('dashboard.Quantity') }}</th>
                                                <th style="width: 6%;">{{ trans_db('dashboard.Front-end') }}</th>
                                                <th style="width: 6%;">{{ trans_db('dashboard.Status') }}</th>
                                                <th style="width: 6%;">{{ trans_db('dashboard.Actions') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function() {
            var table = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                language: {
                    processing: '<div class="d-flex justify-content-center align-items-center p-2"><div class="spinner-border text-primary" role="status"><span class="sr-only">جاري التحميل...</span></div></div>',
                    search: "بحث:",
                    searchPlaceholder: "اسم، رمز، أو قسم...",
                    lengthMenu: "عرض _MENU_ عنصر",
                    info: "عرض _START_ إلى _END_ من _TOTAL_ منتج",
                    infoEmpty: "لا توجد نتائج",
                    infoFiltered: "(من إجمالي _MAX_ منتج)",
                    zeroRecords: "لم يتم العثور على منتجات مطابقة",
                    paginate: {
                        first: "الأول",
                        last: "الأخير",
                        next: "التالي",
                        previous: "السابق"
                    }
                },
                ajax: "{{ route('admin.products.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '4%', className: 'text-center align-middle' },
                    { data: 'image', name: 'image', orderable: false, searchable: false, width: '6%', className: 'text-center align-middle' },
                    { data: 'name', name: 'name', width: '25%', className: 'align-middle' },
                    { data: 'sku', name: 'sku', width: '12%', className: 'text-center align-middle' },
                    { data: 'categories', name: 'categories', orderable: false, searchable: true, width: '18%', className: 'align-middle' },
                    { data: 'price', name: 'price', width: '10%', className: 'text-center align-middle' },
                    { data: 'quantity', name: 'quantity', width: '7%', className: 'text-center align-middle font-weight-bold' },
                    { data: 'show_on_home', name: 'show_on_home', width: '6%', className: 'text-center align-middle' },
                    { data: 'status', name: 'status', width: '6%', className: 'text-center align-middle' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '6%', className: 'text-center align-middle' }
                ],
                drawCallback: function() {
                    if (feather) {
                        feather.replace();
                    }
                }
            });


            $(document).on('change', '.toggle-show-on-home', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.products.toggle_home', '') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success("{{ trans_db('dashboard.updated_successfully') }}");
                    },
                    error: function() {
                        toastr.error("{{ trans_db('dashboard.error') }}");
                    }
                });
            });
        });

        function deleteItem(id) {
            Swal.fire({
                title: "{{ trans_db('dashboard.Are you sure?') }}",
                text: "{{ trans_db('dashboard.You wont be able to revert this!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ trans_db('dashboard.Yes, delete it!') }}",
                cancelButtonText: "{{ trans_db('dashboard.Cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.products.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#products-table').DataTable().ajax.reload();
                            Swal.fire(
                                "{{ trans_db('dashboard.Deleted!') }}",
                                "{{ trans_db('dashboard.Your file has been deleted.') }}",
                                'success'
                            )
                        }
                    });
                }
            })
        }
    </script>
@endsection
