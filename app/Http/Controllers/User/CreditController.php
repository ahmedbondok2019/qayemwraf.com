<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\WebController;
use App\Http\Requests\order\CheckOutRequest;
use App\Models\Cart;
use App\Models\LogApi;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Payments;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CreditController extends WebController
{
    use ApiResponseTrait;

    public function readFirst(Request $request)
    {
        if (empty($request->agree) || $request->agree == null) {
            return redirect(\LaravelLocalization::localizeUrl('user/CreateOrder'));
        }

        // $data = self::imageUpload($request);
        // if (empty($data)) {
        //     alert()->error(__('dashboard.attention') , __('dashboard.Image_required'));
        //     return redirect(\LaravelLocalization::localizeUrl('user/Cart'));
        // }
        // $image_name = $data['image'];

        $data['cart'] = cart::where('user_id', Auth::id())->orderByDesc('id')->get();
        if (empty($data['cart'])) {
            return redirect(\LaravelLocalization::localizeUrl('/'));
        }

        $data['sections'] = $data['cart']->groupBy('item_type');

        $OrderPrice = 0;
        foreach ($data['sections'] as $key => $value) {
            foreach ($value as $i => $items) {
                $itemPriceArray = \App\Http\Controllers\User\CartController::getCartItemPrice($items['item_type'], $items['item_id'], $items['price_for'], $items['adults'], $items['children'], $items['date_from'], $items['date_to'], $items['room_id'], $items['room_count']);
                $OrderPrice += $itemPriceArray['total'];
            }
        }

        $orderDetails = Order::create([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
            'sum' => $OrderPrice,
            'user_id' => Auth::id(),
            'status' => 1,
            'payment_status' => 0,
        ]);

        $Price = 0;
        foreach ($data['sections'] as $key => $value) {
            foreach ($value as $i => $items) {
                $itemPriceArray = \App\Http\Controllers\User\CartController::getCartItemPrice($items['item_type'], $items['item_id'], $items['price_for'], $items['adults'], $items['children'], $items['date_from'], $items['date_to'], $items['room_id'], $items['room_count']);
                $Price += $itemPriceArray['total'];
                $itemPrice = $itemPriceArray['price'];

                $testOrder = OrderDetail::where('item_type', $items['item_type'])
                    ->where('item_id', $items['item_id'])->where('price_for', $items['price_for'])
                    ->where('adults', $items['adults'])->where('children', $items['children'])
                    ->where('date_from', $items['date_from'])->where('date_to', $items['date_to'])
                    ->where('room_id', $items['room_id'])->first();
                if (empty($testOrder)) {
                    if ($items['date_from'] != null && $items['date_to'] != null) {
                        $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $items['date_from']);
                        $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $items['date_to']);
                        $days = $dateFrom->diffInDays($dateTo);

                        $adults = $days;
                        // return $days . '  '. $dateFrom . '  '. $dateTo;
                    } else {
                        $adults = $items['adults'];
                    }

                    OrderDetail::create([
                        'order_id' => $orderDetails->id,
                        'item_type' => $items['item_type'],
                        'item_id' => $items['item_id'],
                        'price_for' => $items['price_for'],
                        'adults' => $adults,
                        'children' => $items['children'],
                        'date_from' => $items['date_from'],
                        'date_to' => $items['date_to'],
                        'room_id' => $items['room_id'],
                        'item_price' => $itemPrice,
                        'total' => $Price,
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        }

        Cart::where('user_id', Auth::id())->delete();

        $inputs = Arr::except($request->all(), ['_token', 'g-recaptcha-response', 'passport', 'agree']);
        // $inputs = array_merge($inputs, ['passport' => $image_name]);
        $orderDetails->update($inputs);

        return $orderDetails->id;
        //        return redirect(\LaravelLocalization::localizeUrl('user/credit'));
    }

    // fawry live mode.
    // https://atfawry.com/fawrypay-api/api/payments/init

    public function credit(CheckOutRequest $request)
    {
        if (in_array($request->payment_method, ['fawry', 'fawry_visa', 'fawry_pay', 'fawry_installment', 'paymob', 'payabs'])) {
            $OrderID = $this->readFirst($request);
            // return $OrderID;
        }
        // return;

        if ($request->payment_method == 'fawry' ||
            $request->payment_method == 'fawry_visa' ||
            $request->payment_method == 'fawry_pay' ||
            $request->payment_method == 'fawry_installment') {

            $orderDetails = OrderDetail::where('order_id', $OrderID)->get();
            $items = [];
            $count = 0;
            $data = '';
            foreach ($orderDetails as $detail) {
                $count += 1;
                $detail->item_type == 'hotels' ? $ItemID = $detail->item_id : $ItemID = $detail->room_id;
                $getItemName = CartController::getItemName($ItemID, $detail->item_type);

                $price = number_format((float) $detail->item_price, 2, '.', '');

                if ($detail->date_from != null && $detail->date_to != null) {
                    $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $detail->date_from);
                    $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $detail->date_to);
                    $days = $dateFrom->diffInDays($dateTo);

                    $adults = $days;
                } else {
                    $adults = $detail->adults;
                }

                $items[] = [
                    'itemId' => $detail->id,
                    'description' => $getItemName['name'],
                    'price' => $price,
                    'quantity' => $adults,
                    'imageUrl' => env('APP_URL').$getItemName['image'],
                ];

                $data .= $detail->id;
                $data .= $detail->adults;
                $data .= $price;
            }

            $connectedString = '+/IAAY2notjlTRucwrHhbQ=='.$OrderID.Auth::id().
            str_replace('\/', '/', json_encode(\LaravelLocalization::localizeUrl('fawryCallback'))).
             $data.
              '7063f687-0a44-4213-bff8-c3f53d8ed68a';

            $connectedString = str_replace('"', '', $connectedString);

            $signature = hash('sha256', str_replace('"', '', $connectedString));
            $yourdate = Carbon::tomorrow();
            $stamp = strtotime($yourdate); // get unix timestamp
            $time_in_ms = $stamp * 1000;

            $body = [
                'merchantCode' => '+/IAAY2notjlTRucwrHhbQ==',
                'merchantRefNum' => $OrderID,
                'paymentExpiry' => $time_in_ms,
                'customerProfileId' => Auth::id(),
                'customerMobile' => $request->bill_phone,
                'customerName' => $request->bill_first_name.' '.$request->bill_last_name,
                'customerEmail' => $request->bill_email,
                'amount' => number_format((float) Order::find($OrderID)->sum, 2, '.', ''),
                'currencyCode' => 'EGP',
                'chargeItems' => $items,
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
                'body' => $body,
                'signature_before' => $connectedString,
                'signature_after' => $signature,
            ]);

            return \Redirect::away($response);

            // return [
            //     $response,
            //     hash('sha256', $connectedString),
            //     str_replace('"', '', $connectedString)
            // ];
        }

        if ($request->payment_method == 'paymob') {
            $token = $this->getToken();
            $order = $this->createOrder($OrderID, $token);
            $paymentToken = $this->getPaymentToken($OrderID, $request, $order, $token);

            return \Redirect::away('https://accept.paymob.com/api/acceptance/iframes/'.env('PAYMOB_IFRAME_ID').'?payment_token='.$paymentToken);
        }
    }

    // //////////////////////////////////////////////
    // paymob integration steps.
    public function getToken()
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => env('PAYMOB_API_KEY'),
        ]);

        return $response->object()->token;
    }

    public function createOrder($order_id, $token)
    {
        $orderDetails = OrderDetail::where('order_id', $order_id)->get();
        $ClientOrder = Order::find($order_id);

        $items = [];
        foreach ($orderDetails as $details) {
            isset($details->room_id) && $details->room_id != null ? $itemID = $details->room_id : $itemID = $details->item_id;
            $getItemName = CartController::getItemName($itemID, $details->item_type);
            $name = $getItemName['name'];
            $items[] = [
                'name' => $name,
                'amount_cents' => $details->total,
                'description' => $name,
                'quantity' => '1',
            ];
        }

        $data = [
            'auth_token' => $token,
            'delivery_needed' => 'false',
            'amount_cents' => $ClientOrder->sum * 100,
            'currency' => 'EGP',
            'items' => $items,
        ];

        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', $data);

        LogApi::create([
            'url' => 'order',
            'body' => $response,
            'payment_method' => 'paymob',
        ]);

        return $response->object();
    }

    public function getPaymentToken($order_id, $request, $order, $token)
    {
        if (isset($order->id)) {
            Order::find($order_id)->update(['online_order_id' => $order->id]);
        }

        $ClientOrder = Order::find($order_id);
        $billingData = [
            'apartment' => 'NA',
            'email' => $request->bill_email,
            'floor' => 'NA',
            'first_name' => $request->bill_first_name,
            'street' => 'NA',
            'building' => 'NA',
            'phone_number' => $request->bill_phone,
            'shipping_method' => 'PKG',
            'postal_code' => 'NA',
            'city' => 'NA',
            'country' => $request->country,
            'last_name' => $request->bill_last_name,
            'state' => 'NA',
        ];

        $data = [
            'auth_token' => $token,
            'amount_cents' => $ClientOrder->sum * 100,
            'expiration' => 3600,
            'order_id' => $order->id,
            'billing_data' => $billingData,
            'currency' => 'EGP',
            'integration_id' => env('PAYMOB_INTEGRATION_ID'),
        ];
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', $data);

        return $response->object()->token;
    }

    public function callback(Request $request)
    {
        // {"currency":"EGP","data_message":"Approved","success":"true",
        //     "integration_id":"3129726","is_auth":"false","merchant_commission":"0",
        //     "source_data_sub_type":"MasterCard","captured_amount":"0","owner":"1077942",
        //     "txn_response_code":"APPROVED","acq_response_code":"00","profile_id":"638598",
        //     "source_data_pan":"2346","is_capture":"false","is_refund":"false","pending":"false",
        //     "refunded_amount_cents":"0","is_standalone_payment":"true",
        //     "has_parent_transaction":"false","created_at":"2022-12-21T22:03:24.331157",
        //     "is_refunded":"false","is_3d_secure":"true","error_occured":"false",
        //     "source_data_type":"card","id":"75501281","updated_at":"2022-12-21T22:03:43.231022","discount_details":"[]","hmac":"3face9983772ee43a2ae457e81a5273860900dec690f01e594dc1dd991a3d794f5a30923add6f41c9043cf5793c181f554513a77dbfab7dcd33bf3d28dd90051","order":"88530320","is_void":"false","is_voided":"false","amount_cents":"7000"}
        LogApi::create([
            'url' => $request->url(),
            'body' => json_encode($request->all()),
            'payment_method' => 'paymob',
        ]);

        $data = $request->all();
        ksort($data);
        $hmac = $data['hmac'];
        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];
        $connectedString = '';
        foreach ($data as $key => $element) {
            if (in_array($key, $array)) {
                $connectedString .= $element;
            }
        }
        $secret = env('PAYMOB_HMAC');
        $hased = hash_hmac('sha512', $connectedString, $secret);
        if ($hased == $hmac) {
            if (isset($request->id) && $request->txn_response_code == 'APPROVED' && $request->success == 'true') {
                $OrderAfterPay = Order::where('online_order_id', $request->order);
                if ($OrderAfterPay) {
                    $OrderAfterPay->update([
                        // 'online_order_id' => $request->order,
                        'payment_status' => $request->success == 'true' || $request->success == true ? 1 : 0,
                        'payment_method' => 'paymob',

                    ]);
                    alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

                    return redirect(\LaravelLocalization::localizeUrl('/user/myaccount'));
                }
            }
        }
        alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));

        return redirect(\LaravelLocalization::localizeUrl('/user/myaccount'));
        //        echo 'not secure'; exit;
    }

    // /////////////////////////////////////////////////////////////////////////

    // ///////////////////////////////////////////////////////////
    // / fawry integration steps.

    public function fawryCallback(Request $request)
    {
        LogApi::create([
            'url' => $request->url(),
            'body' => json_encode($request->all()),
            'notification' => 'creditController_fawrynotification_update_after_order',
        ]);

        if (isset($request->referenceNumber)) {
            // if ($request->orderStatus == 'PAID'){
            $OrderAfterPay = Order::find($request->merchantRefNumber);
            if ($OrderAfterPay) {
                $OrderAfterPay->update([
                    'online_order_id' => intval($request->referenceNumber),
                    'referenceNumber' => intval($request->referenceNumber) != null ? intval($request->referenceNumber) : null,
                    'payment_status' => $request->orderStatus == 'PAID' ? 1 : 0,
                    'payment_method' => 'fawry',
                ]);

                $details = OrderDetail::where('order_id', $OrderAfterPay->id)
                    ->select(
                        DB::raw('SUM(subtotal) as subtotal'),
                        DB::raw('SUM(website_profit) as website_profit'),
                        DB::raw('SUM(vendor_profit_share) as vendor_profit_share'),
                        'vendor_id'
                    )
                    ->groupBy('vendor_id')->get();
                foreach ($details as $item) {
                    Payment::create([
                        'order_id' => $OrderAfterPay->id,
                        'vendor_id' => $item->vendor_id,
                        'amount' => $item->subtotal,
                        'paid_status' => 0,
                        'due_date' => $OrderAfterPay->created_at,
                        'website_profit' => $item->website_profit,
                        'vendor_profit' => $item->vendor_profit_share,
                    ]);
                }
            }

            $settings = Setting::first();
            if ($settings->send_order_notification == 1 || $settings->send_order_notification == 3) {
                HelperController::sendMailPublic(
                    Auth::user(),
                    __('website.added successfully'),
                    __('dashboard.Your Valuable Order Will Be At Your Address As Soon As Possible.'), 'dashboard.user.order_mail', __('dashboard.Order Confirmation'), $request->merchantRefNumber
                );
            }

            if ($settings->send_order_notification == 2 || $settings->send_order_notification == 3) {
                $text = __('dashboard.Order Confirmation').'  '.__('website.added successfully');
                UsersController::sendSms(Auth::user()->phone, $text);
            }

            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

            return redirect(\LaravelLocalization::localizeUrl('/user/myorders'));
            // }
        }
        alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));

        return redirect(\LaravelLocalization::localizeUrl('/user/myorders'));

        // $data = $request->all();
        // dd($data);

        // array:18 [▼
        // "type" => "ChargeResponse"
        // "referenceNumber" => "7108096708"
        // "merchantRefNumber" => "67"
        // "orderAmount" => "4032"
        // "paymentAmount" => "4032"
        // "fawryFees" => "0"
        // "orderStatus" => "PAID"
        // "paymentMethod" => "PayUsingCC"
        // "paymentTime" => "1670770918090"
        // "customerName" => "Sydnee Eaton"
        // "customerMobile" => "01007187555"
        // "customerMail" => "dobony@mailinator.com"
        // "customerProfileId" => "18"
        // "signature" => "55db913c3bbac048c7411c3701665fb7dde1e52ec832419d746bd7b87f9ac1d4"
        // "taxes" => "0"
        // "statusCode" => "200"
        // "statusDescription" => "Operation done successfully"
        // "basketPayment" => "false"
        // ]
    }

    public function fawryPaymentNotificationURL(Request $request)
    {
        LogApi::create([
            'url' => $request->url(),
            'body' => json_encode($request->all()),
            'notification' => 'creditController_fawrynotification',
        ]);

        if (isset($request->merchantRefNumber)) {
            $OrderAfterPay = Order::find($request->merchantRefNumber);
            if ($OrderAfterPay) {
                $OrderAfterPay->update([
                    'online_order_id' => intval($request->fawryRefNumber),
                    'referenceNumber' => intval($request->referenceNumber) != null ? intval($request->referenceNumber) : null,
                    'payment_status' => $request->orderStatus == 'NEW' ? 1 : 0,
                    'payment_method' => 'fawry',
                ]);
            }

            return $this->NewApiResponse('', 'sent successfully...', 'true', '200');
        }

        return $this->NewApiResponse('', 'wrong', 'true', '500');

        // { "requestId":"c72827d084ea4b88949d91dd2db4996e",
        //            "fawryRefNumber":"970177",
        //            "merchantRefNumber":"9708f1cea8b5426cb57922df51b7f790",
        //            "customerMobile":"01004545545",
        //            "customerMail":"fawry@fawry.com",
        //            "paymentAmount":152.00,
        //            "orderAmount":150.00,
        //            "fawryFees":2.00,
        //            "shippingFees":null,
        //            "orderStatus":"NEW",
        //            "paymentMethod":"PAYATFAWRY",
        //            "messageSignature":"56bca514b2cc6822bf972a869a008f03cacebb14d19829368daa647dbc212aa5",
        //            "orderExpiryDate":1533554719314,
        //            "orderItems":[{
        //                            "itemCode":"e6aacbd5a498487ab1a10ae71061535d",
        //                             "price":150.0,
        //                              "quantity":1
        //                            }],
        //            "threeDSInfo": {
        //                               "eci": "05",
        //                               "xid": "VDj97t1qRJWM0ErrY2PtrBiSMQw=",
        //                               "enrolled": "Y",
        //                               "status": "Y",
        //                               "batchNumber": "0",
        //                               "command": "pay",
        //                               "message": "Approved",
        //                               "verSecurityLevel": "05",
        //                               "verStatus": "Y",
        //                               "verType": "3DS",
        //                               "verToken": "gIGCg4SFhoeIiYqLjI2Oj5CRkpM=",
        //                               "version": "1",
        //                               "receiptNumber": "1123456",
        //                               "sessionId": "SESSION0002818019663G5075633E86"
        //                            }
        //            "invoiceInfo": {
        //                                "number": "28176849",
        //                                "businessRefNumber": "w0dd2fss41d2d2qs556",
        //                                "dueDate": "2021-06-19",
        //                                "expiryDate": 1625062277000
        //                            }
        //          }
    }

    // ///////////////////////////////////////////
    public static function imageUpload(Request $request, $oldImage = null)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';

        if ($request->cropped_image != null && file_exists(public_path($request->cropped_image))) {
            self::UploadImagesblog(public_path($request->cropped_image), $image_name, 'passport'.DIRECTORY_SEPARATOR.'small', '', '');
            self::UploadImagesblog(public_path($request->cropped_image), $image_name, 'passport', '', '');
            unlink(public_path($request->cropped_image));

            return ['image' => $image_name, 'body' => __('dashboard.saved'), 'title' => __('dashboard.congratulation'), 'type' => 'success'];
        }
        if (! empty($request->file('passport'))) {
            $ex = $request->file('passport')->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {

                if (isset($oldImage) && $oldImage != null) {
                    if (file_exists(public_path('website/images/passport/small/'.$oldImage))) {
                        unlink('website/images/passport/'.$oldImage);
                    }
                    if (file_exists(public_path('website/images/passport/'.$oldImage))) {
                        unlink('website/images/passport/'.$oldImage);
                    }
                }

                self::UploadImagesblog($request->file('passport'), $image_name, 'passport'.DIRECTORY_SEPARATOR.'small', '', '');
                self::UploadImagesblog($request->file('passport'), $image_name, 'passport', '', '');

                return ['image' => $image_name, 'body' => __('dashboard.saved'), 'title' => __('dashboard.congratulation'), 'type' => 'success'];
            } else {
                return ['image' => $image_name, 'body' => __('dashboard.notsaved'), 'title' => __('dashboard.attention'), 'type' => 'error'];
            }
        } else {
            return ['image' => $image_name, 'body' => __('dashboard.InValidImage'), 'title' => __('dashboard.attention'), 'type' => 'error'];
        }
    }

    public static function UploadImagesBlog($image, $name, $folder, $width = null, $height = null)
    {
        $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder);
        $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$name);

        return HelperController::upload_images($path, $destination, $image, $width, $height);
    }

    public function getNotify()
    {
        $merchantCode = '+/IAAY2notjlTRucwrHhbQ==';
        $merchantRefNumber = '765325778';
        $merchant_sec_key = '7063f687-0a44-4213-bff8-c3f53d8ed68a'; // For the sake of demonstration
        $signature = hash('sha256', $merchantCode.$merchantRefNumber.$merchant_sec_key);
        $httpClient = new \GuzzleHttp\Client; // guzzle 6.3
        $response = $httpClient->request('GET', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status/v2', [
            'query' => [
                'merchantCode' => $merchantCode,
                'merchantRefNumber' => $merchantRefNumber,
                'signature' => $signature,
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(), true);
        $paymentStatus = $response['payment_status']; // get response values
    }
}
