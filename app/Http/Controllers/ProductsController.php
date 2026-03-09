<?php

namespace App\Http\Controllers;

use App\Exports\ProductsCategoryExport;
use App\Http\Controllers\helper\HelperController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Contact;
use App\Models\FlashSale;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\Option;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTranslation;
use App\Models\Rate;
use App\Models\Rating;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use stdClass;

class ProductsController extends WebController
{
    public function index(Request $request, $category = null)
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';
        if ($category != null) {
            $clearText = HelperController::make_slug($category);
            $categoryData = CategoryTranslation::where('slug', str_replace('-', ' ', $clearText))->first();

            if (empty($categoryData) || $categoryData == '' || $categoryData == null) {
                $categoryData = CategoryTranslation::where('slug', $clearText)->firstOrFail();
            }
            $data['activeCategory'] = str_replace('-', ' ', $categoryData->title);
            $secondParent = Category::whereNotNull('show_category')->where('id', $categoryData->category_parent_id)->first();
            if ($secondParent) {
                $data['secondCat'] = optional($secondParent->CategoryTranslation)->title;
                $firstParent = Category::whereNotNull('show_category')->where('id', $secondParent->parent_id)->first();
                if ($firstParent) {
                    $data['firstCat'] = optional($firstParent->CategoryTranslation)->title;
                }
            }
            $data['cat_id'] = $categoryData->category_id;
        }

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        // else{
        //     $categories = $categories->where('parent_id', 0);
        // }
        $ProductCategories = $categories->pluck('id');

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        // else{
        //     $categories = $categories->where('parent_id', 0);
        // }
        // $ProductCategories = $categories->pluck('id')->toArray();

        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $sub = collect();
        if ($categoryData != null) {
            $sub = Category::whereNotNull('show_category')->where('parent_id', $categoryData->category_id)->get();
        }
        $data['sub'] = $sub;

        $ProductCategories = $categories->pluck('id')->toArray();
        if ($categoryData != null) {
            $ProCat = HelperController::GetTree($categoryData->category_id);
            $ProductCategories = collect($ProCat)->unique()->toArray();
        }
        // dd(collect($ProductCategories)->unique()->toArray());
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');

