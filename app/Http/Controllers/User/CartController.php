<?php

namespace App\Http\Controllers\User;

use App\comparison;
use App\Http\Controllers\Api\CartController as ApiCartController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\WebController;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Compare;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOptionItem;
use App\Models\Promocode;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends WebController
{
    public function Cart()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $data['products'] = Product::active()
            ->whereHas('translations')
            ->whereHas('categories')
            ->limit(15)
            ->get();

        $currency = Currency::where('status', 1)->first();
        $rate = $currency ? $currency->rate : 1;

        $data['cart'] = Cart::where('user_id', Auth::id())->with('options')->whereHas('product')->get();

        $data['prices'] = 0;
        $data['prices'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate, &$data) {
                $optionId = CartOption::where('cart_id', $item['id'])->where('product_id', $item['product_id'])->first();
                $optionId == null ? $cartOption = null : $cartOption = $optionId->option_item_id;
                $productQty = HelperController::getProductQuantiy($item['product_id'], $cartOption, false, null);
                if ($productQty !== null && $productQty >= $item->quantity) {
                    // إضافة السعر إلى الإجمالي
                    $data['prices'] += $item->price * $item->quantity * $rate;

                    return $data['prices']; // الاحتفاظ بالعنصر
                }

                return $data['prices']; // إزالة العنصر
            }, 0);

        return view('dashboard.user.cart', $data);
    }

    public function addToCart(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        if (! is_numeric($request->product_id)) {
            return redirect()->back();
        }

        $product = Product::find($request->product_id);

        // Check if the product has options
        $hasOptions = ProductOptionItem::where('product_id', $product->id)->exists();
        if ($hasOptions && empty($request->op)) {
            alert()->error(__('dashboard.please_select_at_least_one_option'), __('dashboard.attention'));

            return redirect()->back();
        }

        if ($product->max_order !== null && $request->quantity > $product->max_order) {
            alert()->error(__('dashboard.can not exceeds max order'), __('dashboard.attention'));

            return redirect()->back();
        }

        $data = [
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity == 0 || $request->quantity == '' ? 1 : $request->quantity,
        ];

        $FlashSale = OrderService::getFlashSaleValue($product->id);
        if ($FlashSale[0] == 0) {
            if (ApiCartController::getProductPrice($product->id) == 0) {
                $data['price'] = floatval($product->sale_price) ?: $product->price;
            } else {
                $data['price'] = ApiCartController::getProductPrice($product->id);
            }
            $data['flash_id'] = null;
        } else {
            $data['price'] = $FlashSale[0];
            $data['flash_id'] = $FlashSale[1];
        }

        if (isset($request->op)) {
            foreach ($request->op as $key => $optionPrimary) {
                foreach ($optionPrimary as $k => $opIt) {
                    foreach ($opIt as $L => $P) {
                        $price = ProductOptionItem::where('option_id', str_replace('option', '', $key))
                            ->where('option_item_id', $P)
                            ->where('product_id', $request->product_id)
                            ->first();

                        if ($price) {
                            $data['price'] += $price->isPluse ? $price->difference_in_price : -$price->difference_in_price;
                        }
                    }
                }
            }
        }

        $data['tax'] = 0;
        $data['subtotal'] = $data['price'] * $data['quantity'];

        $duplicate = Cart::where([
            'product_id' => $data['product_id'],
            'user_id' => $data['user_id'],
            'quantity' => $data['quantity'],
            'subtotal' => floatval($data['subtotal']),
            'price' => floatval($data['price']),
            'tax' => 0,
        ])->exists();

        if (! $duplicate) {
            $cart = Cart::create($data);

            if ($cart && isset($request->op)) {
                foreach ($request->op as $key => $optionPrimary) {
                    foreach ($optionPrimary as $option) {
                        foreach ($option as $k => $opIt) {
                            $dataoption = [
                                'cart_id' => $cart->id,
                                'product_id' => $product->id,
                                'user_id' => Auth::id(),
                                'option_id' => str_replace('option', '', $key),
                                'option_item_id' => $opIt,
                            ];

                            $price = ProductOptionItem::where('option_id', str_replace('option', '', $key))
                                ->where('option_item_id', $opIt)
                                ->where('product_id', $request->product_id)
                                ->first();

                            if ($price) {
                                $data['price'] += $price->isPluse ? $price->difference_in_price : -$price->difference_in_price;
                                $dataoption['difference_in_price'] = $price->difference_in_price;
                                $dataoption['isPluse'] = $price->isPluse;
                                $dataoption['isMinus'] = $price->isMinus;
                            }

                            CartOption::create($dataoption);
                        }
                    }
                }
            }
        }

        return redirect()->route('user.cart');
    }

    public function updateCart(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $dataCart = json_decode($request->getContent(), true);
        if ($request->checkout == false) {
            if (isset($dataCart['quantity'])) {
                if ($dataCart['quantity'] <= 0) {
                    return redirect('Cart');
                }

                if (isset($dataCart['id'])) {
                    $CartRow = Cart::where('id', $dataCart['id'])->where('user_id', Auth::id())->first();
                    $subtotal = $dataCart['quantity'] * ($CartRow->price + $CartRow->tax);
                    $product = Product::find($CartRow->product_id);
                    if ($dataCart['quantity'] <= $product->max_order) {
                        if ($subtotal > 0) {
                            $CartRow->update([
                                'subtotal' => $subtotal,
                                'tax' => 0,
                                'quantity' => $dataCart['quantity'],
                            ]);
                        }
                    }
                }
            }
        }

        $data = self::getAllCosts($request, $subtotal ?? null, true);

        return response()->json($data);
    }

    public function CouponCode(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }
        $data = self::getAllCosts($request, isset($subtotal) ? $subtotal : null, false);

        return response()->json($data);
    }

    public function deleteFromCart(Request $request)
    {
        $id = preg_replace('/[^0-9]/', '', $request->id);
        if (! auth()->check()) {
            return redirect('login');
        }
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        $data = self::getAllCosts($request);

        return response()->json($data);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'id' => $id]);
        }

        return redirect()->route('Cart', compact('categories', 'cart', 'sum'));
    }

    public static function getAllCosts(Request $request, $subRow = null, $cartOnly = false)
    {
        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        $data = json_decode($request->getContent(), true);
        $discount = 0;
        $userCart = Cart::where('user_id', Auth::id())->get();
        $subtotals = $userCart->sum('subtotal');
        $productIDS = [];
        $prices = collect($userCart)
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['price'] * $item['quantity']) * $rate;
            }, 0);

        $tax = 0;
        foreach ($userCart as $cart) {
            $productIDS[] = $cart['product_id'];
        }

        $payment_method = null;
        $promo_code = null;
        foreach ($userCart as $cart) {
            $cart['price'] = OrderService::getProductOptionItemPrice($cart);
            $productIDS[] = $cart['product_id'];
            if (isset($data['payment_method']) && $data['payment_method'] != null) {
                $payment_method = $data['payment_method'];
            } else {
                $payment_method = Session::get('payment_method');
            }

            if (isset($data['promo_code']) && $data['promo_code'] != null) {
                $promo_code = $data['promo_code'];
            } else {
                $promo_code = Session::get('promo_code');
            }

            $CurrentPrice = $cart['price'] * $rate;
            if ($payment_method != null) {
                if ($cartOnly == false) {
                    $taxValue = OrderController::getProductTax($cart->product_id, $payment_method);
                    $tax += floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity);
                }
            }
        }

        $discount = self::getCouponCode($prices, $promo_code, null, $productIDS, $payment_method)['discount'];
        $shipping_cost = 0;
        if ($cartOnly == false) {
            $getShippingCost = OrderController::getShippingCost($data);
            if ($getShippingCost != null) {
                if ($getShippingCost['shippingCost'] != null) {
                    $shipping_cost = $getShippingCost['shippingCost'];
                } else {
                    if ($getShippingCost['costArray']) {
                        $shipping_cost = max($getShippingCost['costArray']);
                    }
                }
            }
        }

        // $tax = isset($taxrow) && $taxrow > 0 ? $taxrow * $rate : 0;
        $subrow = isset($subRow) && $subRow > 0 ? $subRow * $rate : 0;

        $subtotals = $subtotals * $rate < 0 ? 0 : $subtotals * $rate;
        // $subtotals = ($subtotals - $taxes) * $rate < 0 ? 0 :  ($subtotals - $taxes) * $rate;
        // $taxes = isset($taxes) && $taxes > 0 ?  $taxes * $rate : 0;

        // if ($subtotals + $taxes - $discount + $shipping_cost > 0) {
        if ($subtotals - $discount + $shipping_cost > 0) {
            $total_all = $subtotals - $discount + $shipping_cost + $tax;
        } else {
            $total_all = '0.00';
        }

        // $dataCart = json_decode($request->getContent(), true);
        $id = 0;
        if (isset($data['id']) && $data['id'] != null) {
            $id = $data['id'];
        } else {
            isset($request->id) ? $id = $request->id : $id = 0;
        }

        return [
            // 'prices' => $prices * $rate < 0 ? 0 : $prices * $rate,
            // 'shipping_cost' => $shipping_cost * $rate < 0 ? 0 : $shipping_cost * $rate,
            // 'subtotals' => ($subtotals - $taxes) * $rate < 0 ? 0 : ($subtotals - $taxes) * $rate,
            // 'subrow' => isset($subtotal) && $subtotal > 0 ? $subtotal * $rate : 0,
            // 'taxesrow' => isset($taxrow) && $taxrow > 0 ? $taxrow * $rate : 0,
            // 'taxes' => isset($taxes) && $taxes > 0 ? $taxes * $rate : 0,
            // 'discount' => isset($discount) && $discount > 0 ? $discount * $rate : 0,
            // 'id' => isset($request->id) ? $request->id : 0,

            // 'prices' => $prices * $rate < 0 ? 0 : $prices * $rate,
            'shipping_cost' => number_format($shipping_cost, 2, '.'),
            'subtotals' => number_format($prices, 2, '.'),
            // 'subtotals' => ($subtotals - $taxes) * $rate < 0 ? 0 : number_format(($subtotals) * $rate , 2, '.'),
            'subrow' => number_format($subrow, 2, '.'),
            // 'taxesrow' => number_format($tax , 2, '.'),
            // 'taxes' => number_format($taxes, 2, '.'),
            // 'discount' => number_format($discount * $rate , 2, '.'),
            'discount' => number_format($discount, 2, '.'),
            'total_all' => number_format($total_all, 2, '.'),
            'id' => $id,
        ];
    }

    public function WishList(Request $request)
    {
        $data['wishlist'] = WishList::where('user_id', Auth::user()->id)->whereHas('product')->get();

        return view('dashboard.user.wishlist', $data);
    }

    public function compare(Request $request)
    {
        $data['compare'] = Compare::where('user_id', Auth::user()->id)->get();

        return view('dashboard.user.compare', $data);
    }

    public function addWishList(Request $request)
    {
        if (is_numeric($request->id)) {
            if (! auth()->check()) {
                return redirect()->route('login');
            }

            $test = Wishlist::where('product_id', $request->id)->where('user_id', Auth::user()->id)->first();
            if (empty($test)) {
                Wishlist::create([
                    'product_id' => $request->id,
                    'user_id' => Auth::user()->id,
                ]);
            }

            return redirect()->route('user.WishList');
        }
    }

    // public function updateWishList(Request $request)
    // {
    //     $wishlist_item = wishlist::where('product_id', $request->product_id)->first();

    //     $test = cart::where('user_id', $wishlist_item->user_id)->where('product_id', $wishlist_item->product_id)->first();
    //     if (empty($test))
    //     {
    //         cart::create([
    //             'product_id' => $wishlist_item->product_id,
    //             'quantity' => $request->quantity,
    //             'price' => $wishlist_item->price,
    //             'user_id' => $wishlist_item->user_id
    //         ]);

    //         wishlist::where('product_id', $request->product_id)->delete();
    //     }
    //     else{
    //         return redirect()->back()->with('msg', 'المنتج مضاف بالفعل للسلة');
    //     }

    //     $categories = category_model::where('parent_id', 0)->with('childs')->get();

    //     if (auth()->check())
    //     {
    //         $productIDS = product_model::pluck('id'); $cart = cart::where('user_id', Auth::user()->id)->whereIN('product_id', $productIDS)->orderByDesc('id')->get();
    //         $sum = collect($cart)
    //             ->reduce(function($carry, $item){
    //                 return $carry + $item["price"] * $item["quantity"];
    //             }, 0);
    //     }else{ $cart = ''; $sum = '';}

    //     $wishlist = wishlist::where('user_id', Auth::user()->id)->get();

    //     return redirect()->route('WishList',compact('categories','cart','sum','footer_blogs','wishlist'));
    // }

    public function deleteFromWishList(Request $request)
    {
        $dataS = json_decode($request->getContent());
        if (is_numeric($dataS->id)) {
            $id = preg_replace('/[^0-9]/', '', $dataS->id);
            $currency = Currency::where('status', 1)->first();
            $rate = $currency->rate;

            if (! auth()->check()) {
                return redirect()->route('login');
            }
            $data['cart'] = Cart::where('user_id', Auth::id())->with('options')->get();
            $data['sum'] = collect($data['cart'])
                ->reduce(function ($carry, $item) use ($rate) {
                    // return $carry + ($item["price"] + $item["tax"]) * $item["quantity"] * $rate;
                    return $carry + $item['price'] * $item['quantity'] * $rate;
                }, 0);
            $data['prices'] = collect($data['cart'])
                ->reduce(function ($carry, $item) use ($rate) {
                    return $carry + ($item['price'] * $item['quantity'] * $rate);
                }, 0);
            // $data['taxes'] = collect($data['cart'] )
            //     ->reduce(function($carry, $item) use($rate){
            //         return $carry + ($item["tax"] * $item["quantity"] * $rate);
            //     }, 0);

            wishlist::where('user_id', Auth::user()->id)->where('product_id', $id)->delete();

            $data['wishlist'] = wishlist::where('user_id', Auth::user()->id)->get();

            // if($request->ajax()){
            return response()->json(['status' => true, 'id' => $id]);
            // }
            // return redirect()->route('WishList', $data);
        }
    }

    public function AddToCompare(Request $request)
    {
        if (is_numeric($request->id)) {
            if (! auth()->check()) {
                return redirect()->route('login');
            }

            $test = Compare::where('product_id', $request->id)->where('user_id', Auth::user()->id)->first();
            if (empty($test)) {
                Compare::create([
                    'product_id' => $request->id,
                    'user_id' => Auth::user()->id,
                ]);
            }

            return redirect()->route('user.compare');
        }
    }

    // public function addComparison(Request $request)
    // {
    //     if (is_numeric($request->id))
    //     {
    //         if (!auth()->check())
    //         {
    //             return redirect('login');
    //         }

    //         $test = comparison::where('product_id', $request->id)->where('user_id', Auth::user()->id)->first();
    //         if (empty($test))
    //         {
    //             $price = product_model::where('id', $request->id)->first();
    //             comparison::create([
    //                 'product_id' => $request->id,
    //                 'quantity' => '1',
    //                 'price' => $price->price,
    //                 'user_id' => Auth::user()->id
    //             ]);
    //         }

    //         $categories = category_model::where('parent_id', 0)->with('childs')->get();

    //         if (auth()->check())
    //         {
    //             $productIDS = product_model::pluck('id'); $cart = cart::where('user_id', Auth::user()->id)->whereIN('product_id', $productIDS)->orderByDesc('id')->get();
    //             $sum = collect($cart)
    //                 ->reduce(function($carry, $item){
    //                     return $carry + $item["price"] * $item["quantity"];
    //                 }, 0);
    //         }else{ $cart = ''; $sum = '';}

    //         $comparison = comparison::where('user_id', Auth::user()->id)->get();

    //         return redirect()->route('Comparison',compact('categories','sum','comparison'));
    //     }
    // }

    // public function updateComparison(Request $request)
    // {
    //     $wishlist_item = comparison::where('product_id', $request->product_id)->first();

    //     $test = cart::where('user_id', $wishlist_item->user_id)->where('product_id', $wishlist_item->product_id)->first();
    //     if (empty($test))
    //     {
    //         cart::create([
    //             'product_id' => $wishlist_item->product_id,
    //             'quantity' => $request->quantity,
    //             'price' => $wishlist_item->price,
    //             'user_id' => $wishlist_item->user_id
    //         ]);

    //         comparison::where('product_id', $request->product_id)->delete();
    //     }
    //     else{
    //         return redirect()->back()->with('msg', 'المنتج مضاف بالفعل للسلة');
    //     }

    //     $categories = category_model::where('parent_id', 0)->with('childs')->get();

    //     if (auth()->check())
    //     {
    //         $productIDS = product_model::pluck('id'); $cart = cart::where('user_id', Auth::user()->id)->whereIN('product_id', $productIDS)->orderByDesc('id')->get();
    //         $sum = collect($cart)
    //             ->reduce(function($carry, $item){
    //                 return $carry + $item["price"] * $item["quantity"];
    //             }, 0);
    //     }else{ $cart = ''; $sum = '';}

    //     $comparison = comparison::where('user_id', Auth::user()->id)->get();

    //     return redirect()->route('Comparison',compact('categories','cart','sum','comparison'));
    // }

    // public function deleteFromComparison(Request $request)
    // {
    //     if (is_numeric($request->id))
    //     {
    //         if (!auth()->check())
    //         {
    //             return redirect('login');
    //         }

    //         comparison::where('user_id', Auth::user()->id)->where('product_id', $request->id)->delete();

    //         $comparison = comparison::where('user_id', Auth::user()->id)->get();
    //         $categories = category_model::where('parent_id', 0)->with('childs')->get();
    //         if (auth()->check())
    //         {
    //             $productIDS = product_model::pluck('id'); $cart = cart::where('user_id', Auth::user()->id)->whereIN('product_id', $productIDS)->orderByDesc('id')->get();
    //             $sum = collect($cart)
    //                 ->reduce(function($carry, $item){
    //                     return $carry + $item["price"] * $item["quantity"];
    //                 }, 0);
    //         }else{ $cart = ''; $sum = '';}

    //         return redirect()->route('Comparison',compact('categories','cart','sum', 'comparison'));
    //     }

    // }

    public static function getCouponCode($prices, $promoCode, $user_id = null, $products = null, $payment_method = null)
    {
        $discount = 0;
        $data = null;
        if ($promoCode != null) {
            $data = Promocode::where('promo_code', $promoCode)
                ->whereDate('promo_valid_from', '<=', Carbon::now())
                ->whereDate('promo_valid_to', '>=', Carbon::now())
                ->first();

            $count = Order::where('coupon_code', $promoCode)->count();

            if (isset($data)) {
                $data_payment_method = $data->payment_method == 1 ? 'cash' : 'fawry';
                if ($data->product_id == null || $data->payment_method == null) {
                    $discount = self::getPromoValue($count, $data, $prices, $promoCode, $user_id);
                } else {
                    if ($products != null) {
                        foreach ($products as $product) {
                            if ($data->product_id == $product && $data_payment_method == $payment_method) {
                                $price = ApiCartController::getProductPrice($product);
                                $discount = self::getPromoValue($count, $data, $price, $promoCode, $user_id);
                            }
                        }
                    }
                }
            }
        }

        return [
            'discount' => $discount,
            'promoType' => isset($data->promoType) ? $data->promoType : null,
            'coupon_code' => isset($promoCode) ? $promoCode : null,
            'codeRow' => $data,
        ];
    }

    public static function getPromoValue($count, $data, $price, $promoCode, $user_id)
    {
        $discount = 0;
        if ($count < $data->promo_usage_count) {
            if ($data->promoType == 1) {
                $discount = $price * $data->promoValue / 100;
                if ($discount > $data->promoMaxAmount) {
                    $discount = $data->promoMaxAmount;
                }
            } else {
                $discount = $data->promoValue;
            }

            if ($data->promo_oneUse == 1) {
                $order = Order::where('coupon_code', $promoCode)
                    ->where('user_id', $user_id == null ? Auth::id() : $user_id)->first();
                if ($order) {
                    $discount = 0;
                }
            }
        }

        return $discount;
    }
}
