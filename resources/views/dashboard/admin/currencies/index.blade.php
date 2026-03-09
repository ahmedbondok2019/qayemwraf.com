@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')
    <div class="app-content content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ trans_db('dashboard.currencies') }}</h2>
                            <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">{{ trans_db('dashboard.Create') }}</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans_db('dashboard.code') }}</th>
                                            <th>{{ trans_db('dashboard.name') }}</th>
                                            <th>{{ trans_db('dashboard.symbol') }}</th>
                                            <th>{{ trans_db('dashboard.exchange_rate') }}</th>
                                            <th>{{ trans_db('dashboard.default') }}</th>
                                            <th>{{ trans_db('dashboard.Status') }}</th>
                                            <th>{{ trans_db('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($currencies as $currency)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $currency->code }}</td>
                                                <td>{{ $currency->name }}</td>
                                                <td>{{ $currency->symbol }}</td>
                                                <td>{{ $currency->exchange_rate }}</td>
                                                <td>
                                                    @if($currency->is_default)
                                                        <span class="badge badge-success">{{ trans_db('dashboard.yes') }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ trans_db('dashboard.no') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($currency->status)
                                                        <span class="badge badge-success">{{ trans_db('dashboard.active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ trans_db('dashboard.inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.currencies.edit', $currency->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.currencies.destroy', $currency->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ trans_db('dashboard.are_you_sure') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection