@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.projects') ?: 'المشروعات' }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.projects') ?: 'المشروعات' }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                            <i data-feather="plus"></i> {{ trans_db('dashboard.Add New') ?: 'إضافة جديد' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom d-flex justify-content-between">
                                    <h4 class="card-title">{{ trans_db('dashboard.projects') ?: 'قائمة المشروعات' }}</h4>
                                    <span class="badge badge-light-primary">{{ $projects->total() }} {{ trans_db('dashboard.project') ?: 'مشروع' }}</span>
                                </div>
                                <div class="card-body mt-2">
                                    @if(session('success'))
                                        <div class="alert alert-success p-1 mb-2">{{ session('success') }}</div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ trans_db('dashboard.Image') ?: 'الصورة' }}</th>
                                                    <th>{{ trans_db('dashboard.Title') ?: 'عنوان المشروع' }}</th>
                                                    <th>{{ trans_db('dashboard.Sort') ?: 'الترتيب' }}</th>
                                                    <th>{{ trans_db('dashboard.Status') ?: 'الحالة' }}</th>
                                                    <th>{{ trans_db('dashboard.Created At') ?: 'تاريخ الإضافة' }}</th>
                                                    <th>{{ trans_db('dashboard.Actions') ?: 'العمليات' }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($projects as $project)
                                                    <tr>
                                                        <td>{{ $loop->iteration + ($projects->currentPage() - 1) * $projects->perPage() }}</td>
                                                        <td>
                                                            @if($project->image)
                                                                <a href="{{ asset($project->image) }}" target="_blank">
                                                                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" width="80" height="60" style="object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                                                </a>
                                                            @else
                                                                <span class="badge badge-light-secondary">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <strong>{{ $project->title }}</strong>
                                                            @if($project->description)
                                                                <br><small class="text-muted">{{ Str::limit($project->description, 60) }}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $project->sort_order }}</td>
                                                        <td>
                                                            <div class="custom-control custom-switch custom-switch-success">
                                                                <input type="checkbox" class="custom-control-input change-status" id="customSwitch{{ $project->id }}" data-id="{{ $project->id }}" {{ $project->is_active ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="customSwitch{{ $project->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $project->created_at ? $project->created_at->format('Y-m-d') : '-' }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary mr-1" title="{{ trans_db('dashboard.Edit') }}">
                                                                    <i data-feather="edit-2"></i>
                                                                </a>
                                                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('{{ trans_db('dashboard.Are you sure?') ?: 'هل أنت متأكد من الحذف؟' }}');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ trans_db('dashboard.Delete') }}">
                                                                        <i data-feather="trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-3 text-muted">
                                                            {{ trans_db('dashboard.No data available') ?: 'لا توجد مشروعات مضافة حالياً' }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2 d-flex justify-content-center">
                                        {{ $projects->links() }}
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('.change-status').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.projects.change_status') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'status': status,
                    'id': id
                },
                success: function(data) {
                    toastr.success('{{ trans_db("dashboard.status_updated") ?: "تم تحديث الحالة بنجاح" }}');
                }
            });
        });
    });
</script>
@endpush
