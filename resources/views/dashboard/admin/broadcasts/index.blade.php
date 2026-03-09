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
                        <h2 class="content-header-title float-start mb-0 text-primary">{{ trans_db('dashboard.Broadcasting') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Broadcasting') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <a href="{{ route('admin.broadcasts.create') }}" class="btn btn-primary shadow-primary">
                        <i data-feather="plus"></i> {{ trans_db('dashboard.New Campaign') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ trans_db('dashboard.Campaign History') }}</h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i data-feather="filter" class="me-25"></i> Filter
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-menu-item p-1" href="#">All</a>
                            <a class="dropdown-menu-item p-1" href="#">Sent</a>
                            <a class="dropdown-menu-item p-1" href="#">Scheduled</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless">
                        <thead class="table-light">
                            <tr>
                                <th class="py-2">{{ trans_db('dashboard.TITLE') }}</th>
                                <th class="py-2">{{ trans_db('dashboard.AUDIENCE') }}</th>
                                <th class="py-2 text-center">{{ trans_db('dashboard.CHANNELS') }}</th>
                                <th class="py-2">{{ trans_db('dashboard.STATUS') }}</th>
                                <th class="py-2 text-center">{{ trans_db('dashboard.SENT / FAILED') }}</th>
                                <th class="py-2 text-center">{{ trans_db('dashboard.CLICKS / CTR') }}</th>
                                <th class="py-2">{{ trans_db('dashboard.EXECUTION TIME') }}</th>
                                <th class="py-2">{{ trans_db('dashboard.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($broadcasts as $item)
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar bg-light-primary rounded-3 me-1 p-25" style="width: 45px; height: 45px;">
                                            <div class="avatar-content"><i data-feather="send" class="text-primary"></i></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-truncate fw-bolder mb-0" style="font-size: 1.1rem; color: #444;">{{ $item->title }}</span>
                                            <small class="text-muted text-truncate" style="max-width: 250px">{{ Str::limit($item->content, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill badge-light-secondary text-capitalize fw-bold border" style="padding: 0.5rem 1rem;">
                                        <i data-feather="users" class="font-small-3 me-25"></i>
                                        {{ str_replace('_', ' ', $item->audience) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        @foreach($item->channels as $channel)
                                            @php
                                                $icon = [
                                                    'website' => 'monitor',
                                                    'email' => 'mail',
                                                    'sms' => 'message-square',
                                                ][$channel] ?? 'grid';
                                                $color = [
                                                    'website' => 'text-primary',
                                                    'email' => 'text-success',
                                                    'sms' => 'text-warning',
                                                ][$channel] ?? 'text-secondary';
                                            @endphp
                                            <div class="bg-light p-50 rounded" title="{{ $channel }}">
                                                <i data-feather="{{ $icon }}" class="font-medium-1 {{ $color }}"></i>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'sent' => 'badge-light-success',
                                            'scheduled' => 'badge-light-warning',
                                            'pending' => 'badge-light-secondary',
                                            'failed' => 'badge-light-danger'
                                        ][$item->status] ?? 'badge-light-primary';
                                        
                                        $statusIcon = [
                                            'sent' => 'check-circle',
                                            'scheduled' => 'clock',
                                            'pending' => 'more-horizontal',
                                            'failed' => 'alert-circle'
                                        ][$item->status] ?? 'info';
                                    @endphp
                                    <span class="badge rounded-pill {{ $statusClass }} d-inline-flex align-items-center gap-25 p-50 px-1 border">
                                        <i data-feather="{{ $statusIcon }}" class="font-small-2"></i>
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="d-flex gap-50 mb-25">
                                            <span class="badge badge-light-success px-1" title="Sent">{{ $item->sent_count }}</span>
                                            <span class="badge badge-light-danger px-1" title="Failed">{{ $item->failed_count }}</span>
                                        </div>
                                        <div class="progress progress-bar-primary" style="height: 4px; width: 60px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $item->sent_count > 0 ? 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-bolder text-primary" style="font-size: 1.1rem;">{{ $item->clicks_count }}</span>
                                        @php
                                            $ctr = $item->sent_count > 0 ? round(($item->clicks_count / $item->sent_count) * 100, 1) : 0;
                                        @endphp
                                        <small class="text-muted">{{ $ctr }}% CTR</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        @if($item->schedule_at)
                                            <span class="fw-bolder text-warning d-flex align-items-center gap-25">
                                                <i data-feather="calendar" class="font-small-2"></i>
                                                {{ \Carbon\Carbon::parse($item->schedule_at)->format('Y-m-d') }}
                                            </span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->schedule_at)->format('H:i') }}</small>
                                        @else
                                            <span class="fw-bolder text-success d-flex align-items-center gap-25">
                                                <i data-feather="zap" class="font-small-2"></i>
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </span>
                                            <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon btn-flat-secondary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">
                                                <i data-feather="pie-chart" class="me-50"></i> View Stats
                                            </a>
                                            <form action="{{ route('admin.broadcasts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i data-feather="trash-2" class="me-50"></i> Delete
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="bg-light rounded-circle p-2 mb-1">
                                            <i data-feather="send" class="font-large-2 text-muted"></i>
                                        </div>
                                        <h5 class="text-muted">{{ trans_db('dashboard.No broadcasts found') }}</h5>
                                        <p class="text-muted small">Start your first marketing campaign today!</p>
                                        <a href="{{ route('admin.broadcasts.create') }}" class="btn btn-primary btn-sm mt-1">Create Now</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($broadcasts->hasPages())
                <div class="card-footer border-top bg-transparent">
                    {{ $broadcasts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .fw-bolder { font-weight: 800; }
    .shadow-primary { box-shadow: 0 4px 14px 0 rgba(115, 103, 240, 0.4) !important; }
    .table thead th { text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; border-top: none; }
    .table tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #f8f8f8; }
    .table tbody tr:hover { background-color: rgba(115, 103, 240, 0.02); transform: scale(1.001); box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
    .avatar-content i { width: 20px; height: 20px; }
    .progress { background-color: #f3f2f7; }
</style>
@endsection

