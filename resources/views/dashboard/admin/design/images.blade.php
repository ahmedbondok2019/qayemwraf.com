

<hr/>

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <h2>{{ trans_db('dashboard.Images') }}</h2>
            <div class="row">
                <div class="col-md-9 design_image">
                    <div class="form-group">
                        <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">({{ trans_db('dashboard.width') }}:1450 - {{ trans_db('dashboard.height') }}:750)</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="image[]">
                            <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row newImages"></div>
        </div>

        <div class="col-md-12">
            <a class="btn btn-success add-image">{{ trans_db('dashboard.new_image') }} </a>
        </div>
    </div>
</div>

<div class="row">
    @foreach($images as $image)
        <div class="result{{ $image->id }}">
{{--            <a onclick="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')" class="delete_image" data-id="{{ $image->id }}">--}}
            <a onclick="deleteImage({{ $image->id }});" >
                <i class="fa fa-trash danger" aria-hidden="true"></i>
                <div class="col-md-6">
                    <img src="{{ asset('website/images/design') }}/{{ $image->image }}" alt="" style="{{ trans_db('dashboard.height') }}: 265px;width:400px;">
                </div>
            </a>
        </div>
    @endforeach
</div>

<script>

    function removeNewImage(e) {
        $(e).closest('div.newImages').remove();
    }

    $('.add-image').on('click' , function () {
        var count = document.getElementsByClassName('design_image').length;

        if(count < 3){
            var new_image = '<div class="col-md-9 design_image">\n' +
                '<label>{{ trans_db("dashboard.Image") }} - <span style="color: red;">({{ trans_db('dashboard.width') }}:1450 - {{ trans_db('dashboard.height') }}:750)</span></label>\n' +
                '<div class="custom-file">\n' +
                '<input type="file" class="custom-file-input" id="customFile" name="image[]" required>\n' +
                '<label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db("dashboard.Image") }}</label>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 pt-4">\n' +
                '<div class="form-group">\n' +
                '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeRenewCourses(this)"><i class="fa fa-remove"></i> <?php echo  trans_db("dashboard.delete"); ?>  </a>\n' +
                '</div>';
            '</div>';

            $('.newImages').append(new_image);
        }
    });

    function removeRenewCourses(e) {
        $(e).closest('div.design_image').remove();
    }

    function deleteImage(id){
        // var id = $(this).attr('data-id');

        $.ajax({
            type:'post',
            url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/delete/image') !!}',
            data:{'id':id},
            success:function(data) {
                // console.log("success");
                $('.result' + data['id']).html(data.result);
            },
            fail:function(xhr, status, error) {}
        });
    }
    // $(document).on('click','delete_image',function(){
    //
    // });
</script>
