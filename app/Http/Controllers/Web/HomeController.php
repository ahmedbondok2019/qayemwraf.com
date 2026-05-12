<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\Category;
use App\Models\ProductBrand;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $offers = Offer::active()
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
            ->get();
        
        $categories = Category::active()
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();
            
        $subcategories = Category::active()
            ->whereNotNull('parent_id')
            ->with(['parent'])
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $brands = ProductBrand::active()->orderBy('sort_order')->get();

        $bestSellers = \App\Models\Product::active()
            ->where('show_on_home', 1)
            ->where('is_best_seller', true)
            ->where(function($q) {
                $q->whereNull('best_seller_start')
                  ->orWhere('best_seller_start', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('best_seller_end')
                  ->orWhere('best_seller_end', '>=', now());
            })
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1)
                  ->with('translation');
            }])
            ->take(8)
            ->get();

        $latestProducts = \App\Models\Product::active()
            ->where('show_on_home', 1)
            ->latest()
            ->with(['translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())
                  ->where('end_at', '>=', now())
                  ->where('is_active', 1)
                  ->with('translation');
            }])
            ->take(8)
            ->get();

        // Wishlist for Guest/Auth
        $user = \Illuminate\Support\Facades\Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = \Illuminate\Support\Facades\Cookie::get('temp_user_id');

        // Cart for Guest/Auth
        $cartProducts = \App\Models\Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } elseif ($tempUserId) {
                    $q->where('temp_user_id', $tempUserId);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->pluck('quantity', 'product_id')
            ->toArray();

        // Wishlist IDs (Already updated previously)
        $wishlistIds = \App\Models\Wishlist::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } elseif ($tempUserId) {
                    $q->where('temp_user_id', $tempUserId);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->pluck('product_id')
            ->toArray();

        $homeAds = \App\Models\Advertisement::where('location', 'home')->active()->get();

        $blogs = Blog::active()->with('BlogTranslation')->latest()->take(3)->get();

        return view("frontend.home.index", compact('sliders', 'offers', 'categories', 'subcategories', 'brands', 'bestSellers', 'latestProducts', 'wishlistIds', 'cartProducts', 'homeAds', 'blogs'));
    }
}
