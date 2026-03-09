<?php

namespace App\Http\Resources\products;

use App\Http\Controllers\Api\helper\helperController;
use App\Http\Controllers\Api\ShopController;
use App\Models\BrandTranslation;
use App\Models\CategoryTranslation;
use App\Models\Currency;
use App\Models\OrderDetail;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\UserApiToken;
use App\Models\Vendor;
use App\Models\Wishlist;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class flashdeals extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = ProductImage::where('product_id', $this->id)->get();
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            $isFavorite = false;
        } else {
            $isFavorite = Wishlist::where('user_id', $user->user_id)->where('product_id', $this->id)->exists();
        }
        $countFavorite = Wishlist::where('product_id', $this->id)->count();
        $countOrder = OrderDetail::where('product_id', $this->id)->count();

        /*
            المرحلة القادمة من التطبيق :
             الاخذ فى الاعتبار نوع العميل الذى يقوم بالشراء
             فلو كان تاجر فقد يكون له خصوم على المنتج عنده يتغير السعر فيظهر له
             السعر بعد الخصم ويتم ارسال رقم الخصم الخاص بالمنتج يسجل فى الطلب عند الشراء.
        */

        /*
            الاخذ فى الاعتبار الخصومات على المنتج وكل كمية عندها يطبق الخصم وكذلك الاولوية والمدة
        */

        /*
            السعر يعتبر من خلال ضرب السعر الاصلى فى قيمة العملة المفعلة من الادمن
        */

        ShopController::getProductPrice($this->id) == 0 ? $salePrice = floatval($this->sale_price) : $salePrice = ShopController::getProductPrice($this->id);

        $lang = $request->header('lang');
        $active_currency = Setting::where('lang_id', app()->getLocale())->first()->active_currency;
        $rate = optional(Currency::find($active_currency))->rate;
        $product_categories = ProductCategory::where('product_id', $this->id)->first();
        if ($product_categories) {
            $category_id = intval($product_categories->category_id);
            $category = optional(CategoryTranslation::where('categories_id', $product_categories->category_id)->first())->title;
        } else {
            $category_id = intval($this->category);
            $category = optional(CategoryTranslation::where('categories_id', $this->category)->first())->title;
        }

        if (isset($this->translations) && $this->translations['lang_id'] == $lang) {
            return [
                'id' => $this->id,
                'primary_image' => 'products/'.$this->translations['primary_image'],
                'title' => $this->translations['title'],
                'description' => $this->translations['description'],
                'category_id' => $category_id,
                'category' => $category,
                'store_name' => optional(Vendor::find($this->vendor_id))->name,
                'rating' => intval(DB::table('ratings')->where('product_id', $this->id)->avg('rating')),
                'rate_count' => intval(Rating::where('product_id', $this->id)->count()),
                'price' => round($this->price * $rate ?? 1, 2),
                'sale_price' => round($salePrice * $rate ?? 0, 2),
                'discount_percentage' => round($salePrice / $this->price * 100, 2),
                'quantity' => intval($this->quantity),
                'ignore_quantity' => boolval($this->ignore_quantity),
                'item_code' => $this->item_code,
                'brand_id' => intval($this->brand_id),
                'brand' => optional(BrandTranslation::where('brand_id', $this->brand_id)->where('lang_id', $request->header('lang'))->first())->title,
                'images' => images::collection($images),
                // 'variations' => !empty($this->variations) ? variations::collection($this->variations) : [],
                'options' => ! empty($this->options) ? productOptions::collection($this->options) : [],
                'isFavorite' => $isFavorite,
                'countFavorite' => $countFavorite,
                'countOrder' => $countOrder,
                'product_link' => LaravelLocalization::localizeUrl('/product/'.$this->id.'/'.helperController::make_slug($this->translations['title'])),
                'product_rates' => productRates::collection($this->rates),
                'deal_of_day_end' => $this->deal_of_day_end,
            ];
        }
        // return parent::toArray($request);
    }
}
