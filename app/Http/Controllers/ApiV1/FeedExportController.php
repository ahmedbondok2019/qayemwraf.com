<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Blog;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group 18. التصدير والتغذية (Feeds & Exports)
 * 
 * واجهات تصدير خريطة الموقع Sitemap، خريطة منتجات Google Merchant، وتغدية منتجات Facebook Catalog.
 */
class FeedExportController extends Controller
{
    /**
     * تصدير خريطة الموقع (Sitemap XML / JSON)
     * 
     * يعيد خريطة الموقع بجميع روابط المنتجات والأقسام والصفحات والمدونات بتنسيق XML أو JSON.
     */
    public function sitemap(Request $request)
    {
        $products = Product::active()->whereHas('translations')->latest()->get();
        $categories = Category::active()->get();
        $pages = Page::active()->get();
        $blogs = Blog::active()->latest()->get();

        $locale = app()->getLocale();
        $baseUrl = config('app.url') ?: url('/');

        if ($request->wantsJson() || $request->get('format') === 'json') {
            $urls = [];

            // Home
            $urls[] = [
                'loc' => url($locale),
                'lastmod' => now()->toIso8601String(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];

            // Products
            foreach ($products as $product) {
                $slug = $product->translation->slug ?? $product->slug ?? $product->id;
                $urls[] = [
                    'loc' => url($locale . '/product/' . $product->id . '/' . $slug),
                    'lastmod' => ($product->updated_at ?? now())->toIso8601String(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }

            // Categories
            foreach ($categories as $category) {
                $slug = $category->translation->slug ?? $category->slug ?? $category->id;
                $urls[] = [
                    'loc' => url($locale . '/products/' . $slug),
                    'lastmod' => ($category->updated_at ?? now())->toIso8601String(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }

            // Pages
            foreach ($pages as $page) {
                $slug = $page->translation->slug ?? $page->slug ?? $page->id;
                $urls[] = [
                    'loc' => url($locale . '/page/' . $slug),
                    'lastmod' => ($page->updated_at ?? now())->toIso8601String(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            }

            // Blogs
            foreach ($blogs as $blog) {
                $slug = $blog->translation->slug ?? $blog->slug ?? $blog->id;
                $urls[] = [
                    'loc' => url($locale . '/blog/' . $blog->id . '/' . $slug),
                    'lastmod' => ($blog->updated_at ?? now())->toIso8601String(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $urls,
            ]);
        }

        // Return XML response
        $xmlContent = view('frontend.sitemap', [
            'products' => $products,
            'categories' => $categories,
            'pages' => $pages,
            'blogs' => $blogs,
        ])->render();

        return response($xmlContent, 200)
            ->header('Content-Type', 'text/xml; charset=UTF-8');
    }

    /**
     * تصدير المنتجات لمنصة Google Merchant Center (CSV)
     * 
     * ينشئ ملف CSV متوافق مع مواصفات Google Merchant Center لشراء جوجل (Google Shopping).
     */
    public function googleMerchant(Request $request)
    {
        $products = Product::active()
            ->whereHas('translations')
            ->with(['translations', 'categories.translations', 'brand.translation', 'images'])
            ->get();

        $currencyCode = config('app.currency_code') ?: 'EGP';
        $locale = app()->getLocale();

        $headers = [
            'id',
            'title',
            'description',
            'link',
            'image_link',
            'availability',
            'price',
            'sale_price',
            'brand',
            'condition',
            'google_product_category',
        ];

        $output = fopen('php://temp', 'r+');
        fputcsv($output, $headers);

        foreach ($products as $product) {
            $trans = $product->translation ?? $product->translations->first();
            $title = $trans->name ?? 'Product #' . $product->id;
            $description = strip_tags($trans->description ?? $trans->name ?? '');

            $slug = $trans->slug ?? $product->slug ?? $product->id;
            $link = url($locale . '/product/' . $product->id . '/' . $slug);

            $imageLink = $product->image ? asset($product->image) : '';

            $isAvailable = ($product->quantity > 0 || $product->ignore_quantity);
            $availability = $isAvailable ? 'in_stock' : 'out_of_stock';

            [$flashPrice, $flashId] = OrderService::getFlashSaleValue($product->id);
            $effectiveSalePrice = $flashPrice > 0 ? $flashPrice : ($product->special_price ?: null);

            $priceFormatted = number_format($product->price, 2, '.', '') . ' ' . $currencyCode;
            $salePriceFormatted = $effectiveSalePrice ? number_format($effectiveSalePrice, 2, '.', '') . ' ' . $currencyCode : '';

            $brandName = $product->brand->name ?? config('app.name', 'EG Medical');
            $categoryName = $product->categories->first()->name ?? '';

            fputcsv($output, [
                $product->sku ?: $product->id,
                $title,
                $description,
                $link,
                $imageLink,
                $availability,
                $priceFormatted,
                $salePriceFormatted,
                $brandName,
                'new',
                $categoryName,
            ]);
        }

        rewind($output);
        $csvData = stream_get_contents($output);
        fclose($output);

        return response($csvData, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'inline; filename="google_merchant_' . $locale . '.csv"',
        ]);
    }

    /**
     * تصدير منتجات كتالوج فيسبوك / ميتة (Facebook Catalog CSV)
     * 
     * ينشئ ملف CSV متوافق مع مواصفات Facebook Commerce Manager لربط منتجات الكتالوج والإعلانات الديناميكية.
     */
    public function facebookCatalog(Request $request)
    {
        $products = Product::active()
            ->whereHas('translations')
            ->with(['translations', 'categories.translations', 'brand.translation', 'images'])
            ->get();

        $currencyCode = config('app.currency_code') ?: 'EGP';
        $locale = app()->getLocale();

        $headers = [
            'id',
            'title',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'brand',
            'fb_product_category',
            'sale_price',
        ];

        $output = fopen('php://temp', 'r+');
        fputcsv($output, $headers);

        foreach ($products as $product) {
            $trans = $product->translation ?? $product->translations->first();
            $title = $trans->name ?? 'Product #' . $product->id;
            $description = strip_tags($trans->description ?? $trans->name ?? '');

            $slug = $trans->slug ?? $product->slug ?? $product->id;
            $link = url($locale . '/product/' . $product->id . '/' . $slug);

            $imageLink = $product->image ? asset($product->image) : '';

            $isAvailable = ($product->quantity > 0 || $product->ignore_quantity);
            $availability = $isAvailable ? 'in stock' : 'out of stock';

            [$flashPrice, $flashId] = OrderService::getFlashSaleValue($product->id);
            $effectiveSalePrice = $flashPrice > 0 ? $flashPrice : ($product->special_price ?: null);

            $priceFormatted = number_format($product->price, 2, '.', '') . ' ' . $currencyCode;
            $salePriceFormatted = $effectiveSalePrice ? number_format($effectiveSalePrice, 2, '.', '') . ' ' . $currencyCode : '';

            $brandName = $product->brand->name ?? config('app.name', 'EG Medical');
            $categoryName = $product->categories->first()->name ?? '';

            fputcsv($output, [
                $product->sku ?: $product->id,
                $title,
                $description,
                $availability,
                'new',
                $priceFormatted,
                $link,
                $imageLink,
                $brandName,
                $categoryName,
                $salePriceFormatted,
            ]);
        }

        rewind($output);
        $csvData = stream_get_contents($output);
        fclose($output);

        return response($csvData, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'inline; filename="facebook_catalog_' . $locale . '.csv"',
        ]);
    }
}
