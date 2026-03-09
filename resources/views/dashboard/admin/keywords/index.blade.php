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
                            <h2 class="content-header-title float-start mb-0">{{ trans_db('dashboard.keyword') }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="content-body">
                
                @include('dashboard.admin.component.page_error' , ['errors' => $errors])
                
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
                                    <th> {{ trans_db('dashboard.Title') }} </th>
                                    <th> {{ trans_db('dashboard.Register Date') }} </th>
                                    <th> {{ trans_db('dashboard.delete') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($keywords as $keyword)
                                        <tr>
                                            <td>{{ $keyword->id }}</td>
                                            <td>{{ $keyword->keyword }}</td>
                                            <td>{{ $keyword->created_at }}</td>
                                            <td><a onclick="return confirm('<?php echo 'Are You Sure To Delete ?'; ?>')" href="{{ \LaravelLocalization::localizeUrl('admin-2023/keywords/delete/' . $keyword->id) }}" class="btn btn-danger">{{ trans_db('dashboard.delete') }}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $keywords->links() }}
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