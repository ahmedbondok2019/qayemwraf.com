<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CartController as ApiCartController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\User\UsersController;
use App\Http\Resources\orders\orders;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Currency;
use App\Models\LogApi;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderOption;
use App\Models\OrderSetting;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOptionItem;
use App\Models\ProfitGroup;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\ShippingCategoryArea;
use App\Models\Tax;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserApiToken;
use App\Models\Vendor;
use App\Notifications\OrderNotification;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use stdClass;

class OrdersController extends ApiController
{
    use ApiResponseTrait;

    public static function getUserStatus(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $lang = $request->header('lang');
        app()->setlocale($lang);

        $userData = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if ($userData) {
            $user = User::find($userData->user_id);
            if (! isset($user)) {
                // return self::NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '200');
                return ['result' => false, 'user_id' => $userData->user_id, 'user_type' => $user_type];
            }

            return ['result' => true, 'user_id' => $user->id, 'user_type' => $user_type, 'user' => $user];
        }

        return ['result' => false, 'user_id' => '', 'user_type' => $user_type, 'user' => null];
    }

    public function index(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $userData = User::find(self::getUserStatus($request)['user_id']);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        if (self::getUserStatus($request)['user_type'] == 2) {
            $orders = Order::where('vendor_id', self::getUserStatus($request)['user_id'])->orderByDesc('id')->get();
        } else {
            $orders = Order::where('user_id', self::getUserStatus($request)['user_id'])->orderByDesc('id')->get();
        }

        return $this->NewApiResponse(orders::collection($orders), '', 'false', '200');
    }

