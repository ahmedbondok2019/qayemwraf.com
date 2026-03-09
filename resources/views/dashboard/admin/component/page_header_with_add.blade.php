

<?php $arabic = \App\Http\Controllers\helper\HelperController::getArabicLangs(); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6" style="text-align: @if(in_array(app()->getLocale() , $arabic)) right @else left @endif">
                <h1> {{ $translation }} </h1>
            </div>
            <div class="col-sm-6" style="text-align: @if(in_array(app()->getLocale() , $arabic)) left @else right @endif ;">
                <div class="card-tools">
                    <a href="{{ $route }}" class="btn btn-success">
                        <i data-feather='plus'></i>
                    </a>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
