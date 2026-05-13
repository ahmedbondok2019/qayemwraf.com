<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Models\FlashSale;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function liveSearch(Request $request)
    {
        $search = $request->get('search');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->whereHas('translations', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->with(['translation'])
            ->limit(10)
            ->get();

        $results = [];
        foreach ($products as $product) {
            $results[] = [
                'id' => $product->id,
                'name' => $product->translation->name ?? '',
                'image' => asset($product->image),
                'price' => number_format($product->current_price, 2) . ' ج.م',
                'url' => url('ar/product/' . $product->id . '/' . ($product->translation->slug ?? ''))
            ];
        }

        return response()->json($results);
    }

    public function index(Request $request, $category_slug = null)
    {
        // Handle named routes for filtering
        if (Route::currentRouteName() == 'frontend.latest-products') {
            $request->merge(['sort' => 'latest']);
        } elseif (Route::currentRouteName() == 'frontend.best-sellers') {
            $request->merge(['best_seller' => 1]);
        }

        $query = Product::active()->with(['translation', 'brand.translation']);

        // Filter by Category Slug
        $category = null;
        if (!$category_slug && $request->filled('category')) {
            $category_slug = $request->category;
        }

        if ($category_slug) {
            $category = \App\Models\Category::whereHas('translations', function ($q) use ($category_slug) {
                $q->where('slug', $category_slug);
            })->with('translation', 'children')->firstOrFail();

            $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('id', $categoryIds);
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
            $query->whereIn('product_brand_id', $request->brands);
        }

        // Filter by Characteristics (Options)
        if ($request->filled('options')) {
            foreach ($request->options as $optionId => $valueIds) {
                $query->whereHas('productOptions.values', function ($q) use ($valueIds) {
                    $q->whereIn('option_value_id', $valueIds);
                });
            }
        }

        // Filter by Best Seller
        if ($request->has('best_seller')) {
            $query->where('is_best_seller', 1);
        }

        // Filter by Flash Sale (General or Specific)
        if ($request->filled('flash_sale_id')) {
            $query->whereHas('flashSales', function ($q) use ($request) {
                $q->where('flash_sales.id', $request->flash_sale_id)
                  ->where('start_at', '<=', Carbon::now())
                  ->where('end_at', '>=', Carbon::now())
                  ->where('is_active', 1);
            });
        } elseif ($request->has('flash_sale')) {
            $query->whereHas('flashSales', function ($q) {
                $q->where('start_at', '<=', Carbon::now())
                  ->where('end_at', '>=', Carbon::now())
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

        $products = $query->paginate(12)->withQueryString();

        // Data for Filters (Only show items that have products)
        $brands = ProductBrand::active()->whereHas('products')->with('translation')->get();

        $options = Option::whereHas('values', function ($q) {
            $q->whereHas('productOptionValues');
        })->with([
                    'translation',
                    'values' => function ($q) {
                        $q->whereHas('productOptionValues')->with('translation');
                    }
                ])->get();

        $minPrice = Product::min('price') ?? 0;
        $maxPrice = Product::max('price') ?? 10000;

        // User Data for UI (Cart/Wishlist)
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = $request->cookie('temp_user_id');

        $cartProducts = Cart::where(function ($q) use ($userId, $tempUserId) {
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

        $wishlistIds = Wishlist::where(function ($q) use ($userId, $tempUserId) {
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

        $categoryAds = collect();
        if ($category) {
            // Note: Since category_id was removed from schema as per earlier steps, we can't filter by category_id directly if we don't have it.
            // However, the user said "remove category_id" from the table.
            // If we want "category ads matching current category", we might need to rely on 'location' = 'category' and maybe some other way?
            // Or maybe the user meant "remove the foreign key constraint" but keep the column?
            // Re-reading: "modified... removing category_id from advertisements".
            // So we can only filter by location = 'category'. 
            // If the user wants SPECIFIC category ads, they can't do it with the current schema.
            // I will return ALL 'category' ads for now as "Category Page Ads".
            // Wait, the seeder created 'category' location ads.
            $categoryAds = \App\Models\Advertisement::where('location', 'category')->active()->get();
        } else {
             // Maybe show them on the main shop page too if desired? Defaulting to empty or generic 'category' ads?
             // Let's show them on main shop page too as "General Shop Ads" if location is 'category'.
             $categoryAds = \App\Models\Advertisement::where('location', 'category')->active()->get();
        }

        // Fetch active Flash Sales for Sidebar Filter
        $activeFlashSales = FlashSale::where('start_at', '<=', Carbon::now())
            ->where('end_at', '>=', Carbon::now())
            ->where('is_active', 1)
            ->with('translation')
            ->get();

        return view('frontend.products.index', compact('products', 'brands', 'options', 'minPrice', 'maxPrice', 'cartProducts', 'wishlistIds', 'category', 'categoryAds', 'activeFlashSales'));
    }
    public function show($id, $slug = null)
    {
        $product = Product::active()
            ->with([
                'translation',
                'translations',
                'images',
                'categories.translation', // Eager load category translations
                'brand.translation',
                'vendor', // If needed
                'productOptions.option.translation',
                'productOptions.values.optionValue.translation',
                // 'reviews.user', // If reviews exist
                'relatedProducts.translation',
                'relatedProducts.images' // To show related product images
            ])
            ->findOrFail($id);

        // Redirect if slug is mismatch (optional SEO improvement, skipping for now to keep it simple or implement if strict)
        // if ($slug && $product->translation->slug !== $slug) { ... }

        $relatedProducts = $product->relatedProducts;

        // User Data for UI (Cart/Wishlist) - Reuse logic or share via ViewComposer later
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = request()->cookie('temp_user_id');

        $cartProducts = Cart::where(function ($q) use ($userId, $tempUserId) {
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

        $wishlistIds = Wishlist::where(function ($q) use ($userId, $tempUserId) {
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

        return view('frontend.products.show', compact('product', 'relatedProducts', 'cartProducts', 'wishlistIds'));
    }
    public function rate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if user purchased AND received the product
        $hasPurchased = $user->orders()
            ->where('status', 3) // 3 = Received/Delivered
            ->whereHas('order_details', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->exists();

        if (!$hasPurchased) {
             return redirect()->back()->with('error', __('website.You must purchase and receive this product to rate it'));
        }

        // Check if user already rated this product
        $existingRating = \App\Models\Rating::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($existingRating) {
             return redirect()->back()->with('error', __('website.You have already rated this product'));
        }

        $rating = \App\Models\Rating::create(
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => true,
            ]
        );

        // Notify admins if it's a new rating or updated
        $admins = \App\Models\Admin::where('status', 1)->get();
        foreach($admins as $admin) {
            $admin->notify(new \App\Notifications\NewRatingNotification($rating));
        }

        return redirect()->back()->with('success', __('website.Rating submitted successfully'));
    }
    public function getMoreReviews(Request $request)
    {
        $input = $request->all();
        $skip = $input['skip'] ?? 0;
        $take = 5;
        
        $product = Product::findOrFail($input['product_id']);
        
        $ratings = $product->ratings()
            ->where('status', 1)
            ->with('user')
            ->latest()
            ->skip($skip)
            ->take($take)
            ->get();
            
        $view = view('frontend.products.partials.reviews_list', compact('ratings'))->render();
        
        return response()->json(['html' => $view, 'count' => $ratings->count()]);
    }
}
