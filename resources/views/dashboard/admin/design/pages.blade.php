
<div class="col-lg-6">
    <div class="form-group {{ $errors->has('page') ? 'has-error' : '' }}">
        <label for="">{{ trans_db('dashboard.pages') }}</label>
        <select name="page" id="page" class="form-control select2" style="width: 100%;">
            <option selected value="">{{ trans_db('dashboard.Choose') }}</option>
            @foreach ($pages as $page)
                <option value="{{ $page->id }}" {{ $page->active == 1 ? "selected" : "" }}>{{ optional($page->DesignPageTranslations->first())->title }}</option>
            @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('page') }}</span>
    </div>
</div>

