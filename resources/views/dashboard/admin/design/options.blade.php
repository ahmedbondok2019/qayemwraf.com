


<div class="row">
    @foreach ($options as $option)
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input options" type="checkbox" name="option[]"
                               data-title="{{ $option->title }}"
                               value="{{ $option->id }}" @if($option->status == 1) checked @endif>
                        <span style="padding: 0 20px;">{{ $option->title }}</span>
                    </label>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>

