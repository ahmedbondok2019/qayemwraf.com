<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Currency;
use App\Models\CurrencyTranslation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use stdClass;

class WebController extends Controller
{
    public $id;

    public function __construct(Request $request)
    {
        $ip = $request->ip();

        // if(str_contains($request->fullUrl() , 'public')){
        //     // dd(str_replace('/public' , '' , $request->fullUrl()));
        //     return redirect(str_replace('/public' , '' , $request->fullUrl()));
        // }

        // if($request->segment(1) == 'public'){
        //     dd($request->fullUrl());
        // }

        $parents = Category::where('is_active', true)->pluck('parent_id');
        $currency = Currency::where('status', 1)->first();
        $currency_trans = CurrencyTranslation::where('currency_id', $currency->id)->where('locale', app()->getLocale())->first();
        if (auth()->check()) {
            $cart = Cart::where('user_id', Auth::id())->with('options')->get();
            $sum = collect($cart)
                ->reduce(function ($carry, $item) {
                   return $carry + ($item['price'] + $item['tax']) * $item['quantity'];
                }, 0);
        } else {
            $cart = new stdClass;
            $sum = '';
        }

        View::share([
            'Setting' => \App\Models\Setting::first(),
            'Categories' => \App\Models\CategoryTranslation::where('locale', app()->getLocale())->whereIn('category_id', $parents)->get(),
            'search_categories' => Category::where('is_active', true)->whereHas('CategoryTranslation')->whereNotIn('id', $parents)->get(),
            'Currency' => $currency_trans,
            'cart' => $cart,
            'sum' => $sum,
            'arabic' => \App\Http\Controllers\helper\HelperController::getArabicLangs(),
            'footer_blogs' => Blog::whereHas('BlogTranslation')->limit(5)->latest()->get(),
        ]);

        Visitor::create([
            'ip' => $ip,
            'url' => $request->url(),
            'user_id' => auth()->check() ? Auth::id() : null,
        ]);
    }
}
