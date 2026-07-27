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
use App\Models\OrderDetail;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *  الصفحة الرئيسية لتطبيق الهاتف المحمول
 * 
 * يوفر الواجهات الخاصة بجلب كافة محتويات الصفحة الرئيسية مثل السلايدرز، الأقسام، العروض،
 * الفلاش سيل، المنتجات المميزة، الأكثر مبيعاً، العلامات التجارية، قسم لماذا تختارنا، وتحميل الكتالوج.
 */
class HomeController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * الصفحة الرئيسية
     * 
     * يجلب جميع البيانات المدمجة المطلوبة لعرض الصفحة الرئيسية في تطبيق الهاتف المحمول:
     * - السلايدرز (sliders)
     * - الأقسام المتاحة للعرض في الصفحة الرئيسية (categories / home_categories)
     * - التخفيضات السريعة (flash_sales / flashdeals)
     * - العروض الخاصة والبنرات (offers / top_offers)
     * - المنتجات المميزة والخاصة (featured_products / features)
     * - الأكثر مبيعاً المحسوبة بناءً على الطلبات الفعلية (top_sellers / topSeller)
     * - العلامات التجارية والشركات المصنعة (brands / partners)
     * - قسم لماذا تختار EG Medical (why_choose_us)
     * - قسم تحميل الكتالوج الطبي بصيغة PDF (catalog_download)
     */
    public function index()
    {
        $data = [];

        // 1. شرائح العرض (Sliders) - تحتوي على Title, Description, Link, Image
        $sliders = Slider::active()->orderBy('sort_order')->with(['translation', 'category'])->get();
        $data['sliders'] = SliderResource::collection($sliders);

        // 2. الأقسام المتاحة للعرض في الصفحة الرئيسية (Home Categories) - اختيار الأقسام التي تم تحديدها للعرض على الرئيسية
        $mainCategories = Category::active()
            ->whereNull('parent_id')
            ->where('show_on_home', true)
            ->with(['translation', 'children.translation'])
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        // Fallback: إذا لم تتوفر أقسام مفعّلة بـ show_on_home، جلب الأقسام الرئيسية المتاحة
        if ($mainCategories->isEmpty()) {
            $mainCategories = Category::active()
                ->whereNull('parent_id')
                ->with(['translation', 'children.translation'])
                ->withCount('products')
                ->orderBy('sort_order')
                ->get();
        }

        $data['categories'] = CategoryResource::collection($mainCategories);
        $data['home_categories'] = CategoryResource::collection($mainCategories);

        // 3. الأقسام الفرعية (Sub Categories)
        $data['sub_categories'] = CategoryResource::collection(
            Category::active()->whereNotNull('parent_id')->with(['translation', 'parent'])->withCount('products')->orderBy('sort_order')->get()
        );

        // 4. قسم التخفيضات السريعة (Flash Sale Module & Products)
        $activeFlashSale = FlashSale::where('is_active', 1)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->with(['translation', 'products.translation', 'products.brand.translation'])
            ->orderBy('start_at', 'asc')
            ->first();

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
            ->take(10)
            ->get();
            
        $data['flash_sales'] = ProductResource::collection($flashProducts);
        $data['flash_sale_module'] = $activeFlashSale ? new FlashSaleResource($activeFlashSale) : null;

        // 5. العروض والبنرات (Offers) - تحتوي على Image, Title, Description, Link
        $offers = Offer::active()
            ->orderBy('sort_order')
            ->with(['translation', 'category.translation'])
            ->get();
        $data['offers'] = OfferResource::collection($offers);

        // 6. المنتجات المميزة والعروض الخاصة (Featured Products / Special Offers)
        // أي منتج مفعّل عليه خيار المعروضات الخاصة أو العرض على الرئيسية
        $featuredProducts = Product::active()
            ->where(function($q) {
                $q->where('show_on_home', 1)
                  ->orWhere(function($sq) {
                      $sq->whereNotNull('special_price')
                         ->where('special_price', '>', 0)
                         ->where(function($dq) {
                             $dq->whereNull('special_price_start')->orWhere('special_price_start', '<=', now());
                         })
                         ->where(function($dq) {
                             $dq->whereNull('special_price_end')->orWhere('special_price_end', '>=', now());
                         });
                  });
            })
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
            }])
            ->take(10)
            ->get();
        $data['featured_products'] = ProductResource::collection($featuredProducts);

        // 7. الأكثر مبيعاً (Top Sellers) - استخراج المنتجات الأكثر طلباً ديناميكياً من جدول تفاصيل الطلبات order_details
        $topSoldProductIds = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->pluck('product_id')
            ->toArray();

        if (!empty($topSoldProductIds)) {
            $topSellerProducts = Product::active()
                ->whereIn('id', $topSoldProductIds)
                ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                    $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
                }])
                ->get()
                ->sortBy(function($model) use ($topSoldProductIds) {
                    return array_search($model->id, $topSoldProductIds);
                })
                ->values();
        } else {
            // في حال عدم وجود طلبات بعد، يتم جلب المنتجات المحددة كأكثر مبيعاً أو أحدث المنتجات
            $topSellerProducts = Product::active()
                ->where('is_best_seller', true)
                ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                    $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
                }])
                ->take(10)
                ->get();
        }
        $data['top_sellers'] = ProductResource::collection($topSellerProducts);

        // 8. أحدث المنتجات المضافة (Latest Products)
        $latestProducts = Product::active()
            ->latest()
            ->with(['translation', 'brand.translation', 'flashSales' => function($q) {
                $q->where('start_at', '<=', now())->where('end_at', '>=', now())->where('is_active', 1)->with('translation');
            }])
            ->take(10)
            ->get();
        $data['latest_products'] = ProductResource::collection($latestProducts);

        // 9. العلامات التجارية شركاء النجاح (Brands) - تحتوي على Title و Image
        $brands = ProductBrand::active()->orderBy('sort_order')->withCount('products')->get();
        $data['brands'] = BrandResource::collection($brands);
        $data['partners'] = $data['brands'];

        // 10. قسم لماذا تختارنا (Why Choose Us) - مميزات الخدمة والشركة
        $setting = Setting::first();
        $data['why_choose_us'] = [
            'title' => $setting ? ($setting->translate('why_choose_us_title') ?: 'لماذا تختار EG Medical؟') : 'لماذا تختار EG Medical؟',
            'subtitle' => $setting ? ($setting->translate('why_choose_us_subtitle') ?: 'نحن نضع معايير جديدة للموثوقية والأمان في توفير المستلزمات والأجهزة الطبية') : 'نحن نضع معايير جديدة للموثوقية والأمان في توفير المستلزمات والأجهزة الطبية',
            'items' => [
                [
                    'id' => 1,
                    'icon' => 'shield_check',
                    'title' => 'منتجات أصلية 100%',
                    'description' => 'مستوردة مباشرة من المصنعين العالميين المعتمدين.',
                ],
                [
                    'id' => 2,
                    'icon' => 'award',
                    'title' => 'موزع رسمي معتمد',
                    'description' => 'الوكيل والموزع المعتمد لأكبر ماركات الأجهزة الطبية.',
                ],
                [
                    'id' => 3,
                    'icon' => 'stethoscope',
                    'title' => 'استشارات طبية متخصصة',
                    'description' => 'مهندسون متخصصون لمساعدتك في اختيار الجهاز المناسب.',
                ],
                [
                    'id' => 4,
                    'icon' => 'wrench',
                    'title' => 'ضمان وصيانة معتمدة',
                    'description' => 'ضمان الوكيل الشامل وتوافر قطع الغيار الأصلية والصيانة.',
                ],
            ]
        ];

        // 11. قسم تحميل الكتالوج الطبي بصيغة PDF (Catalog Download)
        $data['catalog_download'] = [
            'title' => $setting ? ($setting->translate('catalog_title') ?: 'حمّل كتالوج المنتجات الطبية الكامل') : 'حمّل كتالوج المنتجات الطبية الكامل',
            'description' => $setting ? ($setting->translate('catalog_description') ?: 'استعرض أكثر من 10,000 منتج طبي. مثالي للمستشفيات، العيادات، وطلبات الجملة.') : 'استعرض أكثر من 10,000 منتج طبي. مثالي للمستشفيات، العيادات، وطلبات الجملة.',
            'button_text' => 'تحميل الكتالوج بصيغة PDF',
            'pdf_url' => ($setting && $setting->catalog_pdf) ? asset($setting->catalog_pdf) : asset('storage/medical_catalog.pdf'),
        ];

        // 12. الإعلانات البنريّة في الصفحة الرئيسية
        $data['home_ads'] = AdvertisementResource::collection(
            Advertisement::where('location', 'home')->active()->with(['translation'])->get()
        );

        // 13. المقالات الأخيرة في المدونة
        $data['blogs'] = BlogResource::collection(
            Blog::active()->with('BlogTranslation')->latest()->take(3)->get()
        );

        // التوافق المباشر مع الإصدارات السابقة للتطبيق (Legacy Keys mapping)
        $legacyData = [
            'slider' => $data['sliders'],
            'offers' => $data['offers'],
            'top_offers' => $data['offers'],
            'categories' => $data['categories'],
            'brands' => $data['brands'],
            'latestProducts' => $data['latest_products'],
            'topSeller' => $data['top_sellers'],
            'best_sellers' => $data['top_sellers'],
            'flashdeals' => $data['flash_sales'],
            'mostviewedProducts' => $data['top_sellers'],
            'features' => $data['featured_products'],
        ];

        $responseData = array_merge($data, $legacyData);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'error' => null,
            'code' => '200'
        ], 200);
    }

    /**
     * جلب قائمة عروض التخفيضات السريعة (فلاش سيل)
     * 
     * يعيد قائمة بجميع حملات الفلاش سيل المتاحة والقادمة مع المنتجات المدرجة بها.
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
