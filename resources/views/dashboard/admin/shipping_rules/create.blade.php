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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Shipping Rules') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.shipping_rules.index') }}">{{ trans_db('dashboard.Shipping Rules') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Create') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ trans_db('dashboard.Create') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.shipping_rules.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            
                                            <!-- Basic Info Header -->
                                            <div class="col-12 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="info" class="mr-50"></i> {{ trans_db('dashboard.Basic Information') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <!-- Names -->
                                            @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="name_{{ $localeCode }}" class="font-weight-bold">{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                                            </div>
                                                            <input type="text" id="name_{{ $localeCode }}"
                                                                class="form-control" name="name_{{ $localeCode }}"
                                                                value="{{ old('name_' . $localeCode) }}" required placeholder="{{ trans_db('dashboard.Name') }} ({{ $properties['native'] }})" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Country -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="country_id" class="font-weight-bold">{{ trans_db('dashboard.Country') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="globe"></i></span>
                                                        </div>
                                                        <select name="country_id" id="country_id" class="form-control" required>
                                                            <option value="" selected disabled>{{ trans_db('dashboard.Choose Country') }}</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="is_active" class="font-weight-bold">{{ trans_db('dashboard.Status') }}</label>
                                                    <div class="custom-control custom-switch custom-switch-success">
                                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                                            name="is_active" checked />
                                                        <label class="custom-control-label" for="is_active">
                                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Shipping Rates Header -->
                                            <div class="col-12 mt-3 mb-2">
                                                <h5 class="text-primary font-weight-bold">
                                                    <i data-feather="dollar-sign" class="mr-50"></i> {{ trans_db('dashboard.Shipping Rates') }}
                                                </h5>
                                                <hr />
                                            </div>

                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-striped text-center">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>{{ trans_db('dashboard.Governorate') }}</th>
                                                                <th>{{ trans_db('dashboard.Value') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="governorates-body">
                                                            <tr>
                                                                <td colspan="3" class="text-center">
                                                                    <i data-feather="alert-circle" class="mr-50"></i>
                                                                    {{ trans_db('dashboard.Please select a country first') }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 text-right">
                                                <button type="reset" class="btn btn-outline-secondary mr-1">{{ trans_db('dashboard.Reset') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Submit') }}</button>
                                            </div>
                                        </div>
                                    </form>
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
    $('#country_id').change(function() {
        var countryId = $(this).val();
        if(countryId) {
            $.ajax({
                url: "{{ route('admin.shipping_rules.get_governorates') }}",
                type: "GET",
                data: {
                    country_id: countryId
                },
                success: function(response) {
                    if(response.html) {
                        $('#governorates-body').html(response.html);
                    } else {
                         $('#governorates-body').html('<tr><td colspan="3" class="text-center">{{ trans_db("dashboard.No governorates found") }}</td></tr>');
                    }
                }
            });
        }
    });
</script>
@endsection
