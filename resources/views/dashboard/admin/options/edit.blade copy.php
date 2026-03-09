@extends('dashboard.admin.layouts.app')

@section('style')

    {{-- {!! Html::style('admin/app-assets/css-rtl/custom-rtl.css') !!} --}}
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


                        <form action="{{ \LaravelLocalization::localizeUrl('admin-2023/options/update') }}" method="post" enctype="multipart/form-data" role="form">
                            @csrf

                            <input type="hidden" name="option_id" value="{{ $id }}">

                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="exampleInputEmail1">{{ trans_db('dashboard.Option Name') }}</label>
                                                {!! Form::text('title', $details->translations()->first()->title, ['placeholder'=> trans_db('dashboard.Option Name'),'class' => "form-control" ]) !!}
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                                <label for="">{{ trans_db('dashboard.type') }}</label>
                                                <select name="type" class="invoiceto form-control select2-hidden-accessible" style="width: 100%;">
                                                    <option selected="selected" value="">{{ trans_db('dashboard.Choose') }}</option>
                                                    <option value="1" {{ $details->type == 1 ? "selected" : "" }}>{{ trans_db('dashboard.dropdown')}}</option>
                                                    <option value="2" {{ $details->type == 2 ? "selected" : "" }}>{{ trans_db('dashboard.checkbox')}}</option>
                                                    <option value="3" {{ $details->type == 3 ? "selected" : "" }}>{{ trans_db('dashboard.radio')}}</option>
                                                </select>
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            </div>
                                        </div>

                                        <hr/>

                                        <div class="row m-2">
                                            <div class="col-lg-12">
                                                <h2>{{ trans_db("dashboard.Add New Item") }}</h2>
                                            </div>

                                            <div class="col-lg-12">
                                                @foreach($details->option_items as $optionItem)
                                                    <div class="row news_option_items">
                                                        <div class="col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-8">
                                                                            @php $names = array(); @endphp
                                                                            @php $collection = array(); $count = 0; @endphp
                                                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                            {{-- @foreach ($optionItem->Dashtranslations as $translations) --}}
                                                                                <div class="row">
                                                                                    {{-- @php $collection = array(); $count = 0; @endphp --}}
                                                                                    @foreach ($optionItem->Dashtranslations as $translations)
                                                                                        @php
                                                                                            $collection[] = $translations->lang_id;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                    @if (in_array($localeCode , $collection))
                                                                                        @foreach ($optionItem->Dashtranslations as $translations)
                                                                                            @if (!in_array($translations->title , $names))
                                                                                                @php $names[] = $translations->title; @endphp
                                                                                                @php $count += 1; @endphp
                                                                                                <div class="col-lg-9">
                                                                                                    <div class="form-group">
                                                                                                        <input type="hidden" name="optionItem[id][{{ $count }}][]" value="{{ $translations->id }}">
                                                                                                        <input type="hidden" name="optionItem[option_item_id][]" value="{{ $translations->option_item_id }}">
                                                                                                        <input type="hidden" name="optionItem[lang_id][{{ $count }}][]" value="{{ $translations->lang_id }}">
                                                                                                        <input type="text" class="form-control" name="optionItem[title][{{ $count }}][]" value="{{ $translations->title }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-3">
                                                                                                    <label>
                                                                                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                                                        @if ($translations->lang_id == $localeCode )
                                                                                                        {{ $properties['native'] }}
                                                                                                        @endif
                                                                                                        @endforeach
                                                                                                    </label>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @else
                                                                                        <div class="col-lg-9">
                                                                                            <div class="form-group">
                                                                                                <input type="hidden" name="optionItem[id][]" value="">
                                                                                                <input type="hidden" name="optionItem[option_item_id][]" value="">
                                                                                                <input type="text" class="form-control" name="optionItem[title][]" value="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            <label> {{ $properties['native'] }}</label>
                                                                                        </div>
                                                                                    @endif  
                                                                                </div>  
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeOptionItems(this , '{{ $optionItem->Dashtranslations()->first()->option_item_id }}')"><i data-feather="trash-2"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="option-items"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <a class="btn btn-success add-item">{{ trans_db('dashboard.Add New Option') }} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ trans_db('dashboard.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </section>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
</div>
<!-- /.content -->
@endsection

@section('script')
    @include('dashboard.admin.layouts.script')

    <script>
        function removeNewLink(e) {
            $(e).closest('div.options').remove();
        }

        $('.add-item').on('click' , function () {
            // @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                var count = document.getElementsByClassName('news_option_items').length + 1;
                var new_item = '<div class="card news_option_items">\n' +
                    // '<div class="card-body">\n' +
                    '<div class="row">\n' +
                    // '<div class="col-md-10">\n' +
                    // '<label for="">{{ trans_db("dashboard.Option Item") }}</label>\n' +
                    // '<input type="hidden" name="optionItem[id][]">\n' +
                    // '<input type="hidden" name="optionItem[option_item_id][]">\n' +
                    // '<input type="text" class="form-control" name="optionItem[title][]" placeholder="{{ trans_db("dashboard.Option Item") }}">\n' +
                    // '</div>\n' +
                    // '<div class="col-md-2 pt-2">\n' +
                    // '<div class="form-group">\n' +
                    // '<a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeOptionItems(this)"><i data-feather="trash-2"></i></a>\n' +
                    // '</div>\n' +
                    // '</div>\n' +
                    // '<div class="input-group input-group-lg">\n' +
                    //     '<input type="text" class="touchspin" value="50" data-bts-step="0.5" data-bts-decimals="2" data-bts-button-down-class="btn btn-warning" data-bts-button-up-class="btn btn-warning" name="touch'+count+'"/>\n' +
                    // '</div>\n' +
                    // '</div>';

                    '<div class="col-lg-8">\n' +
                    '        <div class="row">\n' +
                    '            <div class="col-lg-9">\n' +
                    '                <div class="form-group">\n' +
                    '                    <input type="hidden" name="optionItem[id][{{ $count }}][]">\n' +
                    '                    <input type="hidden" name="optionItem[option_item_id][]">\n' +
                    '                    <input type="hidden" name="optionItem[lang_id][{{ $count }}][]" value="{{ $localeCode }}">\n' +
                    '                    <input type="text" class="form-control" name="optionItem[title][{{ $count }}][]" value="">\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '            <div class="col-lg-3">\n' +
                    '                <label> {{ $properties["native"] }}</label>\n' +
                    '            </div>\n' +
                    '        </div>  \n' +
                    '</div>\n' +
                    '<div class="col-lg-4">\n' +
                    '    <div class="form-group">\n' +
                    '        <a title="Remove Option" class="delete_btn btn btn-danger js-remove-person" onclick="removeOptionItems(this)"><i data-feather="trash-2"></i></a>\n' +
                    '    </div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>';

                $('.option-items').append(new_item);
            // @endforeach

            
            feather.replace();

            tp(count);
        });

        function tp(index) {
            $("input[name='touch" + index + "']").TouchSpin();
        }

        function removeOptionItems(e , id = null) {
            if(id === null){
                $(e).closest('div.news_option_items').remove();
            }else{
                var confirmation = confirm("{{ trans_db('dashboard.AreYouSureToDelete') }}");
                if (confirmation) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:'{{ \LaravelLocalization::localizeUrl("admin-2023/options/deleteOptionItem") }}',
                        method:'POST',
                        data:{id:id},
                        success:function(data)
                        {
                            if (data['status'] == true) {
                                $(e).closest('div.news_option_items').remove();
                            }else{
                                console.log(data);
                            }
                        }
                    });
                }
            }
        }
    </script>
@endsection
