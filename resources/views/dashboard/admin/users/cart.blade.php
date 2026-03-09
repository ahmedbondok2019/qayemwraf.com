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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Cart') }} - {{ $user->name }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ trans_db('dashboard.Users') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Cart') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.User Cart Items') }}</h4>
                            </div>
                            <div class="card-datatable">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans_db('dashboard.Product') }}</th>
                                            <th>{{ trans_db('dashboard.Options') }}</th>
                                            <th>{{ trans_db('dashboard.Quantity') }}</th>
                                            <th>{{ trans_db('dashboard.Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($carts as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset($item->product->image) }}" class="mr-1 rounded" width="50" height="50">
                                                        @endif
                                                        <span>{{ $item->product ? $item->product->name : 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->options->count() > 0)
                                                        @foreach($item->options as $option)
                                                            <span class="badge badge-light-secondary">
                                                                {{ $option->attribute ? $option->attribute->name : 'N/A' }}: {{ $option->value }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ trans_db('dashboard.No items in cart') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
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
