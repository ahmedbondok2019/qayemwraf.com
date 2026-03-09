<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Products with Filters
     * 
     * Returns a paginated list of products with various filters.
     * 
     * @queryParam category_id int Filter by category ID.
     * @queryParam search string Search by product name or brand.
     * @queryParam min_price float Minimum price.
     * @queryParam max_price float Maximum price.
     * @queryParam brands array Filter by brand IDs.
     * @queryParam options array Filter by option values. Format: {option_id: [value_id, ...]}
     * @queryParam best_seller boolean Filter for best sellers.
     * @queryParam flash_sale boolean Filter for products in active flash sales.
     * @queryParam sort string Sort by: latest, price_asc, price_desc, best_seller.
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

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Search by Name or Brand
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

        // Filter by Price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by Brand
        if ($request->filled('brands')) {
            $brands = is_array($request->brands) ? $request->brands : explode(',', $request->brands);
            $query->whereIn('product_brand_id', $brands);
        }

        // Filter by Characteristics (Options)
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

        // Filter by Best Seller
        if ($request->boolean('best_seller')) {
            $query->where('is_best_seller', 1);
        }

        // Filter by Flash Sale
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

        // Sort
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
     * Get Best Selling Products
     * 
     * Returns a list of best selling products based on is_best_seller flag and date range.
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
     * Get Latest Products
     * 
     * Returns a list of the most recently added active products.
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
     * Get Product Details
     * 
     * Returns detailed information for a specific product.
     * 
     * @urlParam id int required The ID of the product.
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
