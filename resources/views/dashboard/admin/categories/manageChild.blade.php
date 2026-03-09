@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
@endphp
<ul class="nested">
    @foreach ($childs as $child)
        <li draggable="true">
            <div class="tree-item d-flex flex-wrap flex-md-nowrap">
                <div class="img-plus">
                    @if ($child->childs->count())
                        <span class="toggle-btn">➕</span>
                    @endif
                    <a href="{{ route('admin.categories.edit', $child) }}">
                        <img src="{{ asset('website/images/category/' . optional($child->CategoryTranslation)->image) }}"
                            alt="" style="width: 35px; height: 35px; object-fit: cover; margin-right: 8px;">
                        {{ optional($child->CategoryTranslation)->title }}
                    </a>
                </div>

                <div class="controls d-flex align-items-center">
                    <a href="{{ LaravelLocalization::localizeUrl('admin-2023/products/category/' . $child->id) }}"
                        title="{{ trans_db('dashboard.products') }}" class="badge badge-primary mr-2">
                        ({{ \App\Http\Controllers\helper\HelperController::productsCount($child->id) }})
                    </a>

                    <!-- 👁️ للغات الأخرى -->
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if ($localeCode !== app()->getLocale())
                            @php
                                $transExists = $child->translations->where('lang_id', $localeCode)->isNotEmpty();
                                $transUrl = route('admin.categories.edit', $child) . '?lang=' . $localeCode;
                            @endphp
                            @if ($transExists)
                                <a href="{{ $transUrl }}" class="mx-1 text-muted"
                                    title="{{ $properties['native'] }}">👁️</a>
                            @else
                                <span class="mx-1 text-muted"
                                    title="{{ __('Not translated: :lang', ['lang' => $properties['native']]) }}">👁️</span>
                            @endif
                        @endif
                    @endforeach

                    <!-- زر الحذف -->
                    <form action="{{ route('admin.categories.destroy', $child) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn ml-2"
                            onclick="return confirm('{{ trans_db('dashboard.AreYouSureToDelete') }}')">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path
                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if ($child->childs->count())
                @include('dashboard.admin.categories.manageChild', ['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
