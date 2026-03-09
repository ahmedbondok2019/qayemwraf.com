@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <section class="app-user-edit">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ trans_db('dashboard.Edit Currency') }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.currencies.update', $currency->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">{{ trans_db('dashboard.code') }} ({{ trans_db('dashboard.example') }}: USD)</label>
                                        <input type="text" name="code" class="form-control" value="{{ old('code', $currency->code) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">{{ trans_db('dashboard.exchange_rate') }}</label>
                                        <input type="number" step="0.00000001" name="exchange_rate" class="form-control" value="{{ old('exchange_rate', $currency->exchange_rate) }}" required>
                                    </div>

                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">{{ trans_db('dashboard.Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ old('status', $currency->status) == 1 ? 'selected' : '' }}>{{ trans_db('dashboard.active') }}</option>
                                            <option value="0" {{ old('status', $currency->status) == 0 ? 'selected' : '' }}>{{ trans_db('dashboard.inactive') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">{{ trans_db('dashboard.default') }}</label>
                                        <select name="is_default" class="form-control">
                                            <option value="0" {{ old('is_default', $currency->is_default) == 0 ? 'selected' : '' }}>{{ trans_db('dashboard.no') }}</option>
                                            <option value="1" {{ old('is_default', $currency->is_default) == 1 ? 'selected' : '' }}>{{ trans_db('dashboard.yes') }}</option>
                                        </select>
                                    </div>

                                    <hr class="my-2">

                                    {{-- Localized Fields --}}
                                    <div class="col-12">
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach(config('laravellocalization.supportedLocales') as $locale => $props)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $locale }}-tab" data-toggle="tab" href="#{{ $locale }}" role="tab" aria-controls="{{ $locale }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                        {{ $props['native'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach(config('laravellocalization.supportedLocales') as $locale => $props)
                                                @php
                                                    $translation = $currency->translations->where('locale', $locale)->first();
                                                @endphp
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-1">
                                                            <label class="form-label">{{ trans_db('dashboard.name') }} ({{ $locale }})</label>
                                                            <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name', $translation->name ?? '') }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-1">
                                                            <label class="form-label">{{ trans_db('dashboard.symbol') }} ({{ $locale }})</label>
                                                            <input type="text" name="{{ $locale }}[symbol]" class="form-control" value="{{ old($locale . '.symbol', $translation->symbol ?? '') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                                        <a href="{{ route('admin.currencies.index') }}" class="btn btn-outline-secondary">{{ trans_db('dashboard.Cancel') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')
@endsection
