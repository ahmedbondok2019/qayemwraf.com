

<hr/>

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ trans_db('dashboard.Video') }}</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                        <label for="exampleInputEmail1">{{ trans_db('dashboard.VideoUrl') }}</label>
                        {!! Form::text( 'url', optional($video)->url , ['placeholder'=> "https://www.youtube.com/watch?v=Zz5cu72Gv5Y",'class' => "form-control" ]) !!}
                        <span class="text-danger">{{ $errors->first('url') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-9 design_image">
                            <div class="form-group">
                                <label for="">{{ trans_db('dashboard.Image') }} - <span style="color: red;">({{ trans_db('dashboard.width') }}:937 - {{ trans_db('dashboard.height') }}:625)</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="video_image">
                                    <label class="custom-file-label" for="customFile" style="padding-right: 83px;">{{ trans_db('dashboard.Image') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row newImages"></div>
                </div>
{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group {{ $errors->has( 'video_description' ) ? 'has-error' : '' }}">--}}
{{--                        <label for="exampleInputEmail1">{{ trans_db('dashboard.VideoDesc') }}</label>--}}
{{--                        {!! Form::text( 'video_description', optional($video)->video_description , ['placeholder'=> trans_db('dashboard.VideoDesc'),'class' => "form-control" ]) !!}--}}
{{--                        <span class="text-danger">{{ $errors->first( 'video_description' ) }}</span>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
        </div>
    </div>
</div>


<div class="row">
    @if($video)
        <div class="videoResult{{ optional($video)->id }}">
            <a onclick="deleteVideoImage({{ optional($video)->id }});">
                <i class="fa fa-trash danger" aria-hidden="true"></i>
                <div class="col-md-6">
                    <img src="{{ asset('website/images/design') }}/{{ optional($video)->image }}" alt="" style="{{ trans_db('dashboard.height') }}: 312px;width:208px;">
                </div>
            </a>
        </div>
    @endif
</div>

<script>

    function deleteVideoImage(id){
        $.ajax({
            type:'post',
            url:'{!! \LaravelLocalization::localizeUrl('admin-2023/design/delete/video/image') !!}',
            data:{'id':id},
            success:function(data) {
                $('.videoResult' + data['id']).html(data.videoResult);
            },
            fail:function(xhr, status, error) {}
        });
    }
</script>
