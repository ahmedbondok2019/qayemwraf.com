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
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Offers') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">
                            <i data-feather="plus"></i> {{ trans_db('dashboard.Add New') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">{{ trans_db('dashboard.Offers List') }}</h4>
                                </div>
                                <div class="card-body mt-2">
                                    <table class="datatables-basic table" id="offers-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans_db('dashboard.Name') }} ({{ app()->getLocale() }})</th>
                                                <th>{{ trans_db('dashboard.Category') }}</th>
                                                <th>{{ trans_db('dashboard.Status') }}</th>
                                                <th>{{ trans_db('dashboard.Image') }}</th>
                                                <th>{{ trans_db('dashboard.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($offers as $offer)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $offer->name }}</td>
                                                    <td>{{ $offer->category->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($offer->is_active)
                                                            <span class="badge badge-light-success">{{ trans_db('dashboard.Active') }}</span>
                                                        @else
                                                            <span class="badge badge-light-danger">{{ trans_db('dashboard.Inactive') }}</span>
                                                        @endif
                                                    </td>
                                                     <td>
                                                        @if($offer->image)
                                                            <img src="{{ asset($offer->image) }}" alt="img" width="50" class="rounded">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ route('admin.offers.edit', $offer->id) }}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>{{ trans_db('dashboard.Edit') }}</span>
                                                                </a>
                                                                <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('{{ trans_db('dashboard.Are you sure?') }}');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i data-feather="trash" class="mr-50"></i>
                                                                        <span>{{ trans_db('dashboard.Delete') }}</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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

@section('script')
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#offers-table')) {
                $('#offers-table').DataTable().destroy();
            }
            $('#offers-table').DataTable({
                "paging": true,
                "info": true,
                "searching": true,
                "language": {
                     "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/{{ app()->getLocale() == 'ar' ? 'Arabic' : 'English' }}.json"
                }
            });
        });
    </script>
@endsection