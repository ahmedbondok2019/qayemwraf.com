<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

/**
 * @group 03. المنتجات (Products)
 * 
 * يتولى جلب قائمة المنتجات مع دعم الفلترة (حسب القسم، البراند، السعر، الفلاش سيل)،
 * والبحث، والمنتجات الأكثر مبيعاً، وأحدث المنتجات، وتفاصيل المنتج المحدد.
 */
class ProductController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة المنتجات مع الفلترة والبحث
     * 
     * يعيد قائمة مفلترة ومقسمة صفحات من المنتجات النشطة بناءً على القسم، العلامة التجارية،
     * نطاق السعر، الخصائص، أو البحث بالاسم.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with([
            'translation', 
            'brand.translation', 
            'categories.translation', 
            'images',
            'productOptions.option.translation',
            'productOptions.values.optionValue.translation',
            'flashSales' => function($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1);
            }
        ]);

        // الفلترة حسب القسم
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // البحث باسم المنتج أو العلامة التجارية
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('translations', function ($qt) use ($search) {
                    $qt->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('brand.translations', function ($qb) use ($search) {
                    $qb->where('title', 'like', '%' . $search . '%');
                });
            });
        }

        // الفلترة حسب السعر
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // الفلترة حسب العلامة التجارية (البراند)
        if ($request->filled('brands')) {
            $brands = is_array($request->brands) ? $request->brands : explode(',', $request->brands);
            $query->whereIn('product_brand_id', $brands);
        }

        // الفلترة حسب المواصفات والخيارات
        if ($request->filled('options')) {
            $options = $request->options;
            if (is_string($options)) {
                $options = json_decode($options, true);
            }
            
            if (is_array($options)) {
                foreach ($options as $optionId => $valueIds) {
                    $query->whereHas('productOptions.values', function ($q) use ($valueIds) {
                        $q->whereIn('option_value_id', (array)$valueIds);
                    });
                }
            }
        }

        // الفلترة بالمنتجات الأكثر مبيعاً
        if ($request->boolean('best_seller')) {
            $query->where('is_best_seller', 1);
        }

        // الفلترة بالتخفيضات السريعة (فلاش سيل)
        if ($request->filled('flash_sale_id')) {
            $query->whereHas('flashSales', function ($q) use ($request) {
                $q->where('flash_sales.id', $request->flash_sale_id)
                  ->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1);
            });
        } elseif ($request->boolean('flash_sale')) {
            $query->whereHas('flashSales', function ($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1);
            });
        }

        // الترتيب
        switch ($request->sort) {
            case 'latest':
                $query->latest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'best_seller':
                $query->orderBy('is_best_seller', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate($request->get('limit', 12));

        return $this->successResponse($this->paginateResponse($products, ProductResource::collection($products)));
    }

    /**
     * جلب المنتجات الأكثر مبيعاً
     * 
     * يعيد قائمة بالمنتجات الأكثر مبيعاً في النظام.
     */
    public function bestSellers()
    {
        $bestSellers = Product::active()
            ->where('is_best_seller', true)
            ->where(function($q) {
                $q->whereNull('best_seller_start')
                  ->orWhere('best_seller_start', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('best_seller_end')
                  ->orWhere('best_seller_end', '>=', now());
            })
            ->with(['translation', 'brand.translation', 'productOptions.option.translation', 'productOptions.values.optionValue.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1)
                  ->with('translation');
            }])
            ->take(8)
            ->get();

        return $this->successResponse(ProductResource::collection($bestSellers));
    }

    /**
     * جلب أحدث المنتجات المضافة
     * 
     * يعيد قائمة بأحدث المنتجات المضافة حديثاً للنظام.
     */
    public function latestProducts()
    {
        $latestProducts = Product::active()
            ->latest()
            ->with(['translation', 'brand.translation', 'productOptions.option.translation', 'productOptions.values.optionValue.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1)
                  ->with('translation');
            }])
            ->take(8)
            ->get();

        return $this->successResponse(ProductResource::collection($latestProducts));
    }

    /**
     * جلب تفاصيل منتج محدد
     * 
     * يعيد كامل بيانات وتفاصيل المنتج والصور التوضيحية والخيارات والمنتجات المشابهة برقم المنتج (ID).
     */
    public function show($id)
    {
        $product = Product::active()
            ->with([
                'translation',
                'translations',
                'images',
                'brand.translation',
                'categories.translation',
                'productOptions.option.translation',
                'productOptions.values.optionValue.translation',
                'relatedProducts.translation',
                'relatedProducts.translations',
                'relatedProducts.images',
                'flashSales' => function($q) {
                    $q->where('start_at', '<=', now())
                      ->where('end_at', '>=', now())
                      ->where('is_active', 1)
                      ->with('translation');
                }
            ])
            ->findOrFail($id);

        return $this->successResponse(new ProductResource($product));
    }
}
