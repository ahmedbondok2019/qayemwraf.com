<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\AdvertisementResource;
use App\Http\Resources\ApiV1\BlogResource;
use App\Http\Resources\ApiV1\BrandResource;
use App\Http\Resources\ApiV1\CategoryResource;
use App\Http\Resources\ApiV1\OfferResource;
use App\Http\Resources\ApiV1\SliderResource;
use App\Http\Resources\ApiV1\ProductResource;
use App\Http\Resources\ApiV1\FlashSaleResource;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\Slider;
use App\Models\FlashSale;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Integrated Home Data
     * 
     * Returns all data needed for the home page including sliders, offers, ads, categories, products, partners, and blogs.
     */
    public function index()
    {
        $data = [];

        // 1. Sliders
        $data['sliders'] = SliderResource::collection(Slider::active()->with(['translation', 'category'])->get());

        // 2. Strongest Offers
        $data['top_offers'] = OfferResource::collection(
            Offer::active()
                ->where(function($query) {
                    $query->where(function($q) {
                        $q->whereNotNull('category_id')
                          ->whereHas('category.products', function($pq) {
                              $pq->where('status', 1)
                                ->whereHas('flashSales', function($fq) {
                                    $fq->where('is_active', 1)
                                      ->where('start_at', '<=', now())
                                      ->where('end_at', '>=', now());
                                });
                          });
                    })->orWhere(function($q) {
                        $q->whereNull('category_id')
                          ->whereExists(function($eq) {
                              $eq->select(DB::raw(1))
                                 ->from('flash_sale_products')
                                 ->join('flash_sales', 'flash_sales.id', '=', 'flash_sale_products.flash_sale_id')
                                 ->join('products', 'products.id', '=', 'flash_sale_products.product_id')
                                 ->where('flash_sales.is_active', 1)
                                 ->where('flash_sales.start_at', '<=', now())
                                 ->where('flash_sales.end_at', '>=', now())
                                 ->where('products.status', 1);
                          });
                    });
                })
                ->orderBy('sort_order')
                ->with(['translation', 'category.translation'])
                ->get()
        );

        // 3. Home Advertisements
        $data['home_ads'] = AdvertisementResource::collection(Advertisement::where('location', 'home')->active()->with(['translation'])->get());

        // 4. Main Categories (parent_id is null)
        $data['main_categories'] = CategoryResource::collection(
            Category::active()->whereNull('parent_id')->with(['translation', 'children.translation'])->withCount('products')->orderBy('sort_order')->get()
        );

        // 5. Sub Categories (parent_id is NOT null)
        $data['sub_categories'] = CategoryResource::collection(
            Category::active()->whereNotNull('parent_id')->with(['translation', 'parent'])->withCount('products')->orderBy('sort_order')->get()
        );

        // 6. Best Sellers
        $bestSellers = Product::active()
            ->where('is_best_seller', true)
            ->where(function($q) {
                $q->whereNull('best_seller_start')->orWhere('best_seller_start', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('best_seller_end')->orWhere('best_seller_end', '>=', now());
            })
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
            }])
            ->take(8)
            ->get();
        $data['best_sellers'] = ProductResource::collection($bestSellers);

        // 7. Latest Products
        $latestProducts = Product::active()
            ->latest()
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
            }])
            ->take(8)
            ->get();
        $data['latest_products'] = ProductResource::collection($latestProducts);

        // 8. Success Partners (Brands)
        // Using ProductBrand as it's the more recent model used in products
        $data['partners'] = BrandResource::collection(ProductBrand::active()->orderBy('sort_order')->withCount('products')->get());

        // 9. Flash Sales (Products)
        $flashSaleIds = FlashSale::where('is_active', 1)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->pluck('id');
            
        $flashProducts = Product::active()
            ->whereHas('flashSales', function($q) use ($flashSaleIds) {
                $q->whereIn('flash_sales.id', $flashSaleIds);
            })
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
            }])
            ->take(8)
            ->get();
            
        $data['flash_sales'] = ProductResource::collection($flashProducts);

        // 10. Blogs (Limited)
        $data['blogs'] = BlogResource::collection(Blog::active()->with('BlogTranslation')->latest()->take(3)->get());

        // Map to legacy keys for Flutter app compatibility
        $legacyData = [
            'slider' => $data['sliders'],
            'offers' => $data['top_offers'],
            'categories' => $data['main_categories'],
            'brands' => $data['partners'],
            'latestProducts' => $data['latest_products'],
            'topSeller' => $data['best_sellers'],
            'flashdeals' => $data['flash_sales'],
            'mostviewedProducts' => $data['best_sellers'], // Fallback
        ];
        
        // Merge so both new and old keys coexist
        $responseData = array_merge($data, $legacyData);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'error' => null,
            'code' => '200'
        ], 200);
    }

    /**
     * Get Flash Sales
     * 
     * Returns a list of current and upcoming flash sales.
     */
    public function flashSales()
    {
        $flashSales = FlashSale::where('is_active', 1)
            ->where('end_at', '>=', now())
            ->with(['translation', 'products'])
            ->withCount('products')
            ->orderBy('start_at', 'asc')
            ->get();

        return $this->successResponse(FlashSaleResource::collection($flashSales));
    }
}
