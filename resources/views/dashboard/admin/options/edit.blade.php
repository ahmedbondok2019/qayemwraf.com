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
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Options') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.options.index') }}">{{ trans_db('dashboard.Options') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Edit') }}
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
                                    <h4 class="card-title">{{ trans_db('dashboard.Edit') }}</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" action="{{ route('admin.options.update', $option->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
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
                                                        <label for="name_{{ $localeCode }}" class="font-weight-bold">{{ trans_db('dashboard.Option Name') }} ({{ $properties['native'] }})</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                                            </div>
                                                            <input type="text" id="name_{{ $localeCode }}"
                                                                class="form-control" name="name_{{ $localeCode }}"
                                                                value="{{ old('name_' . $localeCode, $option->translations->where('locale', $localeCode)->first()->name ?? '') }}" required placeholder="{{ trans_db('dashboard.Option Name') }} ({{ $properties['native'] }})" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Option Type -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="type" class="font-weight-bold">{{ trans_db('dashboard.Option Type') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i data-feather="settings"></i></span>
                                                        </div>
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="single" {{ $option->type == 'single' ? 'selected' : '' }}>{{ trans_db('dashboard.Single Selection') }}</option>
                                                            <option value="multiple" {{ $option->type == 'multiple' ? 'selected' : '' }}>{{ trans_db('dashboard.Multiple Selection') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 mb-1">
                                                <hr>
                                                <div class="d-flex justify-content-between align-items-center">
                                                     <h5 class="text-primary font-weight-bold mb-0">
                                                        <i data-feather="list" class="mr-50"></i> {{ trans_db('dashboard.Option Values') }}
                                                     </h5>
                                                     <button type="button" class="btn btn-success btn-sm" id="add-value">
                                                        <i data-feather="plus"></i> {{ trans_db('dashboard.Add Value') }}
                                                     </button>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div id="values-wrapper">
                                                    @foreach($option->values as $index => $value)
                                                        <div class="card bg-white border shadow-none p-2 mb-2 value-row" id="row-{{ $index }}">
                                                            <input type="hidden" name="values[{{$index}}][id]" value="{{ $value->id }}">
                                                            <div class="row align-items-end">
                                                                 @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-1">
                                                                            <label class="font-weight-bold">{{ trans_db('dashboard.Value') }} ({{ $properties['native'] }})</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                                                                </div>
                                                                                <input type="text" name="values[{{$index}}][{{ $localeCode }}]" class="form-control" 
                                                                                value="{{ $value->translations->where('locale', $localeCode)->first()->value ?? '' }}" required placeholder="{{ trans_db('dashboard.Value') }}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <div class="col-md-3">
                                                                     <div class="form-group mb-1">
                                                                        <label class="font-weight-bold">{{ trans_db('dashboard.Color') }}</label>
                                                                        <div class="input-group">
                                                                            <input type="color" name="values[{{$index}}][color]" class="form-control p-1" style="height:38px" value="{{ $value->color_code ?? '#000000' }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <div class="form-group mb-1">
                                                                        <label>&nbsp;</label>
                                                                        <button type="button" class="btn btn-outline-danger btn-block" onclick="removeRow({{ $index }})">
                                                                            <i data-feather="trash-2"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
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

@push('js')
<script>
    $(document).ready(function() {
        let valueIndex = {{ $option->values->count() }};

        function addValueRow() {
            let html = `
                <div class="card bg-white border shadow-none p-2 mb-2 value-row" id="row-${valueIndex}">
                    <div class="row align-items-end">
                         @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <div class="col-md-4">
                                <div class="form-group mb-1">
                                    <label class="font-weight-bold">{{ trans_db('dashboard.Value') }} ({{ $properties['native'] }})</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ strtoupper($localeCode) }}</span>
                                        </div>
                                        <input type="text" name="values[${valueIndex}][{{ $localeCode }}]" class="form-control" required placeholder="{{ trans_db('dashboard.Value') }}" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-3">
                             <div class="form-group mb-1">
                                <label class="font-weight-bold">{{ trans_db('dashboard.Color') }}</label>
                                <div class="input-group">
                                    <input type="color" name="values[${valueIndex}][color]" class="form-control p-1" style="height:38px" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group mb-1">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger btn-block" onclick="removeRow(${valueIndex})">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#values-wrapper').append(html);
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
            valueIndex++;
        }

        $('#add-value').click(function() {
            addValueRow();
        });
    });

    function removeRow(index) {
        $(`#row-${index}`).remove();
    }
</script>
@endpush