        $data['products'] = Product::active()->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories')
            ->get();

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        if ($category != null) {
            Session::put(['baseEndPoint' => '/products/' . $category]);
        } else {
            Session::put(['baseEndPoint' => '/products']);
        }
        $artilces = '';
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return view('products', $data);
        } else {
            foreach ($data['products'] as $result) {
                $artilces .= view('includes.products-card', ['products' => $result])->render();
            }

            return response()->json([$artilces]);
        }
    }

    public function videos(Request $request, $category = null)
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';
        if ($category != null) {
            $clearText = HelperController::make_slug($category);
            $categoryData = CategoryTranslation::where('slug', str_replace('-', ' ', $clearText))->first();

            if (empty($categoryData) || $categoryData == '' || $categoryData == null) {
                $categoryData = CategoryTranslation::where('slug', $clearText)->firstOrFail();
            }
            $data['activeCategory'] = str_replace('-', ' ', $categoryData->title);
            $secondParent = Category::whereNotNull('show_category')->where('id', $categoryData->category_parent_id)->first();
            if ($secondParent) {
                $data['secondCat'] = optional($secondParent->CategoryTranslation)->title;
                $firstParent = Category::whereNotNull('show_category')->where('id', $secondParent->parent_id)->first();
                if ($firstParent) {
                    $data['firstCat'] = optional($firstParent->CategoryTranslation)->title;
                }
            }
            $data['cat_id'] = $categoryData->category_id;
        }

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        // else{
        //     $categories = $categories->where('parent_id', 0);
        // }
        $ProductCategories = $categories->pluck('id');

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        // else{
        //     $categories = $categories->where('parent_id', 0);
        // }
        // $ProductCategories = $categories->pluck('id')->toArray();

        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $sub = collect();
        if ($categoryData != null) {
            $sub = Category::whereNotNull('show_category')->where('parent_id', $categoryData->category_id)->get();
        }
        $data['sub'] = $sub;

        $ProductCategories = $categories->pluck('id')->toArray();
        if ($categoryData != null) {
            $ProCat = HelperController::GetTree($categoryData->category_id);
            $ProductCategories = collect($ProCat)->unique()->toArray();
        }
        // dd(collect($ProductCategories)->unique()->toArray());
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');

        $data['products'] = Product::active()->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories')
            ->get();

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        if ($category != null) {
            Session::put(['baseEndPoint' => '/videos/products/' . $category]);
        } else {
            Session::put(['baseEndPoint' => '/videos/products']);
        }
        $artilces = '';
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return view('videos', $data);
        } else {
            foreach ($data['products'] as $result) {
                $artilces .= view('includes.products-video', ['products' => $result])->render();
            }

            return response()->json([$artilces]);
        }
    }

    public function latest(Request $request)
    {
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';

        $data['Allcategories'] = Category::whereNotNull('show_category')->whereHas('CategoryTranslation')->get();
        $data['sub'] = collect();

        $ProductCategories = $data['Allcategories']->pluck('id')->toArray();
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');

        $data['products'] = Product::active()->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories')
            ->orderByDesc('id')
            ->get();


        $offers = Offer::query();
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();
        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        Session::put(['baseEndPoint' => '/latest']);

        $artilces = '';
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return view('products', $data);
        } else {
            foreach ($data['products'] as $result) {
                $artilces .= view('includes.products-card', ['products' => $result])->render();
            }

            return response()->json([$artilces]);
        }
    }

    public function best_seller(Request $request)
    {
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';

        $categories = Category::whereNotNull('show_category');

        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $ProductCategories = $categories->pluck('id')->toArray();
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');
        $categories = Category::whereNotNull('show_category')->pluck('id');
        $bestOrder = OrderDetail::select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->pluck('count', 'product_id'); // Pluck to get [product_id => count]

        $productsQuery = Product::active()
            ->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories');

        // Only apply custom ordering if there are bestseller products
        if ($bestOrder->isNotEmpty()) {
            $productsQuery->whereIn('id', $bestOrder->keys())
                ->orderByRaw('FIELD(id, ' . implode(',', $bestOrder->keys()->toArray()) . ')');
        }

        $data['products'] = $productsQuery->get();

        $data['sub'] = collect();
        $offers = Offer::query();
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        Session::put(['baseEndPoint' => '/best_seller']);
        $artilces = '';
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return view('products', $data);
        } else {
            foreach ($data['products'] as $result) {
                $artilces .= view('includes.products-card', ['products' => $result])->render();
            }

            return response()->json([$artilces]);
        }
    }

    public function ajaxData(Request $request, $category = null)
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';
        if ($category != null) {
            $clearText = HelperController::make_slug($category);
            $categoryData = CategoryTranslation::where('slug', str_replace('-', ' ', $clearText))->first();

            if (empty($categoryData) || $categoryData == '' || $categoryData == null) {
                $categoryData = CategoryTranslation::where('slug', $clearText)->firstOrFail();
            }
            $data['activeCategory'] = str_replace('-', ' ', $categoryData->title);
            $secondParent = Category::whereNotNull('show_category')->where('id', $categoryData->category_parent_id)->first();
            if ($secondParent) {
                $data['secondCat'] = optional($secondParent->CategoryTranslation)->title;
                $firstParent = Category::whereNotNull('show_category')->where('id', $secondParent->parent_id)->first();
                if ($firstParent) {
                    $data['firstCat'] = optional($firstParent->CategoryTranslation)->title;
                }
            }
            $data['cat_id'] = $categoryData->category_id;
        }

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        $ProductCategories = $categories->pluck('id');

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $sub = collect();
        if ($categoryData != null) {
            $sub = Category::whereNotNull('show_category')->where('parent_id', $categoryData->category_id)->get();
        }
        $data['sub'] = $sub;

        $ProductCategories = $categories->pluck('id')->toArray();
        if ($categoryData != null) {
            $ProCat = HelperController::GetTree($categoryData->category_id);
            $ProductCategories = collect($ProCat)->unique()->toArray();
        }
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');

        $Page = json_decode($request->getContent(), true);
        $data['products'] = Product::active()->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories')
            ->limit(15)->skip($Page['page'] * 15)
            ->get();

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        if ($category != null) {
            Session::put(['baseEndPoint' => '/products/' . $category]);
        } else {
            Session::put(['baseEndPoint' => '/products']);
        }

        return response()->json([
            'html' => view('includes.products-card', ['products' => $data['products']])->render(),
        ]);
    }

    public function ajaxDataVideo(Request $request, $category = null)
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';
        if ($category != null) {
            $clearText = HelperController::make_slug($category);
            $categoryData = CategoryTranslation::where('slug', str_replace('-', ' ', $clearText))->first();

            if (empty($categoryData) || $categoryData == '' || $categoryData == null) {
                $categoryData = CategoryTranslation::where('slug', $clearText)->firstOrFail();
            }
            $data['activeCategory'] = str_replace('-', ' ', $categoryData->title);
            $secondParent = Category::whereNotNull('show_category')->where('id', $categoryData->category_parent_id)->first();
            if ($secondParent) {
                $data['secondCat'] = optional($secondParent->CategoryTranslation)->title;
                $firstParent = Category::whereNotNull('show_category')->where('id', $secondParent->parent_id)->first();
                if ($firstParent) {
                    $data['firstCat'] = optional($firstParent->CategoryTranslation)->title;
                }
            }
            $data['cat_id'] = $categoryData->category_id;
        }

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        $ProductCategories = $categories->pluck('id');

        $categories = Category::whereNotNull('show_category');
        if ($categoryData != null) {
            $categories = $categories->where('id', $categoryData->category_id)
                ->orwhere('parent_id', $categoryData->category_id);
        }
        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $sub = collect();
        if ($categoryData != null) {
            $sub = Category::whereNotNull('show_category')->where('parent_id', $categoryData->category_id)->get();
        }
        $data['sub'] = $sub;

        $ProductCategories = $categories->pluck('id')->toArray();
        if ($categoryData != null) {
            $ProCat = HelperController::GetTree($categoryData->category_id);
            $ProductCategories = collect($ProCat)->unique()->toArray();
        }
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)
            ->pluck('product_id');

        $Page = json_decode($request->getContent(), true);
        $data['products'] = Product::active()->whereIn('id', $ProductCat)
            ->whereHas('translations')
            ->whereHas('categories')
            ->limit(15)->skip($Page['page'] * 15)
            ->get();

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        if ($category != null) {
            Session::put(['baseEndPoint' => '/videos/products/' . $category]);
        } else {
            Session::put(['baseEndPoint' => '/videos/products']);
        }

        return response()->json([
            'html' => view('includes.products-video', ['products' => $data['products']])->render(),
        ]);
    }

    public function brands($category = null)
    {
        $offers = Offer::query();
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->where('status', 1)->paginate(40);

        return view('brands', $data);
    }

    public function brands_details(Request $request, $brands = null)
    {
        if (is_numeric($request->id)) {
            $data['firstCat'] = '';
            $data['secondCat'] = '';
            $data['activeCategory'] = '';

            $categories = Category::whereNotNull('show_category')->pluck('id');

            $data['sub'] = collect();

            $data['Allcategories'] = Category::whereNotNull('show_category')->whereHas('CategoryTranslation')->get();
            $ProductCat = ProductCategory::whereIn('category_id', $categories)->pluck('product_id');
            $data['products'] = Product::active()
                ->whereIn('id', $ProductCat)
                ->where('brand_id', $request->id)
                ->whereHas('translations')
                ->whereHas('categories')
                ->paginate(28);

            $data['offers'] = Offer::whereHas('offer_translations', function ($queries) {
                $queries->where('position', 4);
            })->get();

            if ($request->id != null) {
                Session::put(['baseEndPoint' => '/brand/' . $request->id . '/' . $brands]);
            } else {
                Session::put(['baseEndPoint' => '/brands']);
            }
            $artilces = '';
            if ($request->ajax()) {
                foreach ($data['products'] as $result) {
                    $artilces .= view('includes.products-card', ['product' => $result])->render();
                }

                return $artilces;
            }

            $data['brands'] = Brand::whereHas('BrandTranslations')->where('status', 1)->get();
            $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

            return view('products', $data);
        } else {
            return redirect()->back();
        }
    }

    public function flash_deals(Request $request)
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';

        $flashdeals = self::getFlashSale($request->day);
        $data['days'] = $flashdeals[1];
        $data['days_route'] = $flashdeals[3];
        $data['products'] = Product::active()
            ->whereIn('id', explode(',', $flashdeals[0]))
            // ->where('deal_of_day', 1)
            // ->whereDate('deal_of_day_start' , '<=' , Carbon::now())
            // ->whereDate('deal_of_day_end', '>=' , Carbon::now())
            ->whereHas('translations')
            ->whereHas('categories')
            ->paginate(28);

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        Session::put(['baseEndPoint' => '/flash_deals']);
        $artilces = '';
        if ($request->ajax()) {
            foreach ($data['products'] as $result) {
                // $artilces.='<div class="card mb-2"> <div class="card-body">'.$result->id.' <h5 class="card-title">'.$result->post_name.'</h5> '.$result->post_description.'</div></div>';
                $artilces .= '<div class="big-box col-sm-6 col-lg-4 col-xl-3 mb-3 ">';
                $artilces .= view('includes.product-card-flash', ['product' => $result, 'show' => false]);
                $artilces .= '</div>';
            }

            return $artilces;
        }

        return view('products', $data);
    }

    public static function getFlashSale($day = null)
    {
        $proIDS = '';
        $data['days'] = [];
        $data['days_route'] = [];
        $data['percentage'] = [];
        $flashdeals = FlashSale::all();

        foreach ($flashdeals as $key => $deals) {
            $startDate = Carbon::parse($deals->valid_from);
            $endDate = Carbon::parse($deals->valid_to);
            if (isset($day) && self::isValidDateFormat($day, 'd-M')) {
                $checkDate = ($day == null ? Carbon::now() : Carbon::createFromFormat('d-M', $day));
            } else {
                $checkDate = Carbon::now('Africa/Cairo');
            }

            if ($checkDate->between($startDate, $endDate)) {
                $proIDS .= ',' . implode(',', collect($deals->sale_products)->pluck('product_id')->toArray());
                // $data['days'][] = Carbon::createFromFormat('Y-m-d H:i:s' , $deals->valid_from)->format('d M');
                $data['percentage'] = $deals->percentage;
                $dates = CarbonPeriod::create($startDate, $endDate);

                foreach ($dates as $date) {
                    if (! in_array($date->format('M d'), $data['days']) && $checkDate < $date) {
                        $data['days'][] = $date->format('d ') . HelperController::GetMonth($date->format('M'));
                        $data['days_route'][] = $date->format('d-M');
                    }
                }
            }

            if ($checkDate > $endDate) {
                // $deals->delete();
                unset($flashdeals[$key]);
            }
        }

        return [
            $proIDS,
            array_unique($data['days']),
            $data['percentage'],
            array_unique($data['days_route']),
        ];
    }

    public static function isValidDateFormat($dateString, $format)
    {
        $carbonDate = Carbon::createFromFormat($format, $dateString);

        return $carbonDate !== false && $carbonDate->format($format) === $dateString;
    }

    public function hot_deals()
    {
        $categoryData = null;
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';

        $data['products'] = Product::active()->where('hot_deals', 1)
            ->whereHas('translations')
            ->whereHas('categories')
            ->paginate(28);

        $offers = Offer::query();
        if ($categoryData != null) {
            $offers = $offers->whereHas('offer_translations', function ($query) use ($categoryData) {
                $query->where('category', $categoryData->category_id);
            });
        }
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();

        return view('products', $data);
    }

    public function product_details(Request $request)
    {
        if (is_numeric($request->id)) {
            $data = self::getProductData($request);

            return view('product-details', $data);
        } else {
            if (isset($request->short_url)) {
                $data = self::getProductData($request);

                return view('product-details', $data);
            }
        }

        return redirect()->back();
    }

    public function short_urls(Request $request)
    {
        // return Excel::download(new ProductsExport(), 'products.csv');
        return Excel::download(new ProductsCategoryExport, 'products.xls');
    }

    public static function getProductData(Request $request)
    {
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';
        if ($request->category != null) {
            $clearText = HelperController::make_slug($request->category);
            $categoryData = CategoryTranslation::where('title', str_replace('-', ' ', $clearText))->firstOrFail();
            $data['activeCategory'] = str_replace('-', ' ', $clearText);
            $secondParent = Category::whereNotNull('show_category')->where('id', $categoryData->category_parent_id)->first();
            if ($secondParent) {
                $data['secondCat'] = optional($secondParent->CategoryTranslation)->title;
                $firstParent = Category::whereNotNull('show_category')->where('id', $secondParent->parent_id)->first();
                if ($firstParent) {
                    $data['firstCat'] = optional($firstParent->CategoryTranslation)->title;
                }
            }
        }
        $data['product'] = Product::active();
        if (isset($request->id)) {
            $data['product'] = $data['product']->where('id', $request->id);
        }
        if (isset($request->short_url)) {
            $data['product'] = $data['product']->where('short_url', $request->short_url);
        }
        $data['product'] = $data['product']->whereHas('translations')
            ->with('images')
            ->with('options')
            ->with('option_items')
            ->with('rates')
            ->with('categories')
            ->with('related')
            ->firstOrFail();

        $data['product']->update(['views' => $data['product']->views + 1]);
        $data['product']->slug == null || $data['product']->slug == '' ? $data['product']->update(['slug' => HelperController::make_slug($request->title)]) : '';

        return $data;
    }

    public function search_products(Request $request)
    {
        try {
            $request->validate([
                'keywords' => ['required', 'string', 'min:3', 'max:30'],
                // 'page' => ['required', 'integer']
            ]);

            $keyword = str_replace(' ', '-', $request->keywords);

            return redirect(LaravelLocalization::localizeUrl('products/search/' . $keyword . '/0'));
        } catch (ValidationException $e) {
            // return new JsonResponse([
            //     'success' => false,
            //     'errors' => $e->errors(),
            //     'message' => 'Validation errors occurred',
            // ], 422);
            return redirect()->back();
        }
    }

    public function product_result(Request $request)
    {
        $keyword = str_replace('<', ' ', $request->keyword);
        $keyword = str_replace('>', ' ', $keyword);
        $keyword = str_replace('?', ' ', $keyword);
        $keyword = str_replace('/', ' ', $keyword);
        $keyword = str_replace('-', ' ', $keyword);

        $IDS = ProductTranslation::whereLike('title', $keyword ?? '')->pluck('product_id');
        $data['products'] = Product::active()->whereHas('translations')
            ->whereIn('id', $IDS)->orderByDesc('id')->limit(9)->skip($request->page * 15)->get();

        $data['keyword'] = $request->keyword;
        $offers = Offer::whereHas('offer_translations');
        $data['offers'] = $offers->whereHas('offer_translations', function ($queries) {
            $queries->where('position', 4);
        })->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::whereHas('translations')->whereHas('option_items')->get();
        $data['firstCat'] = '';
        $data['secondCat'] = '';
        $data['activeCategory'] = '';

        Session::put(['baseEndPoint' => '/products/search/' . $keyword]);

        if ($request->method() !== 'POST') {
            return view('products', $data);
        } else {
            return response()->json([
                'html' => view('includes.products-card', ['products' => $data['products']])->render(),
            ]);
        }
    }

    public function ajax_search(Request $request)
    {
        // if(isset($request->price) && isset($request->search_statement))
        // {
        $search_statement = $request->search_statement;
        $Options = [];
        $Brands = [];
        $Rate = [];
        // change the value from string to array.
        if (! empty($request->selectedBrands) && $request->selectedBrands != '') {
            $pairs = $request->selectedBrands;
            $Brands = explode(',', $pairs);
        }
        if (! empty($request->selectedOptions) && $request->selectedOptions != '') {
            $pairs = $request->selectedOptions;
            $Options = explode(',', $pairs);
        }
        if (! empty($request->selectedRate) && $request->selectedRate != '') {
            $pairs = $request->selectedRate;
            $Rate = explode(',', $pairs);
        }
        if (! empty($request->max_value) && ! empty($request->min_value)) {
            $max = $request->max_value;
            $min = $request->min_value;
        } else {
            $max = $request->max;
            $min = $request->min;
        }

        $keyword = str_replace('-', ' ', HelperController::make_slug($search_statement));

        $data['products'] = Product::active();
        if (! empty($keyword)) {
            $data['products'] = $data['products']->whereHas('translations', function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            });
        }

        if (! empty($min) && ! empty($max)) {
            $data['products'] = $data['products']->whereBetween('price', [$min, $max]);
        }
        if (! empty($Options)) {
            $data['products'] = $data['products']->whereHas('option_items', function ($query) use ($Options) {
                $query->whereIn('id', $Options);
            });
        }

        if (! empty($Rate)) {
            $data['products'] = $data['products']->whereHas('rates', function ($query) use ($Rate) {
                $query->where('rating', $Rate);
            });
        }
        if (! empty($Brands)) {
            $data['products'] = $data['products']->whereIn('brand_id', $Brands);
        }
        if (! empty($request->price)) {
            switch ($request->price) {
                case '1':
                    $data['products'] = $data['products']->orderbyDesc('created_at');
                    break;
                case '2':
                    $data['products'] = $data['products']->orderby('created_at');
                    break;
                case '3':
                    $data['products'] = $data['products']->orderby('price');
                    break;
                case '4':
                    $data['products'] = $data['products']->orderbyDesc('price');
                    break;
                default:
                    $data['products'] = $data['products']->orderbyDesc('created_at');
                    break;
            }
        }
        $products = $data['products']->whereHas('translations')->with('images')->get();

        return response()->json([
            'grid' => view('includes.products-card', ['products' => $products, 'activeCategory' => $request->activeCategory])->render(),
        ]);
        // }
    }

    public function ajax_category(Request $request)
    {
        $product_category = $request->categories_id;
        $Options = [];
        $Brands = [];
        $Rate = [];
        // change the value from string to array.
        if (! empty($request->selectedBrands) && $request->selectedBrands != '') {
            $pairs = $request->selectedBrands;
            $Brands = explode(',', $pairs);
        }
        if (! empty($request->selectedOptions) && $request->selectedOptions != '') {
            $pairs = $request->selectedOptions;
            $Options = explode(',', $pairs);
        }
        if (! empty($request->selectedRate) && $request->selectedRate != '') {
            $pairs = $request->selectedRate;
            $Rate = explode(',', $pairs);
        }
        if (! empty($request->max_value) && ! empty($request->min_value)) {
            $max = $request->max_value;
            $min = $request->min_value;
        } else {
            $max = $request->max;
            $min = $request->min;
        }

        $categories = Category::whereNotNull('show_category');
        if ($request->categories_id != null) {
            $categories = $categories->where('id', $request->categories_id)
                ->orwhere('parent_id', $request->categories_id);
        }
        // else{
        //     $categories = $categories->where('parent_id', 0);
        // }
        $ProductCategories = $categories->pluck('id');

        $data['Allcategories'] = $categories->whereHas('CategoryTranslation')->get();
        $ProductCat = ProductCategory::whereIn('category_id', $ProductCategories)->pluck('product_id');

        $data['products'] = Product::active()->whereIn('id', $ProductCat);
        if (! empty($request->categories_id)) {
            $data['products'] = $data['products']->whereHas('categories', function ($query) use ($product_category) {
                $query->where('category_id', $product_category);
            });
        }
        if (! empty($min) && ! empty($max)) {
            $data['products'] = $data['products']->whereBetween('price', [$min, $max]);
        }
        if (! empty($Options)) {
            $data['products'] = $data['products']->whereHas('option_items', function ($query) use ($Options) {
                $query->whereIn('id', $Options);
            });
        }

        if (! empty($Rate)) {
            $data['products'] = $data['products']->whereHas('rates', function ($query) use ($Rate) {
                $query->where('rating', $Rate);
            });
        }
        if (! empty($Brands)) {
            $data['products'] = $data['products']->whereIn('brand_id', $Brands);
        }
        if (! empty($request->price)) {
            switch ($request->price) {
                case '1':
                    $data['products'] = $data['products']->orderbyDesc('created_at');
                    break;
                case '2':
                    $data['products'] = $data['products']->orderby('created_at');
                    break;
                case '3':
                    $data['products'] = $data['products']->orderby('price');
                    break;
                case '4':
                    $data['products'] = $data['products']->orderbyDesc('price');
                    break;
                default:
                    $data['products'] = $data['products']->orderbyDesc('created_at');
                    break;
            }
        }
        $products = $data['products']->whereHas('translations')->with('images')->get();

        return response()->json([
            'grid' => view('includes.products-card', ['products' => $products, 'activeCategory' => $request->activeCategory])->render(),
        ]);
        // }
    }

    public static function getAjaxArrays($request)
    {
        $Options = [];
        $Brands = [];
        $Rate = [];
        // change the value from string to array.
        if (isset($request->selectedBrands) && $request->selectedBrands != '') {
            $pairs = $request->selectedBrands;
            $Brands = explode(',', $pairs);
        }
        if (isset($request->selectedOptions) && $request->selectedOptions != '') {
            $pairs = $request->selectedOptions;
            $Options = explode(',', $pairs);
        }
        if (isset($request->selectedRate) && $request->selectedRate != '') {
            $pairs = $request->selectedRate;
            $Rate = explode(',', $pairs);
        }
        if (! empty($request->max_value) && ! empty($request->min_value)) {
            $max = $request->max_value;
            $min = $request->min_value;
        } else {
            $max = $request->max;
            $min = $request->min;
        }

        return [$Brands, $Options, $Rate, $min, $max];
    }

    public static function getAjaxSort($request, $data)
    {
        switch ($request->price) {
            case '1':
                $data = $data->orderbyDesc('created_at');
                break;
            case '2':
                $data = $data->orderby('created_at');
                break;
            case '3':
                $data = $data->orderby('price');
                break;
            case '4':
                $data = $data->orderbyDesc('price');
                break;
            default:
                $data = $data->orderbyDesc('created_at');
                break;
        }

        return $data;
    }

    public function contact(Request $request)
    {
        $data = [];
        if (isset($request->keyword)) {
            $data['keyword'] = $request->keyword;
        }

        return view('contact', $data);
    }

    public function sendContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_email' => 'required|email|max:255',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_subject' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['msg' => '<div class="alert alert-danger">' . __('website.All_Required_Fields') . '</div>']
            );
        }

        $test = Contact::where('contact_email', $request->contact_email)
            ->where('message', $request->message)
            ->where('contact_name', $request->contact_name)
            ->where('contact_subject', $request->contact_subject)
            ->first();
        if (empty($test)) {
            Contact::create($request->all());

            return response()->json(['msg' => '<div class="alert alert-success">' . __('website.Send_Successfully') . '</div>']);
        } else {
            return response()->json(['msg' => '<div class="alert alert-danger">' . __('website.Duplicate_Fields') . '</div>']);
        }
    }

    public function product_pdf($fileName = null)
    {
        if ($fileName != null && file_exists(public_path() . '/website/uploads/pdf/' . $fileName)) {
            $file = public_path() . '/website/uploads/pdf/' . $fileName;
            $headers = [
                'Content-Type: application/pdf',
            ];

            return response()->download($file, $fileName, $headers);
        } else {
            alert()->error('file not found', __('dashboard.attention'));

            return redirect()->back();
        }
    }

    public static function getLangWord()
    {
        $text = '';
        switch (app()->getLocale()) {
            case 'ar':
                $text = 'العربية';
                break;
            case 'en':
                $text = 'English';
                break;
            case 'tr':
                $text = 'Türkçe';
                break;
            case 'de':
                $text = 'Deutsch';
                break;
            case 'id':
                $text = 'Bahasa-Indonesia';
                break;
        }

        return $text;
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['newsletter' => '<div class="alert alert-danger alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> check <strong> all inputs.</strong>.</div>']);
        }

        $test = Newsletter::where('email', $request->email)->first();
        if (empty($test)) {
            Newsletter::create($request->all());

            return response()->json(['newsletter' => '<div class="alert alert-success alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Your email <strong> added successfully.</strong>.</div>']);
        } else {
            return response()->json(['newsletter' => '<div class="alert alert-danger alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> your email <strong> sent already no need to send again.</strong>.</div>']);
        }
    }

    public static function replace_lang_alias($alias)
    {
        switch ($alias) {
            case 'ar':
                return 'العربية';
            case 'en':
                return 'english';
            case 'tr':
                return 'Türkçe';
            case 'fr':
                return 'french';
            case 'id':
                return 'Bahasa Indonesia';
            case 'de':
                return 'deutsch';
        }
    }

    public static function getWelcomeTrans()
    {
        switch (app()->getLocale()) {
            case 'ar':
                return 'مرحبا';
            case 'en':
                return 'welcome';
            case 'tr':
                return 'Hoşgeldiniz';
            case 'fr':
                return 'bienvenu';
            case 'id':
                return 'selamat datang';
            case 'de':
                return 'willkommen';
        }
    }

    public function typeahead()
    {
        return view('typeahead');
    }

    public function fetch_product_rating(Request $request)
    {
        $output = '';
        $rating = self::count_rating($request->rowid, $request->order_id, $request->business_id);
        $color = '';
        //  <h3 class="text-primary"> ' . __('dashboard.Rate') . ' :</h3>
        $output .= '<ul class="list-inline" style="display: inline-flex;" data-rating="' . $rating . '" title="Average Rating - ' . $rating . '">';
        for ($count = 1; $count <= 5; $count++) {
            if ($count <= $rating) {
                $color = 'color:#ffcc00;';
            } else {
                $color = 'color:#ccc;';
            }
            $output .= '<li title="' . $count . '" id="' . $request->business_id . '_' . $count . '" data-rowid="' . $request->rowid . '" data-order_id="' . $request->order_id . '" data-index="' . $count . '"  data-business_id="' . $request->business_id . '" data-rating="' . $rating . '" class="rating" style="cursor:pointer;padding: 0.1rem; ' . $color . ' font-size:30px;">&#9733;</li>';
        }
        $output .= '</ul>';

        echo $output;
        // return response()->json([
        //     'data' => $output,
        //     'rowid' => $request->rowid
        // ]);
    }

    public static function fetch_product_rating_static($rowid, $order_id, $business_id)
    {
        echo self::getRate($rowid, $order_id, $business_id);
    }

    public static function count_rating($rowid, $order_id, $business_id)
    {
        $output = 0;
        // /// فى هذه الحالة فقط نضيف هذا الشرط -- غير مطلوب أكثر من تقييم واحد فقط -- للمنتجات يحذف ///////
        $result = rating::select('rating')
            ->where('order_id', $order_id)
            ->where('user_id', Auth::id())
            ->where('product_id', $business_id)
            ->first();
        // /////
        // $result = Rating::select(DB::raw('AVG(rating) as rating'))->where('product_id', $product_id)->get();
        if (isset($result)) {
            $total_row = $result->rating;
            if ($total_row > 0) {
                // foreach($result as $row)
                // {
                $output = round($result->rating);
                // }
            }
        }

        return $output;
    }

    public function insert_rating_product(Request $request)
    {
        $data = json_decode($request->getContent());
        if (isset($data->index, $data->business_id)) {
            $product = Product::find($data->business_id);
            // /// فى هذه الحالة فقط نضيف هذا الشرط -- غير مطلوب أكثر من تقييم واحد فقط -- للمنتجات يحذف ///////
            $test = Rating::where('product_id', $data->business_id)
                ->where('order_id', $data->order_id)
                ->where('user_id', Auth::user()->id);
            if (auth()->check()) {
                $test = $test->where('user_id', Auth::user()->id);
            } else {
                $test = $test->where('visitor_ip', $request->visitor_ip);
            }

            $test = $test->first();
            if (empty($test)) {
                // rating::where('product_id', $request->business_id)->delete();
                Rating::create([
                    'order_id' => $data->order_id,
                    'vendor_id' => $product->vendor_id,
                    'product_id' => $data->business_id,
                    'rating' => $data->index,
                    'notes' => $data->notes ?? '',
                    'user_id' => Auth::user()->id,
                    // 'visitor_ip' => $request->ip(),
                ]);
            }
        }

        return response()->json('done');
    }

    public static function getRate($rowid, $order_id, $business_id)
    {
        $output = '';
        $rating = self::count_rating($rowid, $order_id, $business_id);
        $color = '';
        //  <h3 class="text-primary"> ' . __('dashboard.Rate') . ' :</h3>
        $output .= '<ul class="list-inline" style="display: inline-flex;" data-rating="' . $rating . '" title="Average Rating - ' . $rating . '">';
        for ($count = 1; $count <= 5; $count++) {
            if ($count <= $rating) {
                $color = 'color:#ffcc00;';
            } else {
                $color = 'color:#ccc;';
            }
            $output .= '<li title="' . $count . '" id="' . $business_id . '_' . $count . '" data-rowid="' . $rowid . '" data-order_id="' . $order_id . '" data-index="' . $count . '"  data-business_id="' . $business_id . '" data-rating="' . $rating . '" class="rating" style="cursor:pointer;padding: 0.1rem; ' . $color . ' font-size:30px;">&#9733;</li>';
        }
        $output .= '</ul>';
        echo $output;
    }

    public function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
        }
    }

    public function print(Request $request)
    {
        $data['product'] = Product::find($request->id);

        return view('qr_code', $data);
    }

    public function siteMap(Request $request)
    {
        return view('siteMap');
    }
}
