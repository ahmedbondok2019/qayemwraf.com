@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')
@endsection

@section('content')

    <div class="app-content content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">

                        <div class="card-header">
                            <div class="dt-buttons btn-group flex-wrap">
                                <a class="btn add-new btn-primary mt-50" tabindex="0"
                                   href="{{ \LaravelLocalization::localizeUrl('admin-2023/users/permission/add') }}"
                                   aria-controls="DataTables_Table_0" type="button">
                                    <span>{{ trans_db('dashboard.Add New Permission') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-header">
                            <h3 > {{ trans_db('dashboard.AllPermission') }} </h3>
                        </div>

                        <div class="card-body">
                            @include('dashboard.admin.component.page_error' , ['errors' => $errors])

                            <div class="col-12">
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">

                                        @livewire('dashboard.admin.permissions')

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    <script>
        window.addEventListener('close-modal', event => {

            $('#modals_slide_in').modal('hide');
            $('#modals_slide_in_update').modal('hide');
            $('#deleteStudentModal').modal('hide');
        })
    </script>

    
    <script>
        $(document).ready(function(){
            $("#showEnterCodeModal").on('hidden.bs.modal', function(){
                livewire.emit('onCloseModal');
            });
        });
    </script>
@endsection
