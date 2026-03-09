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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Offers') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.offers.index') }}">{{ trans_db('dashboard.Offers') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Show') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $offer->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ trans_db('dashboard.Name') }}:</strong> {{ $offer->name }}</p>
                                <p><strong>{{ trans_db('dashboard.Category') }}:</strong> {{ $offer->category->name ?? 'N/A' }}</p>
                                <p><strong>{{ trans_db('dashboard.Status') }}:</strong> 
                                    @if($offer->is_active)
                                        <span class="badge badge-light-success">{{ trans_db('dashboard.Active') }}</span>
                                    @else
                                        <span class="badge badge-light-danger">{{ trans_db('dashboard.Inactive') }}</span>
                                    @endif
                                </p>
                                <p><strong>{{ trans_db('dashboard.Sort Order') }}:</strong> {{ $offer->sort_order }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($offer->image)
                                    <p><strong>{{ trans_db('dashboard.Image') }}:</strong></p>
                                    <img src="{{ asset($offer->image) }}" alt="{{ $offer->name }}" class="img-fluid rounded" style="max-height: 300px;">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-primary">{{ trans_db('dashboard.Edit') }}</a>
                                <a href="{{ route('admin.offers.index') }}" class="btn btn-outline-secondary">{{ trans_db('dashboard.Back') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
