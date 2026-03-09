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
                                    <p><strong>{{ trans_db('dashboard.Name') }}:</strong> {{ $order->user ? $order->user->name : ($order->first_name . ' ' . $order->last_name) }}</p>
                                    <p><strong>{{ trans_db('dashboard.Email') }}:</strong> {{ $order->user ? $order->user->email : $order->email }}</p>
                                    <p><strong>{{ trans_db('dashboard.Phone') }}:</strong> {{ $order->user ? $order->user->phone : $order->phone }}</p>
                                    <p><strong>{{ trans_db('dashboard.address') }}:</strong> 
                                        {{ $order->address }}, 
                                        {{ $order->governorate_rel->name ?? '' }}, 
                                        {{ $order->city_rel->name ?? '' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ trans_db('dashboard.Order Info') }}</h5>
                                    <p><strong>{{ trans_db('dashboard.Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                                    <p><strong>{{ trans_db('dashboard.Status') }}:</strong> {{ trans_db('dashboard.'.$order->status) }}</p>
                                    <p><strong>{{ trans_db('dashboard.Payment Method') }}:</strong> {{ $order->payment_method }}</p>
                                    <p><strong>{{ trans_db('dashboard.Subtotal') }}:</strong> {{ $order->subtotal }} {{ $order->currency }}</p>
                                    <p><strong>{{ trans_db('dashboard.Discount') }}:</strong> {{ $order->discount }} {{ $order->currency }}</p>
                                    <p><strong>{{ trans_db('dashboard.Total') }}:</strong> {{ $order->total }} {{ $order->currency }}</p>
                                </div>
                            </div>

                            @if($order->note)
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h5>{{ trans_db('dashboard.Notes') }}</h5>
                                    <p>{{ $order->note }}</p>
                                </div>
                            </div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans_db('dashboard.Product') }}</th>
                                        <th>{{ trans_db('dashboard.Price') }}</th>
                                        <th>{{ trans_db('dashboard.Quantity') }}</th>
                                        <th>{{ trans_db('dashboard.Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->order_details as $detail)
                                    <tr>
                                        <td>{{ $detail->product->translation->name ?? $detail->product->id }}</td>
                                        <td>{{ $detail->price }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->subtotal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ trans_db('dashboard.Back') }}</a>
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
