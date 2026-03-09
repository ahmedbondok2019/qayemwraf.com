<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Resources\categories\categories;
use App\Http\Resources\products\products;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductOffer;
use App\Models\ProductRelate;
use App\Models\ProductTranslation;
use App\Models\UserApiToken;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShopController extends ApiController
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }
        // $trans = CategoryTranslation::where('lang_id', 'ar')->pluck('categories_id');
        $categories = Category::whereHas('CategoryTranslation');
        // ->whereIn('id', $trans);
        $categories = $categories->where('parent_id', 0)
            ->orderBy('view')->get();

        return $this->NewApiResponse(categories::collection($categories), '', 'false', '200');
    }

    public function categories_sub(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        $categories = Category::whereHas('CategoryTranslation')
            ->where('parent_id', $request->id)
            ->orderBy('view')->get();

        return $this->NewApiResponse(categories::collection($categories), '', 'false', '200');
    }

    public function products(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        // $request->page_number == 1;
        $allItems = new \Illuminate\Database\Eloquent\Collection;
        $skippedData = intval($request->page_number) * 10 - 10;
        $Category = Category::query();
        if ($request->sub == 0) {
            $IDS = self::GetTree($request->parent);
            $Category = $Category->whereIN('id', $IDS)->get();
            foreach ($Category as $Cat) {
                $proCategories = ProductCategory::where('category_id', $Cat->id)->pluck('product_id');
                $products = Product::active()->whereHas('translations')->whereIn('id', $proCategories)->limit(10)->skip($skippedData)->get();
                if (count($products) > 0) {
                    $collection = products::collection($products);
                    // $collection = products::collection($Cat->products);
                    $allItems = $allItems->merge($collection);
                }
            }
        } else {
            $Category = $Category->where('id', $request->parent)->first();
            $proCategories = ProductCategory::where('category_id', $Category->id)->pluck('product_id');
            $products = Product::active()->whereHas('translations')->whereIn('id', $proCategories)->limit(10)->skip($skippedData)->get();
            $collection = products::collection($products);
            $allItems = $allItems->merge($collection);

        }

        return $this->NewApiResponse($allItems, '', 'false', '200');
    }

    public function brandProducts(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
        // }

        // $request->page_number == 1;
        $skippedData = intval($request->page_number) * 10 - 10;
        $products = Product::active()->where('brand_id', $request->brand_id)
            ->whereHas('translations')->limit(10)->skip($skippedData)->get();
        $collection = products::collection($products);

        return $this->NewApiResponse($collection, '', 'false', '200');
    }

    public function productDetails(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user)){
        //     return $this->NewApiResponse( new \stdClass() ,  __("website.account not found") , 'false', '200');
        // }

        if (! is_numeric($request->id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $products = Product::active()->where('id', $request->id)
            ->with('translations')->with('images')->with('options')->first();
        if (! $products) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
            $products->update(['views' => $products->views + 1]);
        }

        $related = ProductRelate::where('product_id', $request->id)->pluck('related_id');
        $related_products = Product::active()->whereIn('id', $related)
            ->with('translations')->with('images')->with('options')->get();
        $data = [
            'details' => new products($products),
            'related_products' => products::collection($related_products),
        ];

        return $this->NewApiResponse($data, '', 'true', '200');
    }

    public static function getProductPrice($product_id, $user_type = null)
    {
        /*
            المرحلة الاولى من الموقع يتم تطبيق سعر العرض حسب التاريخ للخصم والاولوية والكمية لكل خصم على المنتج
        */

        /*
            المرحلة الاحقة يتم اعتبار كون العميل تاجر جملة وتاجر تجزئة بمعنى لكل عميل جروب
        */

        // product_id	customer_group_id	quantity	periorty	price	start_date	end_date
        $productOffers = ProductOffer::where('product_id', $product_id)->orderBy('periorty', 'asc')->get();
        $totalCount = 0;
        foreach ($productOffers as $offer) {
            $totalCount += $offer->quantity;
            $productCountInOrders = OrderDetail::where('product_id', $product_id)
                ->whereBetween('created_at', [$offer->start_date, $offer->end_date])->count();

            if ($totalCount >= $productCountInOrders) {
                if (Carbon::now() > $offer->start_date && Carbon::now() < $offer->end_date) {
                    return floatval($offer->price);
                } else {
                    $totalCount += $offer->quantity;
                }
            }
        }

    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //            'images.*' => 'nullable|mimes:jpeg,bmp,png,webp,jfif,jpg',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required',
            'price' => 'required|integer',
            'offer_price' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if ($request->price <= $request->offer_price) {
            return $this->NewApiResponse(new \stdClass, __('website.Price Wrong'), 'false', '200');
        }
        $test = ProductTranslation::where('product_name', $request->title)
            ->where('lang_id', app()->getLocale())
            ->first();
        if (empty($test)) {
            $vendor = Vendor::find($user->user_id);
            $product = Product::create([
                'lang_id' => app()->getLocale(),
                'category' => $request->category,
                'vendor_id' => $user->user_id,
                'status' => 1,
                'price' => $request->price,
                'offer_price' => isset($request->offer_price) ? $request->offer_price : null,
                'cash_back' => $vendor->cash_back,
            ]);

            $transID = ProductTranslation::create([
                'product_name' => $request->title,
                'products_details' => $request->description,
                'product_id' => $product->id,
                'lang_id' => app()->getLocale(),
            ]);

            if ($product) {
                self::images(
                    $request->images,
                    $request->title,
                    $product->id,
                    $transID
                );
            }
            $productDetails = new products($product);
        }
        $productDetails = isset($productDetails) ? $productDetails : new products(Product::active()->orderByDesc('id')->first());

        return $this->NewApiResponse($productDetails, __('dashboard.saved'), 'true', '200');
    }

    public function editProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //            'images.*' => 'nullable|mimes:jpeg,bmp,png,webp,jfif,jpg',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required|string',
            'price' => 'required|integer',
            'offer_price' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        $id = intval($request->id);
        if (! is_numeric($id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $product = ProductTranslation::where('product_id', $request->id)
        //            ->where('lang_id', $request->header('lang'))
            ->first();
        if (! empty($product)) {
            $product->update([
                'product_name' => $request->title,
                'products_details' => $request->description,
                'product_id' => $product->id,
                //                'lang_id' => app()->getLocale(),
            ]);

            Product::where('id', $request->id)->update([
                'category' => $request->category,
                //                'vendor_id' => $user->user_id,
                //                'status' => 1,
                'price' => $request->price,
                'offer_price' => isset($request->offer_price) ? $request->offer_price : null,
                //                'cash_back' => $vendor->cash_back
            ]);

            if (! empty($request->images)) {
                self::images(
                    $request->images,
                    $request->title,
                    $product->id,
                    $product->id,
                );
            }
            $productDetails = new products($product);
        } else {
            //            $product = Product::create([
            //                'lang_id' => app()->getLocale(),
            //                'category' => $request->category,
            //                'vendor_id' => $user->user_id,
            //                'status' => 1,
            //                'price' => $request->price,
            //                'offer_price' => $request->offer_price,
            //                'cash_back' => $request->cash_back
            //            ]);
            //
            //            ProductTranslation::create([
            //                'product_name' => $request->title,
            //                'products_details' => $request->description,
            //                'product_id' => $product->id,
            //                'lang_id' => app()->getLocale(),
            //            ]);
            //
            //            if ($product){
            //                self::images(
            //                    $request->images ,
            //                    $request->title ,
            //                    $product->id,
            //                    $product->id,
            //
            //                );
            //            }
        }

        //        $productDetails = new products($product);
        //        return $this->NewApiResponse( isset($productDetails) ? $productDetails : new \stdClass() ,  __('dashboard.saved') , 'true', '200');
        return $this->NewApiResponse(new \stdClass, __('dashboard.saved'), 'true', '200');
    }

    public function deleteProduct(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $lang = $request->header('lang');
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if (! is_numeric($request->id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        ProductTranslation::where('product_id', $request->id)->delete();
        Product::active()->where('id', $request->id)->delete();
        $images = ProductImage::where('product_id', $request->id)->get();
        foreach ($images as $image) {
            if (file_exists(public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$image->image))) {
                unlink(public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$image->image));
            }
            $image->delete();
        }

        return $this->NewApiResponse(new \stdClass, __('website.deleted successfully..'), 'true', '200');
    }

    public static function images($images, $product_name, $productId, $transID)
    {
        if (! empty($images)) {
            foreach ($images as $image) {
                $imageSlug = HelperController::make_slug($product_name.Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.jpg';

                ProductImage::create([
                    'image' => $image_name,
                    'product_id' => $productId,
                    'translation_id' => $transID->id,
                ]);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $image, '', '');
            }
        }
    }

    public static function GetTree($parent)
    {
        $categories = Category::where('id', $parent)->orWhere('parent_id', $parent)->with('childs')->get();
        $Data = [];
        foreach ($categories as $category) {
            $Data[] = $category->id;
            if (count($category->childs)) {
                $Result = self::GetChilds($category->childs);
                foreach ($Result as $item) {
                    $Data[] = $item;
                }
            }
        }

        return $Data;
    }

    public static function GetChilds($subCats)
    {
        $Data = [];
        foreach ($subCats as $child) {
            $Data[] = $child->id;
            if (count($child->childs)) {
                self::GetChilds($child->childs);
            }
        }

        return collect($Data)->unique()->toArray();
    }
}
