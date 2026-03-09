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
                        <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Edit User') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ trans_db('dashboard.Users') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="address-repeater">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Basic Information') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">{{ trans_db('dashboard.Name') }}</label>
                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email">{{ trans_db('dashboard.Email') }}</label>
                                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone">{{ trans_db('dashboard.Phone') }}</label>
                                            <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password">{{ trans_db('dashboard.Password') }}</label>
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            <small class="text-muted">{{ trans_db('dashboard.leave blank to keep current') }}</small>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">{{ trans_db('dashboard.Confirm Password') }}</label>
                                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">{{ trans_db('dashboard.Addresses') }}</h4>
                                <button type="button" class="btn btn-primary btn-sm" data-repeater-create>
                                    <i data-feather="plus" class="mr-25"></i>
                                    <span>{{ trans_db('dashboard.Add Address') }}</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div data-repeater-list="addresses">
                                    @if(count($addresses) > 0)
                                        @foreach($addresses as $index => $address)
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end mb-1 border-bottom pb-1">
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label>{{ trans_db('dashboard.Country') }}</label>
                                                            <select name="country_id" class="form-control country-select">
                                                                <option value="">{{ trans_db('dashboard.Select Country') }}</option>
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->id }}" {{ $address->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label>{{ trans_db('dashboard.Governorate') }}</label>
                                                            <select name="governorate_id" class="form-control governorate-select">
                                                                <option value="">{{ trans_db('dashboard.Select Governorate') }}</option>
                                                                @if(isset($existingGovernorates[$address->country_id]))
                                                                    @foreach($existingGovernorates[$address->country_id] as $gov)
                                                                        <option value="{{ $gov->id }}" {{ $address->governorate_id == $gov->id ? 'selected' : '' }}>{{ $gov->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label>{{ trans_db('dashboard.City') }}</label>
                                                            <select name="city_id" class="form-control city-select">
                                                                <option value="">{{ trans_db('dashboard.Select City') }}</option>
                                                                @if(isset($existingCities[$address->governorate_id]))
                                                                    @foreach($existingCities[$address->governorate_id] as $city)
                                                                        <option value="{{ $city->id }}" {{ $address->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-12">
                                                        <div class="form-group">
                                                            <label class="d-block">{{ trans_db('dashboard.Main Address') }}</label>
                                                            <div class="custom-control custom-switch custom-switch-success">
                                                                <input type="checkbox" class="custom-control-input is-main-switch" name="is_main" id="is_main_{{ $index }}" {{ $address->is_main ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="is_main_{{ $index }}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-12 text-right">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-outline-danger btn-sm p-50" data-repeater-delete>
                                                                <i data-feather="trash-2"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>{{ trans_db('dashboard.Address') }}</label>
                                                            <textarea name="address" class="form-control" rows="2">{{ $address->address }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item>
                                            <div class="row d-flex align-items-end mb-1 border-bottom pb-1">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label>{{ trans_db('dashboard.Country') }}</label>
                                                        <select name="country_id" class="form-control country-select">
                                                            <option value="">{{ trans_db('dashboard.Select Country') }}</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label>{{ trans_db('dashboard.Governorate') }}</label>
                                                        <select name="governorate_id" class="form-control governorate-select">
                                                            <option value="">{{ trans_db('dashboard.Select Governorate') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label>{{ trans_db('dashboard.City') }}</label>
                                                        <select name="city_id" class="form-control city-select">
                                                            <option value="">{{ trans_db('dashboard.Select City') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <div class="form-group">
                                                        <label class="d-block">{{ trans_db('dashboard.Main Address') }}</label>
                                                        <div class="custom-control custom-switch custom-switch-success">
                                                            <input type="checkbox" class="custom-control-input is-main-switch" name="is_main" id="is_main_0">
                                                            <label class="custom-control-label" for="is_main_0"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col-12 text-right">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-outline-danger btn-sm p-50" data-repeater-delete>
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{ trans_db('dashboard.Address') }}</label>
                                                        <textarea name="address" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ trans_db('dashboard.Status & Image') }}</h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="form-group">
                                    <label class="d-block">{{ trans_db('dashboard.Status') }}</label>
                                    <div class="custom-control custom-switch custom-switch-primary">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status" {{ $user->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">
                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <label for="image">{{ trans_db('dashboard.Image') }}</label>
                                    @if($user->image)
                                        <div class="mb-1">
                                            <img src="{{ asset($user->image) }}" alt="User Image" class="rounded img-thumbnail" style="max-width: 150px;">
                                        </div>
                                    @endif
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                        <label class="custom-file-label" for="image">{{ trans_db('dashboard.Change Image') }}</label>
                                    </div>
                                    <img id="image-preview" src="#" alt="Preview" style="max-width: 100%; display: none;" class="rounded img-thumbnail mt-1">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mt-2">{{ trans_db('dashboard.Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('admin/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#image-preview').attr('src', event.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        });

        // Repeater initialization
        var addressRepeater = $('.address-repeater').repeater({
            show: function() {
                $(this).slideDown();
                if (feather) {
                    feather.replace();
                }
                // Unique IDs for checkboxes to work correctly with labels
                var index = $(this).closest('[data-repeater-list]').find('[data-repeater-item]').length - 1;
                $(this).find('.is-main-switch').attr('id', 'is_main_' + index);
                $(this).find('.is-main-switch').next('label').attr('for', 'is_main_' + index);
                $(this).find('.is-main-switch').prop('checked', false); // New items are not main by default
            },
            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },
            isFirstItemUndeletable: false
        });

        // Ensure only one "Main Address" is checked
        $(document).on('change', '.is-main-switch', function() {
            if ($(this).is(':checked')) {
                $('.is-main-switch').not(this).prop('checked', false);
            }
        });

        // Dynamic Governorates for Repeater Items
        $(document).on('change', '.country-select', function() {
            var country_id = $(this).val();
            var $row = $(this).closest('[data-repeater-item]');
            var $govSelect = $row.find('.governorate-select');
            var $citySelect = $row.find('.city-select');
            
            $govSelect.empty().append('<option value="">{{ trans_db("dashboard.Select Governorate") }}</option>');
            $citySelect.empty().append('<option value="">{{ trans_db("dashboard.Select City") }}</option>');
            
            if (country_id) {
                $.ajax({
                    url: "{{ route('admin.users.get_governorates', '') }}/" + country_id,
                    type: "GET",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $govSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });

        // Dynamic Cities for Repeater Items
        $(document).on('change', '.governorate-select', function() {
            var governorate_id = $(this).val();
            var $row = $(this).closest('[data-repeater-item]');
            var $citySelect = $row.find('.city-select');
            
            $citySelect.empty().append('<option value="">{{ trans_db("dashboard.Select City") }}</option>');
            
            if (governorate_id) {
                $.ajax({
                    url: "{{ route('admin.users.get_cities', '') }}/" + governorate_id,
                    type: "GET",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
