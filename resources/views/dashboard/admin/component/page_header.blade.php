


@php($arabic = ['ar'])
<!-- Content Header (Page header) -->
<div class="content-header" style="text-align: justify; ">
    <div class="container-fluid">
        <div class="row mb-2" style="{{ in_array(app()->getLocale() , $arabic) ? 'direction: rtl' : 'direction: ltr' }}">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $translation }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
