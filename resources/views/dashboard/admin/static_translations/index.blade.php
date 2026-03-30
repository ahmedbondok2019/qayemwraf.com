@extends('dashboard.admin.layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ trans_db('dashboard.Static Translations') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans_db('dashboard.Static Translations') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <button type="button" class="btn btn-primary" id="createNewTranslation">
                            <i data-feather="plus"></i> {{ trans_db('dashboard.Add New') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">{{ trans_db('dashboard.Translations List') }}</h4>
                                </div>
                                <div class="card-body mt-2">
                                    <table class="table data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans_db('dashboard.Key') }}</th>
                                                @foreach($locales as $locale)
                                                    <th>{{ strtoupper($locale) }}</th>
                                                @endforeach
                                                <th>{{ trans_db('dashboard.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="translationForm" name="translationForm" class="form-horizontal">
                        <input type="hidden" name="translation_id" id="translation_id">
                        <div class="form-group">
                            <label for="key" class="col-sm-2 control-label">{{ trans_db('dashboard.Key') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="key" name="key" placeholder="Enter Key" value="" required>
                            </div>
                        </div>
                        
                        @foreach($locales as $locale)
                        <div class="form-group">
                            <label for="trans_{{ $locale }}" class="col-sm-2 control-label">{{ strtoupper($locale) }}</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="trans_{{ $locale }}" name="translations[{{ $locale }}]" placeholder="Enter {{ strtoupper($locale) }} Translation"></textarea>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">{{ trans_db('dashboard.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.static_translations.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'key', name: 'key'},
                    @foreach($locales as $locale)
                    {data: 'translations.{{ $locale }}', name: 'translations->{{ $locale }}', defaultContent: ''},
                    @endforeach
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#createNewTranslation').click(function () {
                $('#saveBtn').val("create-translation");
                $('#translation_id').val('');
                $('#translationForm').trigger("reset");
                $('#modelHeading').html("{{ trans_db('dashboard.Add New Translation') }}");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.edit', function () {
                var translation_id = $(this).data('id');
                $.get("{{ route('admin.static_translations.index') }}" +'/' + translation_id +'/edit', function (data) {
                    $('#modelHeading').html("{{ trans_db('dashboard.Edit Translation') }}");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#translation_id').val(data.id);
                    $('#key').val(data.key);
                    
                    // Clear previous values
                    @foreach($locales as $locale)
                        $('#trans_{{ $locale }}').val('');
                    @endforeach

                    if(data.translations) {
                        @foreach($locales as $locale)
                            if(data.translations['{{ $locale }}']) {
                                $('#trans_{{ $locale }}').val(data.translations['{{ $locale }}']);
                            }
                        @endforeach
                    }
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                
                var url = "{{ route('admin.static_translations.store') }}";
                var id = $('#translation_id').val();
                if(id){
                    url = "{{ route('admin.static_translations.index') }}" + '/' + id; // Update route usually PUT/PATCH
                }
                
                // For update, we need to handle Method Spoofing if using PUT/PATCH
                var formData = new FormData($('#translationForm')[0]);
                if(id){
                    formData.append('_method', 'PUT');
                     $.ajax({
                        url: url,
                        type: "POST", // Use POST with _method PUT
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('#translationForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                            $('#saveBtn').html("{{ trans_db('dashboard.Save') }}");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#saveBtn').html("{{ trans_db('dashboard.Save') }}");
                        }
                    });
                } else {
                     $.ajax({
                        data: $('#translationForm').serialize(),
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#translationForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                            $('#saveBtn').html("{{ trans_db('dashboard.Save') }}");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#saveBtn').html("{{ trans_db('dashboard.Save') }}");
                        }
                    });
                }
            });

            $('body').on('click', '.delete', function () {
                var translation_id = $(this).data("id");
                if(confirm("{{ trans_db('dashboard.Are you sure?') }}")){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.static_translations.store') }}"+'/'+translation_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
@endsection
