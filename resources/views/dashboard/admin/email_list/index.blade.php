@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            
            <div class="content-hearder row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{ trans_db("dashboard.newsletter") }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="content-body">
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">    
                            <!-- /.card-header -->
                            <div class="card-body">
                                @livewire('dashboard.admin.news' , ['Setting' => $Setting])
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sent Emails</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h3 style="text-align: center;font-wight:900;color:orangered">{{ trans_db('dashboard.Total Sent') }} : {{ $totalSent }}</h3>
                                        </div>
                                        <div class="col-lg-6">
                                            <h3 style="text-align: center;font-wight:900;color:orangered">{{ trans_db('dashboard.Total Sent') }} اليوم  : {{ $totalToday }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> </h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @if (session('msg'))
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                {{ session('msg') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                        @endif
                                        
                                        <div class="row">
                                            <div class="col-6" style="text-align: center !important;">
                                                <div class="form-group">
                                                    <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/newsletter/UsersDownload') }}" class="btn btn-success btn-lg">{{ trans_db('dashboard.ExportToExcelUsers') }}</a>
                                                </div>
                                            </div>
                                            <div class="col-6" style="text-align: center !important;">
                                                <div class="form-group">
                                                    <a href="{{ \LaravelLocalization::localizeUrl('admin-2023/newsletter/NewsletterDownload') }}" class="btn btn-success btn-lg">{{ trans_db('dashboard.ExportToExcelNewsletter') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload White List</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card-header">
                                            <h3 style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};"> رفع قائمة جديدة بيضاء </h3>
                                        </div>
                                        <div class="card-body">                                
                                            <form id="second" action="{{ \LaravelLocalization::localizeUrl("admin-2023/newsletter/createContact") }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                
                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">إضافة نص : </label>
                                                    <textarea class="form-control-file" name="contacts_txt"></textarea>
                                                </div>
                
                                                <div class="input-group">
                                                    <label class="input-group-btn">
                                                        <span class="btn btn-primary">
                                                            Browse&hellip; <input type="file" style="display: none;" id="file" name="contacts">
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" id="inputBox" readonly>
                                                </div>
                                                <button type="submit" class="btn btn-success">اضافة جهات الاتصال</button>
                                                <script>
                                                    getFileName('file', 'inputBox');
                                                    getFileName('file1', 'inputBox1');
                                                </script>                               
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload Black List</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
    
                            <div class="card-content collapse show" style="">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card-header">
                                            <h3 style="text-align: {{ app()->getLocale() == 'en' ? 'left' : 'right' }};"> رفع قائمة للحذف </h3>
                                        </div>
                                        <div class="card-body">                                
                                            <form id="first" action="{{ \LaravelLocalization::localizeUrl("admin-2023/newsletter/createContactBlackList") }}" method="post" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">إضافة نص : </label>
                                                    <textarea class="form-control-file" name="contacts_txt"></textarea>
                                                </div>
                
                                                <div class="input-group">
                                                    <label class="input-group-btn">
                                                        <span class="btn btn-primary">
                                                            Browse&hellip; <input type="file" style="display: none;" id="file" name="block_contacts">
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" id="inputBox" readonly>
                                                </div>
                                                <button type="submit" class="btn btn-danger">اضافة قائمة </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ trans_db('dashboard.products') }}</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="collapse" class=""><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-content collapse show" style="">
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> {{ trans_db('dashboard.Email') }} </th>
                                    <th> {{ trans_db('dashboard.Send') }} </th>
                                    <th> {{ trans_db('dashboard.Phone') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Currentnewsletter as $allnewsletter)
                                    <tr>
                                        <td>{{ $allnewsletter->id }}</td>
                                        <td><a href="#">{{$allnewsletter->email}}</a></td>
                                        <td><a href="{{ \LaravelLocalization::localizeUrl('admin-2023/newsletter/send') }}/{{$allnewsletter->id}}" class="btn btn-success">{{ trans_db('dashboard.Send') }}</a></td>
                                        <td><a href="https://api.whatsapp.com/send?phone=2{{ $allnewsletter->number}}&text=السلام عليكم&data=" target="_blank" class="btn btn-primary">{{ $allnewsletter->number}}</a></td>
                                        <td><a onclick="return confirm('<?php echo trans_db('dashboard.AreYouSureToDelete'); ?>')" href="{{ url('admin-2023/newsletter/delete') }}/{{$allnewsletter->id}}" class="btn btn-danger">{{ trans_db('dashboard.delete') }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td> ID </td>
                                    <th> {{ trans_db('dashboard.Email') }} </th>
                                    <th> {{ trans_db('dashboard.Send') }} </th>
                                    <th> {{ trans_db('dashboard.Phone') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </tr>
                                </tfoot>
                            </table>

                            {{ $Currentnewsletter->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')

    @include('dashboard.admin.layouts.script')

@endsection

@section('js')
<script>
    function getFileName(file, inputBox) {
        const fileInput = document.getElementById(file);
        fileInput.onchange = () => {
            const selectedFile = fileInput.files[0];
            console.log(selectedFile);
            document.getElementById(inputBox).value =selectedFile.name;
        }
    }
</script>