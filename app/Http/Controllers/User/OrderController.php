<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\User\CartController as UserCartController;
use App\Http\Controllers\WebController;
use App\Models\Cart;
use App\Models\CartOption;
use App\Models\Currency;
use App\Models\Order;
use App\Models\OrderDetail;
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
use App\Services\FawryService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Models\PaymentMethod;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class OrderController 
{
    public function order_information()
    {
        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        if (! auth()->check()) {
            return redirect()->route('login');
        }
        $data['cart'] = Cart::where('user_id', Auth::id())->with('options')->get();
        $data['sum'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['price'] + $item['tax']) * $item['quantity'] * $rate;
            }, 0);
        $data['addresses'] = Auth::user()->address;
        $data['prices'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['price'] * $item['quantity'] * $rate);
            }, 0);
        $data['taxes'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['tax'] * $item['quantity'] * $rate);
            }, 0);

        return view('dashboard.user.order_information', $data);
    }

    public function checkout(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }
        $data['cart'] = Cart::where('user_id', Auth::id())->with('options')->get();

        if ($request->payment_method == null) {
            return redirect(LaravelLocalization::localizeUrl('user/order_information'))
                ->with('msg', __('website.Payment Method Required'));
        }

        Session::forget(['payment_method', 'address']);
        Session::put([
            'payment_method' => $request->payment_method,
            'address' => $request->address,
        ]);

        if ($request->payment_method == null || $request->address == null || $request->address == '') {
            return redirect(LaravelLocalization::localizeUrl('user/order_information'))
                ->with('msg', __('website.Address Required'));
        }

        $data['payment_method'] = $request->payment_method;
        $data['address'] = $request->address;
        $cost = self::getShippingCost($request);
        if ($cost['costArray'] != null) {
            $data['shipping_cost'] = max($cost['costArray']);
        } else {
            $data['shipping_cost'] = $cost['shippingCost'];
        }

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;

        $data['sum'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate, $request) {
                $taxValue = self::getProductTax($item['product_id'], $request->payment_method);
                $CurrentPrice = $item['price'] * $rate;

                return $carry + ($item['price'] + floatval($CurrentPrice * $taxValue / 100)) * $item['quantity'] * $rate;
            }, 0);
        $data['addresses'] = Auth::user()->address;
        $data['prices'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                return $carry + ($item['price'] * $item['quantity'] * $rate);
            }, 0);

        $data['tax'] = 0;
        $idsToRemove = [];

        foreach ($data['cart'] as $cart) {
            $product = Product::find($cart->product_id);
            $optionId = \App\Models\CartOption::where('cart_id', $cart->id)->where('product_id', $cart->product_id)->first();
            $optionId == null ? $cartOption = null : $cartOption = $optionId->option_item_id;
            $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy($cart->product_id, $cartOption, false, null);
            if ($ProQty != null) {
                $FlashSale = OrderService::getFlashSaleValue($product->id);
                if ($FlashSale[0] == 0) {
                    if (CartController::getProductPrice($product->id) == 0) {
                        if (floatval($product->sale_price) == null || floatval($product->sale_price) == 0) {
                            // original price
                            $cart['price'] = $product->price;
                        } else {
                            $cart['price'] = floatval($product->sale_price);
                        }
                    } else {
                        $cart['price'] = CartController::getProductPrice($product->id);
                    }
                    $cart['flash_id'] = null;
                } else {
                    $cart['price'] = $FlashSale[0];
                    $cart['flash_id'] = $FlashSale[1];
                }

                $input = json_decode($cart->options);
                foreach ($input as $option) {
                    $ProductOptionItem = ProductOptionItem::where('option_id', $option->option_id)
                        ->where('option_item_id', $option->option_item_id)
                        ->where('product_id', $option->product_id)
                        ->first();
                    if (isset($ProductOptionItem)) {
                        if ($ProductOptionItem->isPluse == 1) {
                            $cart['price'] += $ProductOptionItem->difference_in_price;
                        } else {
                            $cart['price'] -= $ProductOptionItem->difference_in_price;
                        }
                    }
                }

                $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
                $CurrentPrice = $cart['price'] * $rate;
                $data['tax'] += floatval((($CurrentPrice * $taxValue) / 100) * $cart->quantity);
            } else {
                $idsToRemove[] = $cart->id;
            }
        }

        return view('dashboard.user.checkout', $data);
    }

    public function index() {}

    public function shipping_cost(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        if (! is_numeric($request->address)) {
            return response()->json(['msg' => __('website.invalid data'), 'status' => false]);
        }

        // address required.
        $data = self::getShippingCost($request);
        if ($data) {
            if ($data['costArray'] != null) {
                return max($data['costArray']);
            } else {
                return $data['shippingCost'];
            }
        }

        return 0;
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

    public function readFirst(Request $request)
    {
        if (! auth()->check()) {
            return $this->errorResponse(route('login'), __('dashboard.login first'));
        }

        // Fetch shipping cost
        $shippingData = self::getShippingCost($request);
        if (empty($shippingData['userCart'])) {
            return $this->errorResponse(LaravelLocalization::localizeUrl('user/checkout'), __('website.invalid data'));
        }

        $shipping_cost = $shippingData['shippingCost'] ?? max($shippingData['costArray'] ?? [0]);

        // Get active currency
        $currency = Currency::where('status', 1)->firstOrFail();
        $rate = $currency->rate;

        $userCart = $shippingData['userCart'];
        $order = [
            'sum' => 0,
            'tax' => 0,
            'total' => 0,
            'discount_amount' => 0,
            'discount_type' => null,
            'coupon_code' => null,
            'status' => 'pending',
            'payment_status' => 'pending',
            'transaction_ref' => null,
            'payment_by' => null,
            'shipping_cost' => $shipping_cost,
            'rate' => $rate,
            'currency' => $currency->translations->title,
        ];

        $productIDs = [];
        foreach ($userCart as $cart) {
            if (! $this->isProductAvailable($cart)) {
                continue;
            }

            $productIDs[] = $cart->product_id;
            [$price, $flashId] = $this->getProductPrice($cart);
            $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
            $currentPrice = $cart->price * $rate;

            $order['tax'] += (($currentPrice * $taxValue) / 100) * $cart->quantity;
            $order['sum'] += $currentPrice * $cart->quantity;
            $order['flash_id'] = $flashId;
        }

        // Apply coupon discount
        $discount = UserCartController::getCouponCode($order['sum'], $request->promo_code, null, $productIDs, $request->payment_method);
        $order['discount_amount'] = $discount['discount'];
        $order['discount_type'] = $discount['promoType'];
        $order['coupon_code'] = $discount['coupon_code'];

        $order['total'] = $order['sum'] + $order['tax'] - $discount['discount'] + $shipping_cost;

        // Check for COD Limit
        if ($request->payment_method) {
            $paymentMethod = PaymentMethod::find($request->payment_method);
            if ($paymentMethod && ($paymentMethod->keyword == 'cash' || $paymentMethod->keyword == 'cod')) {
                if ($paymentMethod->cod_limit && $order['total'] > $paymentMethod->cod_limit) {
                    return $this->errorResponse(
                        LaravelLocalization::localizeUrl('user/checkout'), 
                        __('frontend.Not Available for orders over') . ' ' . $paymentMethod->cod_limit
                    );
                }
            }
        }

        // Get user address
        $address = UserAddress::find($request->address);
        if (! $address) {
            return $this->errorResponse(LaravelLocalization::localizeUrl('user/checkout'), __('dashboard.address not found'));
        }

        $order = array_merge($order, [
            'user_id' => Auth::id(),
            'address' => $address->address,
            'name' => $address->name,
            'phone' => $address->phone,
            'email' => $address->email,
            'lat' => $address->lat,
            'lng' => $address->lng,
            'area' => $address->area,
            'city' => $address->city,
            'payment_method' => $request->payment_method,
            'paid_actual' => $order['total'],
        ]);

        if ($order['sum'] <= 0) {
            return $this->errorResponse(LaravelLocalization::localizeUrl('user/checkout'), __('dashboard.notsaved'));
        }

        $orderID = Order::create($order);
        if (! $orderID) {
            return $this->errorResponse(LaravelLocalization::localizeUrl('user/checkout'), __('dashboard.notsaved'));
        }

        OrderStatus::create(['order_id' => $orderID->id, 'user_id' => Auth::id(), 'status' => 'pending', 'notes' => 'طلب جديد']);

        $this->processOrderDetails($userCart, $orderID, $rate, $discount, $shipping_cost, $request);

        Cart::where('user_id', Auth::id())->delete();

        $this->notifyAdminsAndVendors($orderID, $request);

        if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
            return ['orderID' => $orderID, 'address' => $address, 'shipping_cost' => $shipping_cost];
        }

        return [
            'orderID' => $orderID->id,
            'url' => LaravelLocalization::localizeUrl('user/complete/'.$orderID->id),
            'msg' => __('website.added successfully'),
            'status' => true,
        ];
    }

    /**
     * Check if product is available in the required quantity.
     */
    private function isProductAvailable($cart)
    {
        $optionId = CartOption::where('cart_id', $cart->id)->where('product_id', $cart->product_id)->first();
        $cartOption = $optionId ? $optionId->option_item_id : null;

        return HelperController::getProductQuantiy($cart->product_id, $cartOption, true, $cart->quantity) >= $cart->quantity;
    }

    /**
     * Get the product price, considering flash sale.
     */
    private function getProductPrice($cart)
    {
        $flashSale = OrderService::getFlashSaleValue($cart->product_id);

        return $flashSale[0] == 0
            ? [OrderService::getProductOptionItemPrice($cart), null]
            : [$flashSale[0], $flashSale[1]];
    }

    /**
     * Process order details.
     */
    private function processOrderDetails($userCart, $orderID, $rate, $discount, $shipping_cost, $request)
    {
        foreach ($userCart as $cart) {
            $product = Product::find($cart->product_id);
            [$price, $flashId] = $this->getProductPrice($cart);
            $taxValue = self::getProductTax($cart->product_id, $request->payment_method);
            $currentPrice = $cart->price * $rate;

            $subtotal = $price * $cart->quantity;
            $websiteProfit = $this->calculateProfit($product->vendor_id, $subtotal);
            $vendorProfitShare = $subtotal - $websiteProfit;

            $orderDetailsData = [
                'order_id' => $orderID->id,
                'product_id' => $product->id,
                'vendor_id' => $product->vendor_id,
                'quantity' => $cart->quantity,
                'subtotal' => $subtotal,
                'price' => $price,
                'tax' => floatval((($currentPrice * $taxValue) / 100) * $cart->quantity),
                'website_profit' => $websiteProfit,
                'vendor_profit_share' => $vendorProfitShare,
            ];

            OrderDetail::create($orderDetailsData);
        }
    }

    /**
     * Calculate vendor and website profit.
     */
    private function calculateProfit($vendor_id, $subtotal)
    {
        $vendor = Vendor::find($vendor_id);
        if (! $vendor) {
            return 0;
        }

        $profitGroup = ProfitGroup::find($vendor->profit_group);
        if (! $profitGroup) {
            return 0;
        }

        return $profitGroup->type == 1
            ? $subtotal * ($profitGroup->value / 100)
            : $subtotal + $profitGroup->value;
    }

    /**
     * Notify admins and vendors about the order.
     */
    private function notifyAdminsAndVendors($orderID, $request)
    {
        $admins = HelperController::getAllowedAdmins(null, ['57', '58', '59', '60']);
        foreach ($admins as $admin) {
            Notification::send($admin, new OrderNotification($orderID));
        }

        $vendors = Vendor::whereHas('products', function ($query) use ($orderID) {
            $query->whereHas('orderDetails', function ($q) use ($orderID) {
                $q->where('order_id', $orderID->id);
            });
        })->get();

        foreach ($vendors as $vendor) {
            Notification::send($vendor, new OrderNotification($orderID));
        }
    }

    /**
     * Helper method for error responses.
     */
    private function errorResponse($url, $message)
    {
        return ['url' => $url, 'msg' => $message, 'status' => false];
    }

    public function createOrder(Request $request)
    {
        if ($request->payment_method == null) {
            return redirect(LaravelLocalization::localizeUrl('user/order_information'))
                ->with('msg', __('website.Payment Method Required'));
        }

        if ($request->address == null || $request->address == '') {
            return redirect(LaravelLocalization::localizeUrl('user/order_information'))
                ->with('msg', __('website.Address Required'));
        }
        $create = $this->readFirst($request);

        if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
            if ($create == null) {
                return redirect(LaravelLocalization::localizeUrl('user/checkout'))
                    ->with('msg', __('website.data error'));
            } else {
                if ($create['orderID'] == null) {
                    return redirect(LaravelLocalization::localizeUrl('user/checkout'))
                        ->with('msg', __('website.data error'));
                }
                $OrderID = $create['orderID'];
            }
        }

        if ($request->payment_method == 'cash') {
            if ($create == null) {
                return redirect(LaravelLocalization::localizeUrl('user/checkout'))
                    ->with('msg', __('website.data error'));
            } else {
                self::sendAllToUser($request, $create);

                return redirect($create['url'])->with('msg', $create['msg']);
            }
        }

        if (
            $request->payment_method == 'fawry' ||
            $request->payment_method == 'fawry_visa' ||
            $request->payment_method == 'fawry_pay' ||
            $request->payment_method == 'fawry_installment'
        ) {

            // $response = FawryService::fawryPay($request , $create , $OrderID);
            // return \Redirect::away($response);
        }

        if ($request->payment_method == 'paymob') {
            $token = $this->getToken();
            $order = $this->createOrder($OrderID, $token);
            $paymentToken = $this->getPaymentToken($OrderID, $request, $order, $token);

            return Redirect::away('https://accept.paymob.com/api/acceptance/iframes/'.env('PAYMOB_IFRAME_ID').'?payment_token='.$paymentToken);
        }

        alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));

        return redirect(LaravelLocalization::localizeUrl('/user/checkout'));
    }

    public static function sendAllToUser(Request $request, $create)
    {
        if (isset($create['orderID']) && $create['orderID'] != null) {
            $settings = Setting::first();
            // if($settings->send_order_notification == 1 || $settings->send_order_notification == 3){
            //     HelperController::sendMailPublic(
            //         Auth::user() ,
            //         $create['msg'] ,
            //         __("dashboard.Your Valuable Order Will Be At Your Address As Soon As Possible.") ,
            //         'dashboard.user.order_mail' ,
            //         __('dashboard.Order Confirmation') ,
            //         $create['orderID']
            //         );
            // }

            // if($settings->send_order_notification == 2 || $settings->send_order_notification == 3){
            //     $text = __('dashboard.Order Confirmation') . "#" . $create['orderID'] . " : " . $create['msg'] . ' ' . \LaravelLocalization::localizeUrl('user/complete/' . $create['orderID']);
            //     UsersController::sendSms(Auth::user()->phone, $text);
            //     $phones = self::getPhones($request->address);
            //     foreach ($phones as $phone) {
            //         UsersController::sendSms($phone, $text);
            //     }
            // }
        }
    }

    public static function getPhones($address)
    {
        $address = UserAddress::find($address);
        $phone = str_replace('/', ',', str_replace('-', ',', str_replace(' ', ',', $address->phone)));
        $phone = self::GetChilds(',', $phone, $phone);

        return $phone;
    }

    public static function GetChilds($delimiter, $phoneData)
    {
        $phone = [];
        $userPhone = explode($delimiter, $phoneData);
        if (is_array($userPhone)) {
            foreach ($userPhone as $phones) {
                if (strlen($phones) < 12) {
                    $phone[] = $phones;
                }
            }
        } else {
            if (strlen($userPhone) < 12) {
                $phone[] = $userPhone;
            }
        }

        return collect($phone)->unique()->toArray();
    }

    public function complete(Request $request)
    {
        $data['details'] = Order::where('id', $request->id)->where('user_id', Auth::id())->firstorFail();

        return view('dashboard.user.completed', $data);
    }

    public function cancelOrder(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $order = Order::where('id', $request->id)->where('user_id', Auth::id())->first();
        if (! $order) {
            return response()->json(['msg' => __('dashboard.not Found'), 'status' => false]);
        }
        if ($order->status > 0) {
            return response()->json(['msg' => __('website.can not cancel order in process'), 'status' => false]);
        } else {
            if ($order) {
                $order->update(['status' => 4]);

                OrderStatus::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
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

                return response()->json(['msg' => __('dashboard.Cancelled Successfully'), 'status' => true]);
            }
        }
    }

    public static function getShippingCost($request)
    {
        if (empty($request['address'])) {
            $payment_method = Session::get('payment_method');
            $address = Session::get('address');
        } else {
            $payment_method = $request['payment_method'];
            $address = $request['address'];
        }
        $userAddress = UserAddress::find($address);
        if ($userAddress != null) {
            $userCart = Cart::where('user_id', Auth::id())->with('options')->orderBy('product_id')->get();

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
                    $data['price'] = OrderService::getProductOptionItemPrice($cart);
                    if ($payment_method !== null) {
                        $taxValue = self::getProductTax($cart->product_id, $payment_method);
                    }
                    $CurrentPrice = $cart['price'] * $rate;
                    $order['tax'] += floatval(($CurrentPrice * $taxValue / 100) * $cart->quantity);
                    $order['sum'] += $CurrentPrice * $cart->quantity;
                }
            }

            // New Shipping Calculation Logic based on ShippingRule (Country & Governorate)
            $shippingCost = 0;
            $shippingCostArray = []; // Kept for compatibility if needed, though mostly unused now
            
            $shippingRule = \App\Models\ShippingRule::where('country_id', $userAddress->country_id)
                ->where('is_active', 1)
                ->first();

            if ($shippingRule) {
                // Find rate for specific governorate
                $govRate = $shippingRule->governorateRates()
                    ->where('governorate_id', $userAddress->governorate_id)
                    ->first();

                if ($govRate) {
                    $shippingCost = $govRate->rate;
                }
            }

            // Free Shipping Logic taking OrderSettings into account
            $order_setting = OrderSetting::first();
            if ($order_setting) {
                 if (
                    Carbon::now() > Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_from) &&
                    Carbon::now() < Carbon::createFromFormat('Y-m-d H:i:s', $order_setting->date_to) &&
                    $order['sum'] >= $order_setting->free_min_amount
                ) {
                    $shippingCost = 0;
                    $shippingCostArray = [0];
                }
            }

            return [
                'costArray' => $shippingCostArray, // May be empty or contain 0
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
        $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            $user = User::find($user_id->user_id);
            if (! $user) {
                return response()->json(['msg' => __('website.account not found'), 'status' => false]);
            }
        }

        if (! is_numeric($request->product_id)) {
            return response()->json(['msg' => __('website.invalid data'), 'status' => false]);
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

            return response()->json(['msg' => __('website.Saved Successfully'), 'status' => true]);
        } else {
            $test->update([
                'product_id' => $request->product_id,
                'rating' => $request->rate,
                'order_id' => $request->order_id,
                'notes' => $request->notes,
                'user_id' => $user_id->user_id,
            ]);

            return response()->json(['msg' => __('website.Saved Successfully'), 'status' => true]);

            //            return $this->NewApiResponse( "",  __('website.Duplicate Rate') ,'true', '200');
        }
    }

    public function updateOrder(Request $request)
    {
        // if (is_numeric($request->id))
        // {
        if (! auth()->check()) {
            return redirect('login');
        }

        if ($request->quantity <= 0) {
            return redirect('Cart');
        }

        if ($request->id) {
            $order = Cart::where('id', $request->id)->where('user_id', Auth::id())->first();
            $subtotal = $request->quantity * ($order->price + $order->tax);
            $order->update([
                'subtotal' => $subtotal,
                'quantity' => $request->quantity,
            ]);
        }
        // $discount = 0;
        $cart = Cart::where('user_id', Auth::id())->get();
        $productIDS = Cart::where('user_id', Auth::id())->pluck('product_id');
        $subtotals = $cart->sum('subtotal');
        $taxes = $cart->sum('tax');

        $discount = UserCartController::getCouponCode(null, $request->code, null, $productIDS, $request->payment_method);

        return response()->json([
            'subtotals' => $subtotals,
            'taxes' => $taxes,
            'discount' => $discount['discount'],
            'id' => $request->id,
        ]);
        // }
    }

    public function deleteOrder(Request $request)
    {
        if (is_numeric($request->id)) {
            if (! auth()->check()) {
                return redirect('login');
            }
            $order = Order::where('user_id', Auth::user()->id)->where('id', $request->id)->first();
            if ($order->status > 0 || $order->payment_status == '1') {
                return response()->json([
                    'id' => '',
                    'status' => false,
                    'msg' => __('website.can not cancel order in process'),
                ]);
            } else {
                if ($order) {
                    $order->update(['status' => 4]);

                    OrderStatus::create([
                        'order_id' => $order->id,
                        'user_id' => Auth::id(),
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
                }
            }

            if ($request->ajax()) {
                return response()->json(['id' => $request->id, 'status' => true]);
            }
        }
    }
}
