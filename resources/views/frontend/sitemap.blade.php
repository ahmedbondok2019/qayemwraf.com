{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ url('/ar/products') }}</loc>
        <priority>0.8</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ url('/ar/brands') }}</loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ url('/ar/contact') }}</loc>
        <priority>0.3</priority>
        <changefreq>monthly</changefreq>
    </url>

    @foreach($products as $product)
    <url>
        <loc>{{ url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? '')) }}</loc>
        <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
    </url>
    @endforeach

    @foreach($categories as $category)
    <url>
        <loc>{{ url('ar/products/' . ($category->translation->slug ?? '')) }}</loc>
        <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>
    @endforeach

    @foreach($blogs as $blog)
    <url>
        <loc>{{ url('ar/blog/' . $blog->id . '/' . ($blog->BlogTranslation->slug ?? '')) }}</loc>
        <lastmod>{{ $blog->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </url>
    @endforeach

    @foreach($pages as $page)
    <url>
        <loc>{{ url('ar/page/' . $page->slug) }}</loc>
        <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <priority>0.4</priority>
        <changefreq>monthly</changefreq>
    </url>
    @endforeach
</urlset>
