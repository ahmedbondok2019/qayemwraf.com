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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Payment Methods') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <!-- Add New Button Removed -->
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">{{ trans_db('dashboard.Payment Methods List') }}</h4>
                                </div>
                                <div class="card-body mt-2">
                                    <table class="datatables-basic table" id="payment-methods-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans_db('dashboard.Name') }} ({{ app()->getLocale() }})</th>
                                                <th>{{ trans_db('dashboard.Tax') }} (%)</th>
                                                <th>{{ trans_db('dashboard.Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentMethods as $method)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.payment_methods.edit', $method->id) }}">
                                                            {{ $method->name }} <i data-feather="edit-2" class="width-14 height-14 ml-50"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $method->tax }}%</td>
                                                    <td>
                                                        @if($method->is_active)
                                                            <span class="badge badge-light-success">{{ trans_db('dashboard.Active') }}</span>
                                                        @else
                                                            <span class="badge badge-light-danger">{{ trans_db('dashboard.Inactive') }}</span>
                                                        @endif
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
            if ($.fn.DataTable.isDataTable('#payment-methods-table')) {
                $('#payment-methods-table').DataTable().destroy();
            }
            $('#payment-methods-table').DataTable({
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
