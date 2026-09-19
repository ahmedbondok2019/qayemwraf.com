<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\helper\HelperController;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use stdClass;

class VendorBackendController extends Controller
{
    public function __construct(Request $request)
    {
        if (str_contains($request->fullUrl(), 'public')) {
            return redirect(str_replace('/public', '', $request->fullUrl()));
        }
        try {
            $parents = Category::active()->pluck('parent_id');
            $currency = Currency::where('status', 1)->first();
            if (auth()->check()) {
                $cart = Cart::where('user_id', Auth::id())->with('options')->get();
                $sum = collect($cart)->reduce(function ($carry, $item) {
                    return $carry + ($item['price'] + $item['tax']) * $item['quantity'];
                }, 0);
            } else {
                $cart = new stdClass;
                $sum = '';
            }

            View::share([
                'Setting' => Setting::find(1),
                'Categories' => Category::active()->get(),
                'search_categories' => Category::active()->whereNotIn('id', $parents)->get(),
                'Currency' => $currency,
                'cart' => $cart,
                'sum' => $sum,
                'arabic' => HelperController::getArabicLangs(),
                'footer_blogs' => Blog::limit(5)->latest()->get(),
            ]);
        } catch (\Exception $e) {
            // Ignore database errors during console commands
        }
    }
}
