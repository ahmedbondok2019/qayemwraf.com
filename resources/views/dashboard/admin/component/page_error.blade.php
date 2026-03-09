
@if (session('msg'))
    {{-- <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
        <div class="alert alert-success alert-dismissible" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('msg') }}
        </div>
    </div> --}}
    <div class="demo-spacing-0">
        <div class="alert alert-success mt-1 alert-validation-msg alert-dismissible" role="alert">
            <div class="alert-body d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span><strong>{{ session('msg') }}</strong></span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    </div>
@endif


    {{-- <div class="card-body" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
        <div class="alert alert-danger alert-dismissible" style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div> --}}


@if ($errors->any())
    <div class="demo-spacing-0">
        <div class="alert alert-danger mt-1 alert-validation-msg alert-dismissible" role="alert">
            <div class="alert-body d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><span class="text-danger"><strong>{{ $error }}</strong></span></li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    </div>
@endif
