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
{{--                                        <i data-feather="user"></i><span class="d-none d-sm-block">{{ trans_db('dashboard.Vendors') }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
                            <div class="tab-content">

                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <!-- Account Tab starts -->
                                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                    <form class="form-validate" role="form" action="{{ \LaravelLocalization::localizeUrl('admin-2023/vendors/createVendor') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ trans_db('dashboard.Store Name') }}</label>
                                                    <input type="text" class="form-control" placeholder="{{ trans_db('dashboard.Store Name') }}" value="" name="name" id="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="full_name">{{ trans_db('dashboard.vendor Name') }}</label>
                                                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="{{ trans_db('dashboard.Name') }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Phone') }}</label>
                                                    <input type="text" class="form-control" placeholder="0123456789" value="" name="phone" id="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.website') }}</label>
                                                    <input type="text" class="form-control" placeholder="https://example.com" value="" name="website" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.address') }}</label>
                                                    <input type="text" class="form-control" placeholder="12 mohamed st, ..." value="" name="address" />
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
                                                      <option value="{{ $area->id }}">{{ $area->translations()->first()->title }}</option>
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
                                                    <input type="text" class="form-control" placeholder="bank ..." value="" name="bank_name" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.bank_iban') }}</label>
                                                    <input type="text" class="form-control" placeholder="123456789577" value="" name="bank_iban" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">{{ trans_db('dashboard.Email') }}</label>
                                                    <input type="text" class="form-control" placeholder="example@gmail.com" value="" name="email" />
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">{{ trans_db('dashboard.profit_group') }}</label>
                                                    <select class="form-control" id="profit_group" name="profit_group">
                                                        <option value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        @foreach($profit_group as $profit)
                                                            <option value="{{ $profit->id }}">{{ $profit->title }} - ({{ $profit->value }}) - {{ $profit->type == 1 ? trans_db('dashboard.percentage') : trans_db('dashboard.fixed') }}</option>
                                                        @endforeach
                                                    </select>
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
                                            </div>

                                            <div class="col-md-12">
                                                <a class="btn btn-success add-image">{{ trans_db('dashboard.new_image') }} </a>
                                            </div> --}}


                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">
                                                    {{ trans_db('dashboard.Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
                                </div>
                                <!-- Account Tab ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

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
            var count = document.getElementsByClassName('news_vendor_create').length;
            var new_image = '<div class="row news_vendor_create">\n' +
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
            $(e).closest('div.news_vendor_create').remove();
        }

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
