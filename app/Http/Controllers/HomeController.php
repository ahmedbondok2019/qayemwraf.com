<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\PhoneCheck;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends WebController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verify()
    {
        $testVerfiy = PhoneCheck::where('phone', Auth::user()->phone)->first();
        if (empty($testVerfiy)) {
            return redirect()->route('user.verify')->with('msg', 'الهاتف غير موجود.');
        } else {
            if ($testVerfiy->status == 1) {
                return redirect()->route('home');
            }
        }

        return view('auth.verification_code');
    }

    public function chechVerificationCode(Request $request)
    {
        $code = str_replace(',', '', $request->code);
        $chechCode = PhoneCheck::where('phone', Auth::user()->phone)->where('check_code', $code)->first();
        if (empty($chechCode)) {
            return response()->json(['msg' => '', 'status' => false]);
        } else {
            if ($chechCode->status != 1) {
                $chechCode->update(['status' => 1]);
            }

            return response()->json(['msg' => '', 'status' => true]);
        }
    }

    public function verification_resend()
    {
        return view('auth.verification_code')->with('msg', 'تم ارسال رمز التحقق مرة اخرى');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['sliders'] = Slider::whereHas('SliderTranslation')->orderByDesc('id')->get();
        $product = ProductCategory::static()->pluck('product_id');
        $Cat = ProductCategory::pluck('category_id');
        $data['home_categories'] = Category::whereNotNull('show_category')->where('parent_id', 0)->static()->whereIN('id', $Cat)->whereHas('CategoryTranslation')->limit(10)->get();
        // $categories = Category::whereIN('id', $productCat)->whereHas('CategoryTranslation')->pluck('id');
        $orders = DB::table('order_details')
            ->select(DB::raw('count(*) as product_id'))
            ->groupBy('product_id')
            ->pluck('product_id');

        $data['best'] = Product::active()->whereIn('id', $product)->orwhereIn('id', $orders)->whereHas('translations')->limit(12)->get();
        $data['flash'] = Product::active()->whereIn('id', $product)->where('deal_of_day', '<>', 0)->whereDate('deal_of_day_end', '>', Carbon::now())->whereHas('translations')->limit(12)->whereDate('deal_of_day_end', '>', Carbon::now())->orderBy('deal_of_day_end')->get();
        $data['products'] = Product::active()->whereIn('id', $product)->whereHas('translations')->limit(12)->get();
        $data['one_product'] = Product::active()->whereIn('id', $product)->whereHas('translations')->inRandomOrder()->first();
        $data['offers'] = Offer::whereHas('offer_translations', function ($query) {
            $query->where('position', 1);
        })->limit(3)->get();
        $data['blogs'] = Blog::whereHas('BlogTranslation')->limit(3)->latest()->get();
        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['about'] = About::whereHas('AboutTranslation')->whereHas('AboutImages')->first();

        return view('home', $data);
    }
}
