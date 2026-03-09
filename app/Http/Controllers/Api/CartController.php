<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Resources\cart as ResourcesCart;
use App\Http\Resources\code;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderOption;
use App\Models\Product;
use App\Models\ProductOffer;
use App\Models\ProductOption;
use App\Models\ProductOptionItem;
use App\Models\Promocode;
use App\Models\Tax;
use App\Models\UserApiToken;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use stdClass;

class CartController extends ApiController
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(new stdClass, __('website.account not found'), 'false', '404');
        }

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        $products = Product::active()->whereHas('translations')->whereHas('images')->pluck('id');

        $data['cart'] = Cart::where('user_id', self::getUserStatus($request)['user_id'])
            ->whereIn('product_id', $products)
            ->with('options')->get();
        $idsToRemove = [];
        $sum = 0;
        $tax = 0;

        $sum = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                $optionId = CartOption::where('cart_id', $item['id'])->where('product_id', $item['product_id'])->first();
                $optionId == null ? $cartOption = null : $cartOption = $optionId->option_item_id;
                $ProQty = HelperController::getProductQuantiy($item['product_id'], $cartOption, false, null);
                if ($ProQty != null) {
                    return $carry + ($item['price'] * $item['quantity'] * $rate);
                } else {
                    $idsToRemove[] = $item['id'];
                }
            }, 0);

        foreach ($data['cart'] as $key => $item) {
            if (in_array($item->id, $idsToRemove)) {
                unset($data['cart'][$key]);
            }
        }

        $tax = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['tax'] * $item['quantity'] * $rate);
            }, 0);

        $cart = [
            'cart_items' => ResourcesCart::collection($data['cart']),
            'total_amount' => floatval($sum),
            'total_tax' => floatval($tax),
        ];

        return $this->NewApiResponse($cart, '', 'true', '200');
    }

    public function updateCart(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '200');
        }

        $cart = Cart::where('id', $request->id)->first();
        if ($cart) {
            $subtotal = $request->quantity * ($cart->price + $cart->tax);
            $product = Product::find($cart->product_id);
            if ($request->quantity <= $product->max_order && $product->quantity > 0) {
                if ($subtotal > 0) {
                    $cart->update([
                        'subtotal' => $subtotal,
                        'tax' => 0,
                        'quantity' => $request->quantity,
                    ]);
                }
            }
        }

        return $this->NewApiResponse(new stdClass, __('dashboard.updated'), 'true', '200');
    }

    public function validCode(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '200');
        }

        $getCouponCode = self::getCouponCode(
            null,
            $request->code,
            self::getUserStatus($request)['user_id']
        );

        $discount = $getCouponCode['discount'];
        $data = $getCouponCode['codeRow'];
        // $data = Promocode::where('promo_code', $request->code)
        //     ->whereDate('promo_valid_from', '<=' , Carbon::now())
        //     ->whereDate('promo_valid_to', '>=' , Carbon::now())
        //     ->first();

        // if($data){
        // if ($data->promo_oneUse == 1) {
        //     $order = Order::where('coupon_code', $request->code)->first();
        //     if ($order) {
        //         return $this->NewApiResponse( new stdClass(), __('dashboard.not Found'), 'false', '200');
        //     }
        // }

        // $count = Order::where('coupon_code', $request->code)->count();
        // if($count > $data->promo_usage_count){
        //     return $this->NewApiResponse( new stdClass(), __('dashboard.not Found'), 'false', '200');
        // }
        // return $this->NewApiResponse( new code($data), "", 'true', '200');
        if ($discount == 0) {
            // return $getCouponCode;
            return $this->NewApiResponse(new stdClass, __('dashboard.not Found'), 'false', '200');
        } else {
            return $this->NewApiResponse(new code($data), '', 'true', '200');
        }
        // }else{
        //     return $this->NewApiResponse( new stdClass(), __('dashboard.not Found'), 'false', '200');
        // }
    }

    public static function getCouponCode($prices, $promoCode, $user_id)
    {
        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;
        $discount = 0;

        $userCart = Cart::where('user_id', $user_id)->get();
        $prices = collect($userCart)
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['price'] * $item['quantity']) * $rate;
            }, 0);

        if ($promoCode != null) {
            $data = Promocode::where('promo_code', $promoCode)
                ->whereDate('promo_valid_from', '<=', Carbon::now())
                ->whereDate('promo_valid_to', '>=', Carbon::now())
                ->first();

            $count = Order::where('coupon_code', $promoCode)->count();

            if ($data) {
                if ($count > $data->promo_usage_count) {
                    $discount = 0;
                } else {
                    if ($data->promoType == '1') {
                        $discount = $prices * $data->promoValue / 100;
                        if ($discount > $data->promoMaxAmount) {
                            $discount = $data->promoMaxAmount;
                        }
                    } else {
                        $discount = $data->promoValue;
                    }

                    if ($data->promo_oneUse == 1) {
                        $order = Order::where('coupon_code', $promoCode)
                            ->where('user_id', $user_id)->first();
                        if ($order) {
                            $discount = 0;
                        }
                    }
                }
            }
        }

        return [
            'discount' => $discount,
            'promoType' => isset($data->promoType) ? $data->promoType : null,
            'coupon_code' => isset($promoCode) ? $promoCode : null,
            'codeRow' => $data ?? null,
        ];
    }

    public function addToCart(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '200');
        }

        if (! is_numeric($request->product_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $product = Product::find($request->product_id);
        if (! is_numeric($request->product_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.Product NotFound'), 'false', '200');
        }

        if ($request->qty > $product->max_order) {
            return $this->NewApiResponse(new \stdClass, __('dashboard.can not exceeds max order'), 'false', '200');
        }

        // product_id,user_id,quantity,price,tax,shipping_cost,subtotal,option_id,option_item_id
        // return json_encode($request->options);
        // return $request->all();

        /*
            تكلفة الشحن عند اضافتها للسلة يجب معرفة جروب المنتج
            ومعرفة طريقة الشحن التى يتبعها القسم لمعرفة تكلفة شحن المنتج
            وكذلك المحافظة التى يتبعها
        */

        // $shipping_category = ShippingCategory::where('product_category', $product->shipping_category)->first();
        // $data['shipping_cost'] = $shipping_category->price * $type;

        /*
            بالنسبة للضرائب تم عمل مجموعة من الضرائب
            يتم اضافتها وتم عمل تعديل يقضى بجمع كل الضرائب الفعالة لتطبق على المنتجات

        */

        // $taxValue = 0;
        // $taxes = Tax::all();
        // foreach($taxes as $tax){
        //     if($tax->status == 1){
        //         $taxValue += $tax->value;
        //     }
        // }

        // $data = array();
        // $data['product_id'] = $product->id;
        // $data['user_id'] = $user->user_id;
        // $data['quantity'] = $request->qty;
        // $data['tax'] = floatval(($data['price'] * $taxValue) / 100);

        // if (self::getProductPrice($product->id) == 0) {
        //     if(floatval($product->sale_price) == null || floatval($product->sale_price) == 0){
        //         // original price
        //         $data['price'] = $product->price;
        //     }else{
        //         $data['price'] = floatval($product->sale_price);
        //     }
        // }else{
        //     $data['price'] = self::getProductPrice($product->id);
        // }

        $taxValue = 0;
        $taxes = Tax::all();
        foreach ($taxes as $tax) {
            if ($tax->status == 1) {
                $taxValue += $tax->value;
            }
        }

        $data = [];
        $data['product_id'] = $product->id;
        $data['user_id'] = $user->user_id;
        $data['quantity'] = $request->qty == 0 || $request->qty == '' ? 1 : $request->qty;

        $FlashSale = OrderService::getFlashSaleValue($product->id);
        if ($FlashSale[0] == 0) {
            if (self::getProductPrice($product->id) == 0) {
                if (floatval($product->sale_price) == null || floatval($product->sale_price) == 0) {
                    // original price
                    $data['price'] = $product->price;
                } else {
                    $data['price'] = floatval($product->sale_price);
                }
            } else {
                $data['price'] = self::getProductPrice($product->id);
            }
            $data['flash_id'] = null;
        } else {
            $data['price'] = $FlashSale[0];
            $data['flash_id'] = $FlashSale[1];
        }

        $input = json_decode($request->options);
        if ($input != null) {
            foreach ($input as $option) {
                $price = ProductOptionItem::where('option_id', $option[0])->where('option_item_id', $option[1])
                    ->where('product_id', $request->product_id)->first();
                if ($price) {
                    if ($price->isPluse == 1) {
                        $data['price'] += $price->difference_in_price;
                    } else {
                        $data['price'] -= $price->difference_in_price;
                    }
                }
            }
        }

        $data['tax'] = floatval(($data['price'] * $taxValue) / 100);
        $data['subtotal'] = ($data['price'] + $data['tax']) * $data['quantity'];
        $duplicate = Cart::where([
            'product_id' => $data['product_id'],
            'user_id' => $data['user_id'],
            'quantity' => $data['quantity'],
            'subtotal' => $data['subtotal'],
            'price' => $data['price'],
            'tax' => $data['tax'],
            // 'option_id' => $data['option_id'],
            // 'option_item_id' => $data['option_item_id'],
        ])->exists();

        if ($duplicate == false) {
            $cart = Cart::create($data);

            if ($cart) {
                $input = json_decode($request->options);
                foreach ($input as $option) {
                    $dataoption['cart_id'] = $cart->id;
                    $dataoption['product_id'] = $product->id;
                    $dataoption['user_id'] = $user->user_id;
                    $dataoption['option_id'] = $option[0];
                    $dataoption['option_item_id'] = $option[1];

                    $price = ProductOptionItem::where('option_id', $option[0])->where('option_item_id', $option[1])
                        ->where('product_id', $request->product_id)->first();
                    if ($price) {
                        if ($price->isPluse == 1) {
                            $data['price'] += $price->difference_in_price;
                        } else {
                            $data['price'] -= $price->difference_in_price;
                        }
                        $dataoption['difference_in_price'] = $price->difference_in_price;
                        $dataoption['isPluse'] = $price->isPluse;
                        $dataoption['isMinus'] = $price->isMinus;
                    }
                    CartOption::create($dataoption);
                }
            }
        } else {
            $duplicate = Cart::where([
                'product_id' => $data['product_id'],
                'user_id' => $data['user_id'],
                'quantity' => $data['quantity'],
                'subtotal' => $data['subtotal'],
                'price' => $data['price'],
                'tax' => $data['tax'],
                // 'option_id' => $data['option_id'],
                // 'option_item_id' => $data['option_item_id'],
            ])->update(['quantity' => $data['quantity']]);
        }

        return $this->NewApiResponse(new stdClass, __('website.added successfully'), 'true', '200');
    }

    public function deleteFromCart(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '200');
        }

        Cart::where('id', $request->id)->delete();
        CartOption::where('cart_id', $request->id)->delete();

        return $this->NewApiResponse(new stdClass, __('website.deleted successfully'), 'true', '200');
    }

    public static function getUserStatus(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            // return self::NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
            return ['result' => false, 'user_id' => '', 'user_type' => $user_type];
        }

        return ['result' => true, 'user_id' => $user->user_id, 'user_type' => $user_type];
    }

    public static function getProductPrice($product_id, $user_type = null)
    {
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

    public static function getMaxQuantity($product_id, $cart_options)
    {
        $product = Product::find($product_id);
        $ignore_quantity = $product->ignore_quantity;
        $options = ProductOption::where('product_id', $product_id)->with('items')->get();

        if ($options->isEmpty()) {
            return [
                'max_quantity' => $product->quantity,
                'ignore_quantity' => $ignore_quantity,
            ];
        } else {
            $max_quantity = '100';
            foreach ($options as $option) {
                foreach ($cart_options as $cart_option) {
                    foreach ($option->items as $item) {
                        if ($cart_option->option_item_id == $item->option_item_id) {
                            $order_option_item = OrderOption::where('option_item_id', $item->option_item_id)->sum('option_item_id');
                            if ($item->ignore_quantity == false) {
                                $max_quantity = $item->quantity - $order_option_item > 0 ? $item->quantity - $order_option_item : 0;
                                $ignore_quantity = $item->ignore_quantity;
                            }
                        }
                    }
                }
            }

            return [
                'max_quantity' => $max_quantity,
                'ignore_quantity' => $ignore_quantity,
            ];
        }
    }
}
