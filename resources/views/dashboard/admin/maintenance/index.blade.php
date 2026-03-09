@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
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
                                <form class="form-validate" role="form"  action="{{ \LaravelLocalization::localizeUrl('admin-2023/maintenance/update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
        
                                    @include('dashboard.admin.component.page_error' , ['errors' => $errors])
        
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group {{ $errors->has('site_status') ? 'has-error' : '' }}">
                                                        <label for="">{{ trans_db('dashboard.Status') }}</label>
                                                        <select name="site_status" class="form-control" style="width: 100%;">
                                                            <option value="1" {{ $site_status->site_status == 1 ? "selected" : "" }}>{{ trans_db('dashboard.Site active') }}</option>
                                                            <option value="0" {{ $site_status->site_status == 0 ? "selected" : "" }}>{{ trans_db('dashboard.Site NotActive') }}</option>
                                                        </select>
                                                        <span class="text-danger">{{ $errors->first('site_status') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary"> {{ trans_db('dashboard.Save') }} </button>
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
    {!! Html::script('admin/app-assets/vendors/js/forms/select/select2.full.min.js') !!}
    {!! Html::script('admin/app-assets/js/scripts/forms/form-select2.js') !!}

    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <script>
        // $('#selected_newsletter_position').on('select2:select', function (e) {
        //     var old_value = $("input[name=newsletter_position]").val();
        //     var new_value = $(this).val();
        //     $("input[name=newsletter_position]").val(old_value + ',' + new_value);
        // });

        $('#selected_newsletter_position').on('select2:unselect', function (e) {
            $("input[name=newsletter_position]").val($(this).val());
            $(this).trigger('change');
        });

        // var data = [
        //     {
        //         id: 1,
        //         text: "{{ trans_db('dashboard.home_web_top') }}"
        //     },
        //     {
        //         id: 2,
        //         text: "{{ trans_db('dashboard.home_mobile') }}"
        //     }
        // ];

        // $("#selected_newsletter_position").select2({
        // data: data
        // })
    </script>

    <script>
        $(document).ready(function(){

            var $modal = $('#modal');
            var image = document.getElementById('sample_image');
            var cropper;

            $('#customFile').change(function(event){
                var files = event.target.files;
                var done = function(url){
                    image.src = url;
                    $modal.modal({backdrop: 'static', keyboard: false}, 'show');
                };

                if(files && files.length > 0)
                {
                    reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1.50,
                    viewMode: 1,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:380,
                    height:290
                });

                canvas.toBlob(function(blob){
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        var base64data = reader.result;

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url:'{{ \LaravelLocalization::localizeUrl('admin-2023/blog/cropSlider') }}',
                            method:'POST',
                            data:{image:base64data},
                            success:function(data)
                            {
                                console.log(data);
                                $modal.modal('hide');
                                $('#uploaded_image').attr('src', data);
                                $('#cropped_image').val(data);
                            }
                        });
                    };
                });
            });

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script>
        $(function () {
            $('input')
                .on('change', function (event) {
                    var $element = $(event.target);
                    var $container = $element.closest('.example');

                    if (!$element.data('tagsinput')) return;

                    var val = $element.val();
                    if (val === null) val = 'null';
                    var items = $element.tagsinput('items');

                    $('code', $('pre.val', $container)).html(
                        $.isArray(val)
                            ? JSON.stringify(val)
                            : '"' + val.replace('"', '\\"') + '"'
                    );
                    $('code', $('pre.items', $container)).html(
                        JSON.stringify($element.tagsinput('items'))
                    );
                })
                .trigger('change');
        });
    </script>
@endsection
        