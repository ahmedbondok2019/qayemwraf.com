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
                            <h2>{{ trans_db('dashboard.Order Details') }} #{{ $order->id }}</h2>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <h5>{{ trans_db('dashboard.User Info') }}</h5>
                                    <p><strong>{{ trans_db('dashboard.Name') }}:</strong> {{ $order->user ? $order->user->name : $order->first_name }}</p>
                                    <p><strong>{{ trans_db('dashboard.Email') }}:</strong> {{ $order->user ? $order->user->email : $order->email }}</p>
                                    <p><strong>{{ trans_db('dashboard.Phone') }}:</strong> {{ $order->user ? $order->user->phone : $order->phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ trans_db('dashboard.Order Info') }}</h5>
                                    <p><strong>{{ trans_db('dashboard.Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                                    <p><strong>{{ trans_db('dashboard.Status') }}:</strong> {{ $order->status }}</p>
                                    <p><strong>{{ trans_db('dashboard.Payment Method') }}:</strong> {{ $order->payment_method }}</p>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans_db('dashboard.Product') }}</th>
                                        <th>{{ trans_db('dashboard.Quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->order_details as $detail)
                                    <tr>
                                        <td>{{ $detail->product->translation->name ?? $detail->product->id }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                <a href="{{ route('admin.gifts.index') }}" class="btn btn-secondary">{{ trans_db('dashboard.Back') }}</a>
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
