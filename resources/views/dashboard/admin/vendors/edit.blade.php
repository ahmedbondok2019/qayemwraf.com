@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    {!! Html::style('admin/app-assets/vendors/css/forms/select/select2.min.css') !!}
    {!! Html::style('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}

    {!! Html::style('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') !!}
    {!! Html::style('admin/app-assets/css/plugins/forms/form-validation.css') !!}
    {!! Html::style('admin/app-assets/css/pages/app-user.css') !!}

@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="app-user-edit">
                    <div class="card">
                        <div class="card-body">
{{--                            <ul class="nav nav-pills" role="tablist">--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">--}}
{{--                                        <i data-feather="user"></i><span class="d-none d-sm-block">vendors</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
                            <div class="tab-content">

                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                                <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/updateVendor') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $Details->id }}">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Store Name') }}</label>
                                                    <input type="text" class="form-control" value="{{$Details->name}}" name="name" id="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="full_name">{{ trans_db('dashboard.vendor Name') }}</label>
                                                    <input type="text" class="form-control" value="{{$Details->full_name}}" name="full_name" id="full_name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Phone') }}</label>
                                                    <input type="text" class="form-control" value="{{$Details->phone}}" name="phone" id="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Email') }}</label>
                                                    <input type="text" class="form-control" value="{{$Details->email}}" name="email" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.website') }}</label>
                                                    <input type="text" class="form-control" value="{{ $Details->website }}" name="website" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.address') }}</label>
                                                    <input type="text" class="form-control" value="{{ $Details->address }}" name="address" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans_db("dashboard.area") }} *</label>
                                                    <select class="form-control" name="area_id" id="select_area">
                                                        <option>{{ trans_db("dashboard.Choose") }}</option>
                                                        @php
                                                        $areas = \App\Models\Area::whereHas('translations')->get();
                                                        @endphp
                                                        @foreach ($areas as $area)
                                                        <option value="{{ $area->id }}" {{ $Details->area_id == $area->id ? "selected" : ""}}>{{ $area->translations()->first()->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans_db("dashboard.city") }} *</label>
                                                    <select class="form-control" name="city_id" id="select_city">
                                                        <option>{{ trans_db("dashboard.Choose") }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.bank_name') }}</label>
                                                    <input type="text" class="form-control" value="{{ $Details->bank_name }}" name="bank_name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.bank_iban') }}</label>
                                                    <input type="text" class="form-control" value="{{ $Details->bank_iban }}" name="bank_iban" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">{{ trans_db('dashboard.profit_group') }}</label>
                                                    <select class="form-control" id="profit_group" name="profit_group">
                                                        <option value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        @foreach($profit_group as $profit)
                                                            <option value="{{ $profit->id }}" {{ $Details->profit_group == $profit->id ? "selected" : "" }}>{{ $profit->title }} - ({{ $profit->value }}) - {{ $profit->type == 1 ? trans_db('dashboard.percentage') : trans_db('dashboard.fixed') }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">{{ trans_db('dashboard.Status') }}</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" {{ $Details->status == 1 ? "selected" : "" }}>{{ trans_db('dashboard.active') }}</option>
                                                        <option value="0" {{ $Details->status == 0 ? "selected" : "" }}>{{ trans_db('dashboard.Under review') }}</option>
                                                        <option value="2" {{ $Details->status == 2 ? "selected" : "" }}>{{ trans_db('dashboard.refused') }}</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">{{ trans_db('dashboard.Account Type') }}</label>
                                                    @if ($Details->account_type == 1)
                                                        <input type="hidden" name="account_type" value="{{ trans_db('dashboard.Private') }}">
                                                        <input type="text" name="account_type" value="{{ trans_db('dashboard.Private') }}" class="form-control @error('email') is-invalid @enderror">
                                                    @else
                                                        <input type="hidden" name="account_type" value="{{ trans_db('dashboard.Company') }}">
                                                        <input type="text" name="account_type" value="{{ trans_db('dashboard.Company') }}" class="form-control @error('email') is-invalid @enderror" disabled>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="commerical_license_status" id="inlineCheckbox1" value="1" @if ($Details->commerical_license_status == 1) checked @endif>
                                                                    <label class="form-check-label" for="inlineCheckbox1">{{ trans_db('dashboard.commerical_license') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="tax_license_status" id="inlineCheckbox2" value="1" @if ($Details->tax_license_status == 1) checked @endif>
                                                                    <label class="form-check-label" for="inlineCheckbox2">{{ trans_db('dashboard.tax_license') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="identity_card1_status" id="inlineCheckbox3" value="1" @if ($Details->identity_card1_status == 1) checked @endif>
                                                                    <label class="form-check-label" for="inlineCheckbox3">{{ trans_db('dashboard.identity_card') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="identity_card2_status" id="inlineCheckbox4" value="1" @if ($Details->identity_card2_status == 1) checked @endif>
                                                                    <label class="form-check-label" for="inlineCheckbox4">{{ trans_db('dashboard.identity_card2') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="address_prove_status" id="inlineCheckbox5" value="1" @if ($Details->address_prove_status == 1) checked @endif>
                                                                    <label class="form-check-label" for="inlineCheckbox5">{{ trans_db('dashboard.address_prove') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{ trans_db('dashboard.contract') }}</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="customFile21" name="contract">
                                                                            <label class="custom-file-label" for="customFile21" style="padding-right: 83px;">{{ trans_db('dashboard.contract') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    @if ($Details->contract != null)
                                                                        {{-- <a class="btn btn-md btn-danger" href="{{ asset('website/uploads/contract/' . $Details->contract) }}">{{ trans_db('dashboard.contract') }}</a> --}}
                                                                        <a class="btn btn-md btn-danger" href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/download/' . $Details->id) }}">{{ trans_db('dashboard.contract') }}</a>
                                                                    @endif 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="carousel-example-caption" class="carousel slide" data-bs-ride="carousel">
                                                            <ol class="carousel-indicators">
                                                                <li data-bs-target="#carousel-example-caption" data-bs-slide-to="0" class="active"></li>
                                                                <li data-bs-target="#carousel-example-caption" data-bs-slide-to="1"></li>
                                                                <li data-bs-target="#carousel-example-caption" data-bs-slide-to="2"></li>
                                                                <li data-bs-target="#carousel-example-caption" data-bs-slide-to="3"></li>
                                                                <li data-bs-target="#carousel-example-caption" data-bs-slide-to="4"></li>
                                                            </ol>
                                                            <div class="carousel-inner">
                                                                <div class="carousel-item active">
                                                                    <img class="img-fluid" src="
                                                                        @if ($Details->commerical_license != null)
                                                                            {{ asset('website/images/commerical_license/' . $Details->commerical_license) }}
                                                                        @else
                                                                            {{ asset('website/images/no-image.jpg') }}
                                                                        @endif 
                                                                        " alt="First slide" />
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <h3 class="text-white" style="background-color: #ab95d8;">{{ trans_db('dashboard.commerical_license') }}</h3>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <img class="img-fluid" src="
                                                                        @if ($Details->tax_license != null)
                                                                            {{ asset('website/images/tax_license/' . $Details->tax_license) }}
                                                                        @else
                                                                            {{ asset('website/images/no-image.jpg') }}
                                                                        @endif 
                                                                        " alt="First slide" />
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <h3 class="text-white" style="background-color: #ab95d8;">{{ trans_db('dashboard.tax_license') }}</h3>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <img class="img-fluid" src="
                                                                        @if ($Details->identity_card1 != null)
                                                                            {{ asset('website/images/identity_card1/' . $Details->identity_card1) }}
                                                                        @else
                                                                            {{ asset('website/images/no-image.jpg') }}
                                                                        @endif 
                                                                        " alt="First slide" />
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <h3 class="text-white" style="background-color: #ab95d8;">{{ trans_db('dashboard.identity_card') }}</h3>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <img class="img-fluid" src="
                                                                        @if ($Details->identity_card2 != null)
                                                                            {{ asset('website/images/identity_card2/' . $Details->identity_card2) }}
                                                                        @else
                                                                            {{ asset('website/images/no-image.jpg') }}
                                                                        @endif 
                                                                        " alt="First slide" />
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <h3 class="text-white" style="background-color: #ab95d8;">{{ trans_db('dashboard.identity_card2') }}</h3>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <img class="img-fluid" src="
                                                                        @if ($Details->address_prove != null)
                                                                            {{ asset('website/images/address_prove/' . $Details->address_prove) }}
                                                                        @else
                                                                            {{ asset('website/images/no-image.jpg') }}
                                                                        @endif 
                                                                        " alt="First slide" />
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <h3 class="text-white" style="background-color: #ab95d8;">{{ trans_db('dashboard.address_prove') }}</h3>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                            <a class="carousel-control-prev" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="basic-icon-default-uname">{{ trans_db('website.password') }}</label>
                                                    <input type="password" id="basic-icon-default-uname" class="form-control dt-uname" placeholder="********" aria-label="******" aria-describedby="basic-icon-default-uname2" name="password" />
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 vendor_image">
                                                        <div class="form-group">
                                                            <label for="">{{ trans_db('dashboard.Image') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile" name="image[]">
                                                                <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 images">

                                                    </div>
                                                </div>
                                            </div> --}}

                                            {{-- <br>

                                            <div class="col-md-12">
                                            <div class="row">
                                                @foreach($Details->VendorImages as $image)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                        <a onclick="return confirm('<?php //echo 'Are You Sure To Delete ?'; ?>')" href="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/delete/image/' . $image->id) }}">
                                                            <svg data-v-4a00de13="" xmlns="http://www.w3.org/2000/svg" width="14px" height="14px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline data-v-4a00de13="" points="3 6 5 6 21 6"></polyline><path data-v-4a00de13="" d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                        </a>
                                                        <img src="{{ asset('website/images/users') }}/{{ $image->image }}" alt="" style="height: 200px;width:auto;">
                                                        </div>
                                                    </div>




                                                @endforeach
                                            </div>
                                            </div> --}}

                                            {{-- <div class="col-md-12">
                                                <a class="btn btn-success add-image">{{ trans_db('dashboard.new_image') }} </a>
                                            </div> --}}


                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">
                                                    {{ trans_db('dashboard.Save') }}
                                                </button>
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
    @include('dashboard.admin.layouts.script')

    <script>

        function removeNewImage(e) {
            $(e).closest('div.images').remove();
        }

        $('.add-image').on('click' , function () {
            var count = document.getElementsByClassName('news_images_create').length;
            var new_image = '<div class="row news_images_create">\n' +
                '<div class="col-md-6 vendor_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }}</label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="image[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.Image") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-4">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeRenewImages(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
                '</div>\n' +
                '</div>\n' +
            '</div>';

            $('.images').append(new_image);
        });

        function removeRenewImages(e) {
            $(e).closest('div.news_images_create').remove();
        }

        var id = $("select[name=area_id]").val();
        var selected = "{{ $Details->city_id }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/getAllCity') }}",
            method:"POST",
            data:{id:id,selected:selected},
            success:function(data){
            $('#select_city').html(data.data);
            }
        });

        $('#select_area').on('change' ,function(){
            var id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/getAllCity') }}",
                method:"POST",
                data:{id:id},
                success:function(data){
                    $('#select_city').html(data.data);
                }
            });
        });

    </script>
@endsection
