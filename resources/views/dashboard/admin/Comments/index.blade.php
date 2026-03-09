

@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.Messages') }}</h2>
                </div>
            </div>
        </div>

        <div class="content-body">
            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

            <div class="card">
                <div class="card-content" style="">
                    <div class="card-body">

            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th> # </th>
                    <th>{{ trans_db('dashboard.Name') }}</th>
                    <th>{{ trans_db('dashboard.product Name') }}</th>
                    <th>{{ trans_db('dashboard.ratings') }}</th>
                    {{-- <th>{{ trans_db('dashboard.Notes') }}</th> --}}
                    <th>{{ trans_db('dashboard.Activate') }}</th>
                    <th>{{ trans_db('dashboard.Order') }}</th>
                    <th>{{ trans_db('dashboard.Comment') }}</th>
                    <th>{{ trans_db('dashboard.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($Comments as $Comment)
                    <tr>
                        <td>{{ $Comment->id }}</td>
                        <td>{{ optional(\App\Models\User::find($Comment->user_id))->name }}</td>
                        <td>{{ optional(\App\Models\ProductTranslation::where('product_id', $Comment->product_id)->where('lang_id', app()->getLocale())->first())->title }}</td>
                        {{-- <td>{{ $Comment->notes }}</td> --}}
                        <td>
                            {!! \App\Http\Controllers\Admin\CommentsController::getRate($Comment->order_id , $Comment->order_id , $Comment->product_id) !!}
                        </td>
                        @if($Comment->status == 1) @php $class = "btn btn-danger"; $trans = 'Stop'; @endphp @else @php $class = "btn btn-success"; $trans = 'On'; @endphp @endif
                        <td>
                            <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/ratings/activateComments') }}" method="post" id="activate{{ $Comment->id }}">
                                @csrf
                                <input type="hidden" name="id" value="{{$Comment->id}}">
                                <button class="{{ $class }}">{{ trans_db('dashboard.'. $trans) }}</button>
                            </form>
                        </td>
                        <td><h3>{{ $Comment->order_id }}</h3></td>
                        <td><h3>{{ $Comment->notes }}</h3></td>
                        <td>
                            <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/ratings/delete') }}" method="post" id="{{ $Comment->id }}" onsubmit="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')">
                                @csrf
                                <input type="hidden" name="id" value="{{$Comment->id}}">
                                <button class="btn btn-danger">{{ trans_db('dashboard.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                
            </table>
            {{ $Comments->links() }}
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