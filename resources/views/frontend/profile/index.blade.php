@extends('frontend.layouts.master')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            <!-- Sidebar -->
            @include('frontend.profile.sidebar')

            <!-- Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h3>{{ trans_db('frontend.Profile Settings') }}</h3>
                    <p>{{ trans_db('frontend.Manage your personal information') }}</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('frontend.user.profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ trans_db('frontend.Name') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-user"></i>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ trans_db('frontend.Email Address') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">{{ trans_db('frontend.Phone') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country_id">{{ trans_db('frontend.Country') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-globe"></i>
                                    <select id="country_id" name="country_id" class="custom-select" required>
                                        <option value="">{{ trans_db('frontend.Select Country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->translation->name ?? $country->translations->first()->name ?? 'Country' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('country_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                            {{ trans_db('frontend.Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('frontend.profile.partials.styles')
@endsection
