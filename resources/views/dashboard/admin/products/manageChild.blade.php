{{-- <select> --}}
	@foreach($childs as $child)
        @if(isset($child->CategoryTranslation))
            @if(count($child->childs))
                <optgroup label="{{ optional($child->CategoryTranslation)->title }}">
            @endif
            <option value="{{ $child->id }}" {{ $categories_id == $child->id ? 'selected' : '' }}>{{ optional($child->CategoryTranslation)->title }}</option>
                @if(count($child->childs))
                    @include('dashboard.admin.products.manageChild',['childs' => $child->childs,'categories_id' => $categories_id])
                @endif
            @if(count($child->childs)) </optgroup> @else </option> @endif>
        @endif
	@endforeach
{{-- </select> --}}
