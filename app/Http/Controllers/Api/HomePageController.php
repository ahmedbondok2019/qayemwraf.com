<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductsController;
use App\Http\Resources\brands\brands;
use App\Http\Resources\categories\categories;
use App\Http\Resources\offers;
use App\Http\Resources\products\flashdeals;
use App\Http\Resources\products\products;
use App\Http\Resources\sliders\sliders;
use App\Models\Brand;
use App\Models\Category;
use App\Models\LogApi;
use App\Models\Offer;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use App\Models\UserApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomePageController extends ApiController
{
    use ApiResponseTrait;

    public function testNotification(Request $request)
    {
        $userFireBaseTokens = UserApiToken::where('user_id', 45)->whereNotNull('firebase_token')
            ->pluck('firebase_token')->toArray();

        $notification = [
            'device_token' => $userFireBaseTokens,
            'title' => 'souqelmlabes',
            'body' => 'متجر '.env('APP_NAME'),
            'id' => 20, 'badge' => 0,
            'click_action' => '/',
        ];

        $result = \App\Http\Controllers\helper\HelperController::pushNotification($notification);
        LogApi::create([
            'url' => $request->url(),
            'body' => $request,
            'fire_base_result' => $result,
            'userFireBaseTokens' => empty($userFireBaseTokens) ? null : json_encode($userFireBaseTokens),
        ]);

        $result = \App\Http\Controllers\helper\HelperController::pushNotification($notification);

        return $result;
    }

    public function index(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $sliders = Slider::whereHas('SliderTranslation')->where('position', 'LIKE', '%3%')->orderByDesc('id')->get();
        $categories = Category::whereHas('CategoryTranslation')->where('parent_id', 0)->orderByDesc('static')->limit(8)->get();
        $brands = Brand::whereHas('BrandTranslations')->where('status', 1)->limit(8)->get();
        $offers = Offer::whereHas('offer_translations')->limit(3)->get();
        $latestProducts = Product::active()->whereHas('translations')->limit(10)->orderByDesc('id')->get();

        // $orders = DB::table('order_details')
        // ->select(DB::raw('count(*) as product_id'))
        // ->groupBy('product_id')
        // ->pluck('product_id');
        $orders = OrderDetail::groupBy('product_id')->pluck('product_id');
        $topSeller = Product::active()->whereIn('id', $orders)
            ->whereDate('best_seller_start', '<=', Carbon::now())
            ->whereDate('best_seller_end', '>=', Carbon::now())
            ->whereHas('translations')->limit(10)->inRandomOrder()
            ->orderByDesc('id')->get();
        $data['flash'] = ProductsController::getFlashSale();
        $flashDeals = Product::active()
            ->whereIn('id', explode(',', $data['flash'][0]))
            ->whereHas('translations')
            ->whereHas('categories')
            ->limit(10)
            ->get();
        // $flashDeals = Product::active()
        //     ->whereDate('deal_of_day_start' , '<=' , Carbon::now())
        //     ->whereDate('deal_of_day_end', '>=' , Carbon::now())
        //     ->whereHas('translations')->limit(10)->orderBy('deal_of_day_end')->get();
        $mostviewedProducts = Product::active()->whereHas('translations')->inRandomOrder()->limit(10)->orderByDesc('views')->get();

        $data = [
            'slider' => sliders::collection($sliders),
            'offers' => offers::collection($offers),
            'categories' => categories::collection($categories),
            'brands' => brands::collection($brands),
            'latestProducts' => products::collection($latestProducts),
            'topSeller' => products::collection($topSeller),
            'flashdeals' => flashdeals::collection($flashDeals),
            'mostviewedProducts' => flashdeals::collection($mostviewedProducts),
        ];

        return $this->NewApiResponse($data, '', 'true', '200');
    }

    public function bestProducts(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $orders = DB::table('order_details')
            ->select(DB::raw('count(*) as product_id'))
            ->groupBy('product_id')
            ->pluck('product_id');

        // dd($orders);
        // $orders = OrderDetail::orderBy(function ($query){
        //         $query->select('product_id')->from('order_details')->count();
        //     },'asc')->pluck('product_id');
        $bestProducts = Product::active()->whereIn('id', $orders)
            ->whereHas('translations')->limit(12)
            ->orderByDesc('id')->get();

        $userFireBaseTokens = UserApiToken::where('user_id', 1)
            ->where('user_type', 1)
            ->whereNotNull('firebase_token')
            ->pluck('firebase_token')->toArray();

        $notification = [
            'device_token' => $userFireBaseTokens,
            'title' => 'store',
            'body' => 'اهلا وسهلا تجربة اشعار جديد',
            'id' => 1, 'badge' => 0,
            'click_action' => '/',
        ];

        $result = \App\Http\Controllers\helper\HelperController::pushNotification($notification);

        return $this->NewApiResponse(products::collection($bestProducts), '', 'true', '200');
    }

    public function topSeller(Request $request)
    {
        $skippedData = intval($request->page_number) * 10 - 10;
        $orders = DB::table('order_details')
            ->select(DB::raw('count(*) as product_id'))
            ->groupBy('product_id')
            ->pluck('product_id');

        $bestProducts = Product::active()->whereIn('id', $orders)
            ->whereHas('translations')->limit(12)
            ->limit(10)->skip($skippedData)
            ->orderByDesc('id')->get();

        return $this->NewApiResponse(products::collection($bestProducts), '', 'true', '200');
    }

    public function latestProducts(Request $request)
    {
        $skippedData = intval($request->page_number) * 10 - 10;
        $latestProducts = Product::active()->whereHas('translations')
            ->limit(12)->orderByDesc('id')
            ->limit(10)->skip($skippedData)
            ->get();

        return $this->NewApiResponse(products::collection($latestProducts), '', 'true', '200');
    }

    public function flashDeals(Request $request)
    {
        $skippedData = intval($request->page_number) * 10 - 10;
        // $flashDeals = Product::active()->where('deal_of_day', '<>', 0)
        //     ->whereDate('deal_of_day_end' , '>', Carbon::now())
        //     ->whereHas('translations')
        //     ->limit(10)->skip($skippedData)
        //     ->orderBy('deal_of_day_end')->get();
        $data['flash'] = ProductsController::getFlashSale();
        $flashDeals = Product::active()
            ->whereIn('id', explode(',', $data['flash'][0]))
            ->whereHas('translations')
            ->whereHas('categories')
            ->limit(10)->skip($skippedData)
            ->get();

        return $this->NewApiResponse(flashdeals::collection($flashDeals), '', 'true', '200');
    }

    public function mostviewedProducts(Request $request)
    {
        $skippedData = intval($request->page_number) * 10 - 10;
        $mostviewedProducts = Product::active()->whereHas('translations')
            ->limit(12)->orderByDesc('views')
            ->limit(10)->skip($skippedData)
            ->get();

        return $this->NewApiResponse(products::collection($mostviewedProducts), '', 'true', '200');
    }

    public function home_brands(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $brands = Brand::whereHas('BrandTranslations')->where('status', 1)->limit(8)->get();

        return $this->NewApiResponse(brands::collection($brands), '', 'true', '200');
    }

    public function home_categories(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $categories = Category::whereHas('CategoryTranslation')->where('parent_id', 0)->limit(8)->get();

        return $this->NewApiResponse(categories::collection($categories), '', 'true', '200');
    }

    public function home_offer(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $offers = Offer::whereHas('offer_translations')->limit(3)->get();

        return $this->NewApiResponse(offers::collection($offers), '', 'true', '200');
    }

    public function slider(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $sliders = Slider::where('position', 'LIKE', '%3%')->orderByDesc('id')->get();

        return $this->NewApiResponse(sliders::collection($sliders), '', 'true', '200');
    }

    public function brands(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $brands = Brand::whereHas('BrandTranslations')->where('status', 1)->get();

        return $this->NewApiResponse(brands::collection($brands), '', 'true', '200');
    }

    public function offers(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $offers = Offer::whereHas('offer_translations')->paginate(10);

        return $this->NewApiResponse(offers::collection($offers), '', 'true', '200');
    }

    public function search(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }
        $skippedData = intval($request->page_number) * 10 - 10;
        $products = Product::active()->whereHas('translations', function ($query) use ($request) {
            $query->where('title', 'LIKE', '%'.$request->title.'%');
        })->limit(12)->orderByDesc('id')->limit(10)->skip($skippedData)->get();

        return $this->NewApiResponse(products::collection($products), '', 'true', '200');
    }

    public function productDetails(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( new \stdClass() ,  __("website.account not found") , 'false', '200');
        // }

        if (! is_numeric($request->id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $product = Product::active()->where('id', $request->id)
            ->with('translations')->with('images')->with('variations')->first();
        if ($product) {
            return $this->NewApiResponse(new products($product), '', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, __('website.Product Not Found'), 'true', '200');
        }
    }

    public function setting(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user = UserApiToken::where('api_token', $token)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( new \stdClass() ,  __("website.account not found") , 'false', '200');
        // }

        $Setting = Setting::first();

        return $this->NewApiResponse(new \App\Http\Resources\home\setting($Setting), '', 'true', '200');
    }
}
