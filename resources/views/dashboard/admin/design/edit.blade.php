@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>
    @include('dashboard.admin.component.page_header' , ['translation' => trans_db('dashboard.design')])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">

                        @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/design/update') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf


                            <div class="col-md-12">
                                <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
                                    <div class="row">

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div class="col-lg-6">
                                                <div class="form-group {{ $errors->has('design') ? 'has-error' : '' }}">
                                                    <label for="">{{ trans_db('dashboard.design') }}</label>
                                                    <select name="design" id="design" class="form-control select2" style="width: 100%;">
                                                        <option selected value="">{{ trans_db('dashboard.Choose') }}</option>
                                                        @foreach ($designs as $design)
                                                            <option value="{{ $design->id }}" {{ $design->active == 1 ? "selected" : "" }}>{{ $design->DesignTranslations->first()->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">{{ $errors->first('design') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div id="pages"></div>
                                        </div>

                                        <hr/>

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div id="samples"></div>
                                        </div>

                                        <hr/>

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div id="options"></div>
                                        </div>

                                        <hr/>

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div id="images"></div>
                                        </div>

                                        <hr/>

                                        <div class="col-lg-12" style="text-align: -webkit-center;">
                                            <div id="video"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var design_id = $("select[name=design]").val();

            $.ajax({
                type:'post',
                url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/getPages') !!}',
                data:{'design_id':design_id},
                success:function(data) {
                    // console.log("success");
                    $('#pages').html(data.html);
                },
                fail:function(xhr, status, error) {}
            });

            $(document).on('change','#design',function(){
                var design_id = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/getPages') !!}',
                    data:{'design_id':design_id},
                    success:function(data) {
                        // console.log("success");
                        $('#pages').html(data.html);
                    },
                    fail:function(xhr, status, error) {}
                });
            });

            $(document).on('change','#page',function(){
                var page = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/getSamples') !!}',
                    data:{'page':page},
                    success:function(data) {
                        // console.log("success");
                        $('#samples').html(data.html);
                        $('#options').html(data.options);
                        if(data.slug === 'home'){
                            $('#images').html(data.images);
                            $('#video').html(data.video);
                        }
                    },
                    fail:function(xhr, status, error) {}
                });
            });

            $(document).on('change','#sample',function(){
                var sample = $(this).val();

                $.ajax({
                    type:'post',
                    url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/getOptions') !!}',
                    data:{'sample':sample},
                    success:function(data) {
                        // console.log("success");
                        $('#options').html(data.options);
                        if(data.slug === 'home'){
                            $('#images').html(data.images);
                            $('#video').html(data.video);
                        }
                    },
                    fail:function(xhr, status, error) {}
                });
            });

            $(document).on('change','.options',function(){
                if($(this).attr('data-title') === "الهيدر"){
                    var option = $(this).val();

                    if ($(this).is(':checked')) {
                        var currentStatus = true;
                    }else {
                        var currentStatus = false;
                    }

                    $.ajax({
                        type:'post',
                        url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/getImages') !!}',
                        data:{'option':option, 'currentStatus': currentStatus},
                        success:function(data) {
                            if (data['currentStatus'] === "true") {
                                console.log(data['currentStatus']);
                                $('#images').html(data.html);
                            }else{
                                $('#images').empty();
                            }
                        },
                        fail:function(xhr, status, error) {}
                    });
                }

            });
        });
    </script>


@endsection
