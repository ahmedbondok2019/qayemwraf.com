@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
    {!! Html::style('admin/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') !!}

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
                        <div class="tab-content">

                        @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                        <!-- Account Tab starts -->
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/options/store') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.Option Name') }}</label>
                                                {!! Form::text('title', old('title'), ['placeholder'=> trans_db('dashboard.Option Name'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                                <label for="">{{ trans_db('dashboard.type') }}</label>
                                                <select name="type" class="invoiceto form-control select2-hidden-accessible" style="width: 100%;">
                                                    <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                    <option value="1">{{ trans_db('dashboard.dropdown')}}</option>
                                                    <option value="2">{{ trans_db('dashboard.checkbox')}}</option>
                                                    <option value="3">{{ trans_db('dashboard.radio')}}</option>
                                                </select>
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <hr>

                                    <div class="row m-2">
                                        <div class="col-lg-12">
                                            <h2>{{ trans_db("dashboard.Add New Item") }}</h2>
                                        </div>
                                        {{-- <div class="input-group">
                                            <input type="text" class="touchspin" value="50" data-bts-step="0.5" data-bts-decimals="2" />
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="">{{ trans_db('dashboard.Option Item') }}</label>
                                                        <input type="text" class="form-control" name="optionItem[]" placeholder="{{ trans_db('dashboard.Option Item') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <div class="option-items"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <a class="btn btn-success add-item">{{ trans_db('dashboard.Add New Option') }} </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </section>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
</div>
<!-- /.content -->
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    {!! Html::script('admin/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-number-input.js') !!}
    {!! Html::script('admin/plugins/select2/js/select2.full.min.js') !!}

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });

    </script>

    <script>

        function removeNewLink(e) {
            $(e).closest('div.options').remove();
        }

        $('.add-item').on('click' , function () {
            var count = document.getElementsByClassName('news_option_items').length;
            var new_link = '<div class="row news_option_items">\n' +
                '<div class="col-md-10">\n' +
                '<label for="">{{ trans_db("dashboard.Option Item") }}</label>\n' +
                '<input type="text" class="form-control" name="optionItem[]" placeholder="{{ trans_db("dashboard.Option Item") }}">\n' +
                '</div>\n' +
                '<div class="col-md-2 pt-2">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeOptionItems(this)"><i data-feather="trash-2"></i></a>\n' +
                '</div>\n' +
                '</div>\n' +
                // '<div class="input-group input-group-lg">\n' +
                //     '<input type="text" class="touchspin" value="50" data-bts-step="0.5" data-bts-decimals="2" data-bts-button-down-class="btn btn-warning" data-bts-button-up-class="btn btn-warning" name="touch'+count+'"/>\n' +
                // '</div>\n' +
                '</div>';

            $('.option-items').append(new_link);
            feather.replace();

            tp(count);
        });

        function tp(index) {
            $("input[name='touch" + index + "']").TouchSpin();
        }

        function removeOptionItems(e) {
            $(e).closest('div.news_option_items').remove();
        }

    </script>
@endsection
