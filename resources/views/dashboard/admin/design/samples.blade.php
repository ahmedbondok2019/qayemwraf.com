

<div class="col-lg-6">
    <div class="form-group {{ $errors->has('sample') ? 'has-error' : '' }}">
        <label for="">{{ trans_db('dashboard.samples') }}</label>
        <select name="sample" id="sample" class="form-control select2" style="width: 100%;">
            <option selected value="">{{ trans_db('dashboard.Choose') }}</option>
            @foreach ($samples as $sample)
                <option value="{{ $sample->id }}" {{ $sample->active == 1 ? "selected" : "" }}>{{ $sample->DesignPageSampleTranslations->title }} {{ $sample->active == 1 ? "(" . trans_db('dashboard.active') . ")" : "" }}</option>
            @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('sample') }}</span>
    </div>
</div>

