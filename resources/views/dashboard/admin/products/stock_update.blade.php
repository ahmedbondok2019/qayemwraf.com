@extends('dashboard.admin.layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-fluid p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.Stock Update') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans_db('dashboard.Products') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Stock Update') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Upload Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Upload Stock Excel') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ trans_db('dashboard.Upload an Excel file with columns') }}: <strong>sku, quantity</strong>. 
                                {{ trans_db('dashboard.The quantity will be added to the current stock.') }}
                            </p>
                            @if(session('success'))
                                <div class="alert alert-success mt-1">
                                    <div class="alert-body">{{ session('success') }}</div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger mt-1">
                                    <div class="alert-body">{{ session('error') }}</div>
                                </div>
                            @endif

                            <form action="{{ route('admin.products.stock.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-6 col-12">
                                        <label class="form-label" for="file">{{ trans_db('dashboard.Choose Excel File') }}</label>
                                        <input class="form-control" type="file" id="file" name="file" required accept=".xlsx, .xls, .csv">
                                    </div>
                                    <div class="col-md-3 col-12 mt-1">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i data-feather="upload" class="me-25"></i> {{ trans_db('dashboard.Upload & Update') }}
                                        </button>
                                    </div>
                                    <div class="col-md-3 col-12 mt-1">
                                        <a href="{{ route('admin.products.stock.download_template') }}" class="btn btn-outline-secondary w-100">
                                            <i data-feather="download" class="me-25"></i> {{ trans_db('dashboard.Download Template') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div class="row mt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ trans_db('dashboard.Update History') }}</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans_db('dashboard.Date') }}</th>
                                        <th>{{ trans_db('dashboard.Admin') }}</th>
                                        <th>{{ trans_db('dashboard.File') }}</th>
                                        <th>{{ trans_db('dashboard.Total Rows') }}</th>
                                        <th>{{ trans_db('dashboard.Successful') }}</th>
                                        <th>{{ trans_db('dashboard.Failed') }}</th>
                                        <th>{{ trans_db('dashboard.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($history as $update)
                                        <tr>
                                            <td>{{ $update->id }}</td>
                                            <td>{{ $update->created_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $update->admin->name ?? 'System' }}</td>
                                            <td>{{ $update->filename }}</td>
                                            <td><span class="badge badge-light-secondary">{{ $update->total_rows }}</span></td>
                                            <td><span class="badge badge-light-success">{{ $update->successful_updates }}</span></td>
                                            <td><span class="badge badge-light-danger">{{ $update->failed_updates }}</span></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info view-details" data-id="{{ $update->id }}">
                                                    <i data-feather="eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">{{ trans_db('dashboard.No history found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $history->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans_db('dashboard.Update Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>{{ trans_db('dashboard.Status') }}</th>
                                <th>{{ trans_db('dashboard.Details') }}</th>
                            </tr>
                        </thead>
                        <tbody id="detailsBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('.view-details').on('click', function() {
        let id = $(this).data('id');
        $.get("{{ url('admin-2026/products/stock/show') }}/" + id, function(data) {
            let html = '';
            data.details.forEach(item => {
                let statusClass = item.status === 'success' ? 'text-success' : 'text-danger';
                let detailsText = item.status === 'success' 
                    ? `Added: ${item.added} | New Qty: ${item.new_qty}` 
                    : item.reason;
                
                html += `<tr>
                    <td>${item.sku}</td>
                    <td class="${statusClass}">${item.status.toUpperCase()}</td>
                    <td>${detailsText}</td>
                </tr>`;
            });
            $('#detailsBody').html(html);
            $('#detailsModal').modal('show');
        });
    });
</script>
@endpush
@endsection