    public function orderDetails(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if (! is_numeric($request->order_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $order = Order::where('id', $request->order_id)->whereHas('order_details')->first();
        if ($order) {
            return $this->NewApiResponse(new orders($order), '', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }
    }

    public function orderStatusChange(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if (! is_numeric($request->order_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        Order::where('id', $request->order_id)->update(['status' => $request->status]);
        OrderStatus::create([
            'order_id' => $request->order_id,
            'user_id' => $user->user_id,
            'admin_id' => null,
            'status' => $request->status,
            'notes' => 'تم تحديث حالة الطلب من العميل',
        ]);

        return $this->NewApiResponse(new \stdClass, __('website.order updated successfully'), 'true', '200');
    }

    public function shipping_cost(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        if (! is_numeric($request->address_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        // address_id required.
        $data = self::getShippingCost($request);
        if ($data) {
            if ($data['costArray'] != null) {
                return $this->NewApiResponse(max($data['costArray']), '', 'true', '200');
            } else {
                return $this->NewApiResponse($data['shippingCost'], '', 'true', '200');
            }
        }

        return $this->NewApiResponse(new stdClass, __('dashboard.not Found'), 'true', '200');
    }

    public function OrderData(Request $request)
    {
        // address_id required.
        // code nullable.
        $userID = self::getUserStatus($request)['user_id'];
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        if (! is_numeric($request->address_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        if ($request->payment_method == null) {
            return $this->NewApiResponse(new \stdClass, __('website.Payment Method Required'), 'false', '200');
        }

        if ($request->address_id == null || $request->address_id == '') {
            return $this->NewApiResponse(new \stdClass, __('website.Address Required'), 'false', '200');
        }

        // / shipping cost.
        $order['shipping_cost'] = 0;
        $getShippingCost = self::getShippingCost($request);
        if (empty($getShippingCost['userCart']) || $getShippingCost['userCart'] == null) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        if ($getShippingCost != null) {
            if ($getShippingCost['shippingCost'] != null) {
                $order['shipping_cost'] = $getShippingCost['shippingCost'];
            } else {
                if ($getShippingCost['costArray']) {
                    $order['shipping_cost'] = max($getShippingCost['costArray']);
                }
            }
        }

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        $userCart = $getShippingCost['userCart'];

        $order['sum'] = 0;
        $order['tax'] = 0;
        $order['total'] = 0;

        foreach ($userCart as $cart) {
            $product = Product::find($cart->product_id);
            // $data['vendor_id'] = $product->vendor_id;

            // $cart['price'] = 0;

            $cart['price'] = OrderService::getProductOptionItemPrice($cart);

            $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
            $CurrentPrice = $cart['price'] * $rate;
            $order['tax'] += floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity);
            $order['sum'] += $CurrentPrice * $cart->quantity;
        }

        // coupon code.
        $order['discount_amount'] = 0;
        $order['discount_type'] = null;
        $order['coupon_code'] = null;

        $discount = [];
        $finalDiscount = 0;
        $discount = ApiCartController::getCouponCode(
            null,
            $request->code,
            self::getUserStatus($request)['user_id']
        );
        if (isset($discount['promo_code'])) {
            $order['discount_amount'] = intval($discount['discount']);
            $order['discount_type'] = $discount['promoType'] == 1 ? __('dashboard.percentage') : __('dashboard.fixed');
            $order['coupon_code'] = $discount['promo_code'];

            $finalDiscount = $discount['discount'];
        }

        $order['total'] = $order['sum'] + $order['tax'] - $finalDiscount + $order['shipping_cost'];

        return $this->NewApiResponse($order, '', 'true', '200');
    }

    public function readFirst(Request $request)
    {
        $userID = self::getUserStatus($request)['user_id'];
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        if ($request->payment_method == null) {
            return $this->NewApiResponse(new \stdClass, __('website.Payment Method Required'), 'false', '200');
        }

        if ($request->address_id == null || $request->address_id == '') {
            return $this->NewApiResponse(new \stdClass, __('website.Address Required'), 'false', '200');
        }

        // / shipping cost.
        $order['shipping_cost'] = 0;
        $getShippingCost = self::getShippingCost($request);
        if (empty($getShippingCost['userCart']) || $getShippingCost['userCart'] == null) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        if ($getShippingCost != null) {
            if ($getShippingCost['shippingCost'] != null) {
                $order['shipping_cost'] = $getShippingCost['shippingCost'];
            } else {
                if ($getShippingCost['costArray']) {
                    $order['shipping_cost'] = max($getShippingCost['costArray']);
                }
            }
        }

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        $userCart = $getShippingCost['userCart'];

        $order['sum'] = 0;
        $order['tax'] = 0;
        $order['total'] = 0;

        Session::put(['Productmsg' => '']);
        foreach ($userCart as $cart) {
            $optionId = \App\Models\CartOption::where('cart_id', $cart->id)
                ->where('product_id', $cart->product_id)->first();
            $cartOption = $optionId == null ? null : $optionId->option_item_id;
            $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy(
                $cart->product_id,
                $cartOption,
                true,
                $cart->quantity
            );
            if ($ProQty != null && $ProQty >= $cart->quantity) {
                $product = Product::find($cart->product_id);
                // $data['vendor_id'] = $product->vendor_id;

                // $cart['price'] = 0;
                $cart['price'] = OrderService::getProductOptionItemPrice($cart);

                $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
                $CurrentPrice = $cart['price'] * $rate;
                $order['tax'] += floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity);
                $order['sum'] += $CurrentPrice * $cart->quantity;
            } else {
                Session::put(['Productmsg' => __('dashboard.Sorry Not Available')]);
            }
        }

        // coupon code.
        $order['discount_amount'] = 0;
        $order['discount_type'] = null;
        $order['coupon_code'] = null;

        $discount = [];
        $discount = ApiCartController::getCouponCode(
            null,
            $request->code,
            self::getUserStatus($request)['user_id']
        );

        // if(!empty($discount)){
        $order['discount_amount'] = intval($discount['discount']);
        $order['discount_type'] = $discount['promoType'] == 1 ? __('dashboard.percentage') : __('dashboard.fixed');
        $order['coupon_code'] = isset($discount['promo_code']) ? $discount['promo_code'] : null;
        // }

        $order['total'] = $order['sum'] + $order['tax'] - $discount['discount'] + $order['shipping_cost'];
        $address = UserAddress::find($request->address_id);

        $order['user_id'] = $userID;
        $order['address'] = $address->address;
        $order['name'] = $address->name;
        $order['phone'] = $address->phone;
        $order['email'] = $address->email;
        $order['lat'] = $address->lat;
        $order['lng'] = $address->lng;
        $order['area'] = $address->area;
        $order['city'] = $address->city;
        $order['status'] = 0;
        $order['payment_status'] = 0;
        $order['payment_method'] = $request->payment_method;
        $order['transaction_ref'] = null;
        $order['paid_actual'] = $order['total'];
        $order['currency'] = $currency->translations->title;
        $order['rate'] = $rate;
        $order['transaction_ref'] = null;
        $order['payment_by'] = null;
        $order['shipping_cost'] = isset($order['shipping_cost']) ? $order['shipping_cost'] : 0;

        if ($order['sum'] > 0) {
            $orderID = Order::create($order);
            if ($orderID) {
                OrderStatus::create([
                    'order_id' => $orderID->id,
                    'user_id' => $userID,
                    'admin_id' => null,
                    'status' => 0,
                    'notes' => 'طلب جديد',
                ]);

                $fawryItems = [];
                $fawryData = '';
                $lastLoopData = false;
                $loopCount = 0;

                foreach ($userCart as $cart) {
                    // $optionId = \App\Models\CartOption::where('cart_id', $cart->id)
                    //     ->where('product_id', $cart->product_id)->first();
                    // $cartOption = $optionId == null ? null : $optionId->option_item_id;
                    // $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy(
                    //         $cart->product_id ,
                    //         $cartOption ,
                    //         false ,
                    //         $cart->quantity
                    //     );
                    // if ($ProQty != null && $ProQty >= $cart->quantity){
                    $loopCount += 1;
                    if ($loopCount == count($userCart)) {
                        $lastLoopData = true;
                    }
                    $product = Product::find($cart->product_id);

                    $data = [];

                    $data['order_id'] = $orderID->id;
                    $data['product_id'] = $product->id;
                    $data['user_id'] = $userID;
                    $data['quantity'] = $cart->quantity;
                    // $data['tax'] = optional(Tax::find($product->tax))->value;
                    $data['vendor_id'] = $product->vendor_id;

                    $FlashSale = OrderService::getFlashSaleValue($cart->product_id);
                    if ($FlashSale[0] == 0) {
                        $data['price'] = OrderService::getProductOptionItemPrice($cart);
                        $order['flash_id'] = null;
                    } else {
                        $data['price'] = $FlashSale[0];
                        $order['flash_id'] = $FlashSale[1];
                    }

                    // $data['tax'] += $cart['tax'];

                    $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
                    $CurrentPrice = $cart['price'] * $rate;
                    $Itemprice = number_format((float) ($data['price'] + floatval(($CurrentPrice * $taxValue) / 100)), 2, '.', '');

                    // $data['subtotal'] = ($data['price'] + floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity)) * $data['quantity'];
                    $data['subtotal'] = $data['price'] * $data['quantity'];

                    $website_profit = 0;
                    $vendor_profit_share = 0;

                    $vendor = Vendor::find($product->vendor_id);
                    if ($vendor) {
                        $profit_group = ProfitGroup::find($vendor->profit_group);
                        if ($profit_group) {
                            // return $profit_group;
                            if ($profit_group->type == 1) {
                                $website_profit = $data['price'] * $data['quantity'] * $profit_group->value / 100;
                                $vendor_profit_share = $data['subtotal'] - $website_profit;
                            } else {
                                $website_profit = ($data['price'] * $data['quantity']) + $profit_group->value;
                                $vendor_profit_share = $data['subtotal'] - $website_profit;
                            }
                        }
                    }

                    $data['website_profit'] = $website_profit;
                    $data['vendor_profit_share'] = $vendor_profit_share;
                    $data['profit_percentage'] = isset($profit_group) ? $profit_group->value : 0;

                    $orderDetailsData = [
                        'order_id' => $data['order_id'],
                        'product_id' => $data['product_id'],
                        'vendor_id' => $data['vendor_id'],
                        // 'user_id' => Auth::id(),
                        'quantity' => $data['quantity'],
                        'subtotal' => $data['subtotal'],
                        'price' => $data['price'],
                        // 'tax' => $data['tax'],
                        'tax' => floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity),
                        'website_profit' => $data['website_profit'],
                        'vendor_profit_share' => $data['vendor_profit_share'],
                        'profit_percentage' => $data['profit_percentage'],
                    ];

                    $duplicate = OrderDetail::where($orderDetailsData)->exists();

                    if ($duplicate == false) {
                        $orderDetails = OrderDetail::create($orderDetailsData);
                        if ($cart) {
                            $IDS = [];
                            // $input = json_decode($request->options);
                            foreach ($cart->options as $option) {
                                $IDS[] = $cart->id;
                                $dataoption['order_details_id'] = $orderDetails->id;
                                // $dataoption['order_detail_id'] = $orderDetails->id;
                                $dataoption['product_id'] = $product->id;
                                $dataoption['user_id'] = $userID;
                                $dataoption['option_id'] = $option->option_id;
                                $dataoption['option_item_id'] = $option->option_item_id;

                                $price = ProductOptionItem::where('option_id', $option->option_id)->where('option_item_id', $option->option_item_id)
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

                                OrderOption::create($dataoption);
                            }
                        }

                        if (
                            $request->payment_method == 'fawry' ||
                            $request->payment_method == 'fawry_visa' ||
                            $request->payment_method == 'fawry_pay' ||
                            $request->payment_method == 'fawry_installment'
                        ) {

                            if ($discount['discount'] > 0) {
                                $reduce_percentage = $CurrentPrice / $order['sum'] * 100;
                                $data['price'] = ($cart['price'] * $rate) - ($reduce_percentage * $discount['discount'] / 100);
                            }

                            $fawryItems[] = [
                                'itemId' => $data['product_id'],
                                'description' => $product->translation->title,
                                'price' => number_format((float) $data['price'] + (floatval($CurrentPrice * $taxValue) / 100), 2, '.', ''),
                                'quantity' => $data['quantity'],
                                'imageUrl' => asset('website/images/products/'.$product->translation->primary_image),
                            ];

                            $fawryData .= $orderDetails->product_id;
                            $fawryData .= $data['quantity'];
                            $fawryData .= number_format((float) $data['price'] + (floatval($CurrentPrice * $taxValue) / 100), 2, '.', '');

                            if ($lastLoopData == true) {
                                $shipping = number_format((float) $order['shipping_cost'], 2);
                                $fawryItems[] = [
                                    'itemId' => 99999,
                                    'description' => 'Shipping Fees',
                                    'price' => $shipping,
                                    'quantity' => 1,
                                    'imageUrl' => '',
                                ];

                                $fawryData .= 99999;
                                $fawryData .= 1;
                                $fawryData .= $shipping;
                            }
                        }
                    }
                    // }
                }

                CartOption::whereIn('cart_id', $IDS)->delete();
                Cart::where('user_id', $userID)->delete();

                // تنبيه الادمن
                $admins = HelperController::getAllowedAdmins(null, ['57', '58', '59', '60']);
                foreach ($admins as $admin) {
                    if ($orderID && $admin) {
                        Notification::send($admin, new OrderNotification($orderID));
                    }
                }

                // تنبيه البائع
                $orderDetails = OrderDetail::where('order_id', $request->id)->get();
                $vendors = [];
                foreach ($orderDetails as $details) {
                    $vendors[] = Vendor::find($details->vendor_id);
                }

                foreach ($vendors as $vendor) {
                    Notification::send($vendor, new OrderNotification($orderID));
                }

                if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
                    return [
                        'orderID' => $orderID,
                        'fawryData' => $fawryData,
                        'fawryItems' => $fawryItems,
                        'address' => $address,
                        'shipping_cost' => $order['shipping_cost'],
                    ];
                }

                if ($request->payment_method == 'cash') {
                    return [
                        'orderID' => $orderID,
                        'url' => '',
                        'msg' => __('website.added successfully'),
                        'status' => true,
                    ];
                }
            }

            LogApi::create([
                'user_id' => $userID,
                'order_id' => $orderID ?? null,
                'notification' => 'order_not_completed',
                'url' => $request->url(),
                'body' => json_encode($order),
                'type' => 'bug',
            ]);

            return [
                'orderID' => null,
                'url' => '',
                'msg' => __('dashboard.notsaved').'0',
                'status' => false,
            ];
        }

        if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
            LogApi::create([
                'user_id' => $userID,
                'order_id' => $orderID ?? null,
                'notification' => 'order_not_completed',
                'url' => $request->url(),
                'body' => json_encode($order),
                'type' => 'bug',
            ]);

            return null;
        } else {
            LogApi::create([
                'user_id' => $userID,
                'order_id' => $orderID ?? null,
                'notification' => 'order_not_completed',
                'url' => $request->url(),
                'body' => json_encode($order),
                'type' => 'bug',
            ]);

            return [
                'orderID' => null,
                'url' => '',
                'msg' => __('dashboard.notsaved'),
                'status' => false,
            ];
        }
    }

    public function createOrder(Request $request)
    {
        // Session::get('Productmsg') == "" ? $errorMsg = __('website.data error 1') : $errorMsg = Session::get('Productmsg');
        $errorMsg = Session::get('Productmsg');
        // address_id required.
        // code nullable.

        $userID = self::getUserStatus($request)['user_id'];

        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        // if (!is_numeric($request->address_id)){
        //     return $this->NewApiResponse( new \stdClass() ,  __("website.invalid data") , 'false', '200');
        // }

        if ($request->payment_method == null) {
            return $this->NewApiResponse(new \stdClass, __('website.Payment Method Required'), 'false', '200');
        }

        if ($request->address_id == null || $request->address_id == '') {
            return $this->NewApiResponse(new \stdClass, __('website.Address Required'), 'false', '200');
        }
        $create = $this->readFirst($request);

        if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
            if ($create == null) {
                return $this->NewApiResponse(new \stdClass, Session::get('Productmsg'), 'false', '201');
            } else {
                if ($create['orderID'] == null) {
                    return $this->NewApiResponse(new \stdClass, Session::get('Productmsg'), 'false', '202');
                }
                $OrderID = $create['orderID'];
            }
        }

        if ($request->payment_method == 'cash') {
            if ($create == null) {
                return $this->NewApiResponse(new \stdClass, Session::get('Productmsg'), 'false', '203');
            } else {
                if (isset($create['orderID'])) {
                    $settings = Setting::first();
                    if ($settings->send_order_notification == 1 || $settings->send_order_notification == 3) {
                        HelperController::sendMailPublic(
                            self::getUserStatus($request)['user'],
                            __('website.added successfully'),
                            __('dashboard.Your Valuable Order Will Be At Your Address As Soon As Possible.'),
                            'dashboard.user.order_mail_status',
                            __('dashboard.Order Confirmation'),
                            $create['orderID']->id
                        );
                    }

                    $text = __('dashboard.Order Confirmation').'#'.$create['orderID']->id.' : '.__('website.added successfully');
                    if ($settings->send_order_notification == 2 || $settings->send_order_notification == 3) {
                        UsersController::sendSms(self::getUserStatus($request)['user']->phone, $text);
                    }

                    $userFireBaseTokens = UserApiToken::where('user_id', self::getUserStatus($request)['user']->id)
                        // ->where('user_type', 1)
                        // ->distict()->select('firebase_token')
                        ->orderByDesc('id')
                        ->whereNotNull('firebase_token')
                        ->pluck('firebase_token')->toArray();

                    $notification = [
                        'device_token' => $userFireBaseTokens,
                        'title' => 'souqelmlabes',
                        'body' => $text,
                        'id' => 1,
                        'badge' => 0,
                        'click_action' => '/',
                    ];

                    $sendTest = \App\Http\Controllers\helper\HelperController::pushNotification($notification);
                    LogApi::create([
                        'notification' => 'send notification after order',
                        'url' => $request->url(),
                        'body' => $sendTest,
                        // 'signature_before' => $connectedString,
                        // 'signature_after' => $signature,
                    ]);
                    Session::put(['order_title' => $text]);
                    Notification::send(User::find($userID), new OrderNotification($create['orderID']));

                    return $this->NewApiResponse(new \stdClass, __('website.added successfully'), 'true', '200');
                }

                return $this->NewApiResponse(new \stdClass, Session::get('Productmsg'), 'false', '200');
            }
        }

        if (
            $request->payment_method == 'fawry' ||
            $request->payment_method == 'fawry_visa' ||
            $request->payment_method == 'fawry_pay' ||
            $request->payment_method == 'fawry_installment'
        ) {

            $connectedString = 'siYxylRjSPzYgzWk2F3JNA=='.$OrderID->id.$userID.
                // $connectedString = "+/IAAY2notjlTRucwrHhbQ==" . $OrderID->id . Auth::id() .
                str_replace('\/', '/', json_encode(\LaravelLocalization::localizeUrl('fawryCallback'))).
                $create['fawryData'].
                '47f55c16-3fea-4fb5-a82e-12ff17f06f63';
            //   '7063f687-0a44-4213-bff8-c3f53d8ed68a';

            $connectedString = str_replace('"', '', $connectedString);

            $signature = hash('sha256', str_replace('"', '', $connectedString));
            $yourdate = Carbon::tomorrow();
            $stamp = strtotime($yourdate); // get unix timestamp
            $time_in_ms = $stamp * 1000;

            $body = [
                'merchantCode' => 'siYxylRjSPzYgzWk2F3JNA==',
                // 'merchantCode' => "+/IAAY2notjlTRucwrHhbQ==",
                'merchantRefNum' => $OrderID->id,
                'paymentExpiry' => $time_in_ms,
                'customerProfileId' => $userID,
                'customerMobile' => $create['address']->phone,
                'customerName' => $create['address']->name.' '.$create['address']->name,
                'customerEmail' => $create['address']->email ?? '',
                'amount' => number_format((float) $OrderID->total, 2, '.', ''),
                'currencyCode' => 'EGP',
                'chargeItems' => $create['fawryItems'],
                'signature' => $signature,
                'returnUrl' => \LaravelLocalization::localizeUrl('fawryCallback'),
            ];

            $body = str_replace('\/', '/', json_encode($body));
            // dd($body);
            $curl = curl_init();

            LogApi::create([
                'notification' => 'before_fawry_go',
                'url' => $request->url(),
                'body' => $body,
                // 'signature_before' => $connectedString,
                // 'signature_after' => $signature,
            ]);

            curl_setopt_array($curl, [
                // CURLOPT_URL => 'https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init',
                CURLOPT_URL => 'https://atfawry.com/fawrypay-api/api/payments/init',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                ],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);

            LogApi::create([
                'url' => $request->url(),
                'body' => $response,
                'signature_before' => $connectedString,
                'signature_after' => $signature,
            ]);

            $text = __('dashboard.Order Confirmation').'#'.$create['orderID']->id.' : '.__('website.added successfully');
            $userFireBaseTokens = UserApiToken::where('user_id', self::getUserStatus($request)['user']->id)
                // ->where('user_type', 1)
                // ->distict()->select('firebase_token')
                ->orderByDesc('id')
                ->whereNotNull('firebase_token')
                ->pluck('firebase_token')->toArray();
            $notification = [
                'device_token' => $userFireBaseTokens,
                'title' => 'souqelmlabes',
                'body' => $text,
                'id' => 1,
                'badge' => 0,
                'click_action' => '/',
            ];
            $sendTest = \App\Http\Controllers\helper\HelperController::pushNotification($notification);
            // LogApi::create([
            //     'notification' => 'send notification after order',
            //     'url' => $request->url(),
            //     'body' => $sendTest,
            //     // 'signature_before' => $connectedString,
            //     // 'signature_after' => $signature,
            // ]);

            $result = json_encode($response);
            // if (isset($result['merchantRefNumber']) && $result['orderStatus'] == 'PAID'){

            Session::put(['order_title' => $text]);
            Notification::send(User::find($userID), new OrderNotification($create['orderID']));

            return $this->NewApiResponse($response, __('website.added successfully'), 'true', '200');
            // return $this->NewApiResponse( $response ,  $OrderID->id , 'true', '200');
            // }else{
            // return $this->NewApiResponse( "" ,  $response , 'false', '200');
            // return $this->NewApiResponse( "" ,  __('dashboard.notsaved') .'-fawry' , 'false', '200');
            // }
        }

        if ($request->payment_method == 'paymob') {
            $token = $this->getToken();
            $order = $this->createOrder($OrderID, $token);
            $paymentToken = $this->getPaymentToken($OrderID, $request, $order, $token);

            return $this->NewApiResponse(
                'https://accept.paymob.com/api/acceptance/iframes/'.env('PAYMOB_IFRAME_ID').'?payment_token='.$paymentToken,
                __('website.added successfully'),
                'true',
                '200'
            );
        }

        return $this->NewApiResponse(new \stdClass, __('dashboard.notsaved'), 'true', '200');
    }

    public static function getProductTax($product, $payment_method, $price = null)
    {
        $taxValue = 0;
        $taxes = Tax::all();
        foreach ($taxes as $tax) {
            $productCategories = ProductCategory::where('product_id', $product)->pluck('category_id')->toArray();
            if ($tax->status == 1) {
                if (is_numeric($tax->payment_method)) {
                    if ($tax->payment_method == self::getPaymentMethodId($payment_method)) {
                        if (is_numeric($tax->product_categories)) {
                            if ($tax->product_categories != $productCategories) {
                                $taxValue += $tax->value;
                            }
                        } else {
                            $toExclude = explode(',', $tax->product_categories);
                            foreach ($toExclude as $ex) {
                                if (! in_array($ex, $productCategories)) {
                                    $taxValue += $tax->value;
                                }
                            }
                        }
                    }
                } else {
                    $paymentMethodsArray = explode(',', $tax->payment_method);
                    foreach ($paymentMethodsArray as $method) {
                        if ($method == self::getPaymentMethodId($payment_method)) {
                            if (is_numeric($tax->product_categories)) {
                                if ($tax->product_categories != $productCategories) {
                                    $taxValue += $tax->value;
                                }
                            } else {
                                $toExclude = explode(',', $tax->product_categories);
                                foreach ($toExclude as $ex) {
                                    if (! in_array($ex, $productCategories)) {
                                        $taxValue += $tax->value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $result = $taxValue * $price;

        return $taxValue;
    }

    public static function getPaymentMethodId($payment_method)
    {
        switch ($payment_method) {
            case 'cash':
                $id = 1;
                break;
            case 'fawry':
            case 'fawry_visa':
            case 'fawry_pay':
            case 'fawry_installment':
                $id = 2;
                break;
            case 'payabs':
                $id = 3;
                break;
        }

        return $id;
    }

    public function cancelOrder(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $order = Order::where('id', $request->id)->where('user_id', self::getUserStatus($request)['user_id'])->first();
        if (! $order) {
            return $this->NewApiResponse('', __('dashboard.not Found'), 'false', '200');
        }
        if ($order->status > 0) {
            return $this->NewApiResponse('', __('website.can not cancel order in process'), 'false', '200');
        } else {
            if ($order) {
                $order->update(['status' => 4]);

                OrderStatus::create([
                    'order_id' => $order->id,
                    'user_id' => self::getUserStatus($request)['user_id'],
                    'admin_id' => null,
                    'status' => 4,
                    'notes' => 'تم الغاء الطلب من العميل',
                ]);

                Session::put(['order_title' => __('dashboard.Cancelled')]);
                // تنبيه الادمن
                $admins = HelperController::getAllowedAdmins('49');
                foreach ($admins as $admin) {
                    if ($order && $admin) {
                        Notification::send($admin, new OrderNotification($order));
                    }
                }

                // تنبيه البائع
                $orderDetails = OrderDetail::where('order_id', $request->id)->get();
                $vendors = [];
                foreach ($orderDetails as $details) {
                    $vendors[] = Vendor::find($details->vendor_id);
                }
                foreach ($vendors as $vendor) {
                    Notification::send($vendor, new OrderNotification($order));
                }

                return $this->NewApiResponse(new stdClass, __('dashboard.Cancelled Successfully'), 'true', '200');
            }
        }
    }

    public static function getShippingCost($request)
    {
        $userAddress = UserAddress::find($request->address_id);
        if ($userAddress != null) {
            $userCart = Cart::where('user_id', self::getUserStatus($request)['user_id'])->with('options')->get();

            $order['sum'] = 0;
            $order['tax'] = 0;
            $order['total'] = 0;
            $productIDS = [];
            $currency = Currency::where('status', 1)->first();
            $rate = $currency->rate;

            foreach ($userCart as $cart) {
                $optionId = \App\Models\CartOption::where('cart_id', $cart->id)
                    ->where('product_id', $cart->product_id)->first();
                $cartOption = $optionId == null ? null : $optionId->option_item_id;
                $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy(
                    $cart->product_id,
                    $cartOption,
                    false,
                    $cart->quantity
                );

                if ($ProQty != null && $ProQty >= $cart->quantity) {
                    $productIDS[] = $cart->product_id;
                    $FlashSale = OrderService::getFlashSaleValue($cart->product_id);
                    if ($FlashSale[0] == 0) {
                        $data['price'] = OrderService::getProductOptionItemPrice($cart);
                        $data['flash_id'] = null;
                    } else {
                        $data['price'] = $FlashSale[0];
                        $data['flash_id'] = $FlashSale[1];
                    }
                    $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
                    $CurrentPrice = $cart['price'] * $rate;
                    $order['tax'] += floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity);
                    $order['sum'] += $CurrentPrice * $cart->quantity;
                }
            }

            $shippingCost = 0;
            $shippingCostArray = [];
            $order_setting = OrderSetting::first();
            foreach ($userCart as $cart) {
                $product = Product::find($cart->product_id);
                $productCategories = ProductCategory::where('product_id', $cart->product_id)->pluck('category_id')->toArray();
                $orderCategories = explode(',', $order_setting->categories);
                $intersection = array_intersect($productCategories, $orderCategories);
                if ($product) {
                    $shippingCategory = ShippingCategoryArea::where('shipping_category_id', $product->shipping_category)
                        ->where('area_id', $userAddress->area)->first();
                    if ($shippingCategory != null) {

                        if (
                            Carbon::now() > Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_from) &&
                            Carbon::now() < Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_to) &&
                            $order['sum'] >= $order_setting->free_min_amount && count($intersection) > 0
                        ) {
                            if ($order_setting->multi_shipping_cost == 1) {
                                $shippingCostArray[] = 0;
                            } else {
                                $shippingCost += 0;
                            }
                        } else {
                            if ($order_setting->multi_shipping_cost == 1) {
                                $shippingCostArray[] = $shippingCategory->value;
                            } else {
                                $shippingCost += $shippingCategory->value;
                            }
                        }
                    }
                }
            }

            return [
                'costArray' => $shippingCostArray,
                'shippingCost' => $shippingCost,
                'userCart' => $userCart,
                'userAddress' => $userAddress,
            ];
        } else {
            return [
                'costArray' => null,
                'shippingCost' => null,
                'userCart' => null,
                'userAddress' => null,
            ];
        }
    }

    public function rateProduct(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            $user = User::find($user_id->user_id);
            if (! $user) {
                return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
            }
        }

        if (! is_numeric($request->product_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.invalid data'), 'false', '200');
        }

        $test = Rating::where('user_id', $user_id->user_id)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            // ->where('notes', $request->notes)
            ->first();
        if (! $test) {
            Rating::create([
                'product_id' => $request->product_id,
                'rating' => $request->rate,
                'order_id' => $request->order_id,
                'user_id' => $user_id->user_id,
                'notes' => $request->notes,
                'vendor_id' => optional(Product::find($request->product_id))->vendor_id,
            ]);

            return $this->NewApiResponse('', __('website.Saved Successfully'), 'true', '200');
        } else {
            $test->update([
                'product_id' => $request->product_id,
                'rating' => $request->rate,
                'order_id' => $request->order_id,
                'notes' => $request->notes,
                'user_id' => $user_id->user_id,
            ]);

            return $this->NewApiResponse('', __('website.Saved Successfully'), 'true', '200');

            //            return $this->NewApiResponse( "",  __('website.Duplicate Rate') ,'true', '200');
        }
    }
}
