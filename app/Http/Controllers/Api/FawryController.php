<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\helper\HelperController;
use App\Models\LogApi;
use App\Models\Order;
use App\Models\UserApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FawryController extends Controller
{
    use ApiResponseTrait;

    // ///////////////////////////////////////////////////////////
    // / fawry integration steps.

    public function fawryCallback(Request $request)
    {
        LogApi::create([
            'url' => $request->url(),
            'body' => $request->all(),
        ]);

        if (isset($request->merchantRefNumber) && $request->orderStatus == 'PAID') {
            $OrderAfterPay = Order::find($request->merchantRefNumber);
            if ($OrderAfterPay) {
                $OrderAfterPay->update([
                    'online_order_id' => intval($request->referenceNumber),
                    'referenceNumber' => intval($request->referenceNumber) != null ? intval($request->referenceNumber) : null,
                    'payment_status' => $request->statusCode == '200' ? 1 : 0,
                    'payment_method' => 'fawry',
                ]);
            }
            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

            return redirect(\LaravelLocalization::localizeUrl('/user/myaccount'));
        }
        alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));

        return redirect(\LaravelLocalization::localizeUrl('/user/myaccount'));

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
            'notification' => 'fawrynotification',
        ]);

        if (isset($request->merchantRefNumber)) {
            $OrderAfterPay = Order::find($request->merchantRefNumber);
            if ($OrderAfterPay) {
                $orderStatus = 0;
                if ($request->orderStatus == 'NEW') {
                    $orderStatus = 1;
                } else {
                    $orderStatus = 0;
                }
                if ($request->orderStatus == 'PAID') {
                    $orderStatus = 1;
                } else {
                    $orderStatus = 0;
                }
                $OrderAfterPay->update([
                    'online_order_id' => intval($request->fawryRefNumber),
                    'referenceNumber' => intval($request->referenceNumber) != null ? intval($request->referenceNumber) : null,
                    'payment_status' => $orderStatus,
                    'payment_method' => 'fawry',
                ]);
            }
            LogApi::create([
                'url' => $request->url(),
                'body' => 'done',
                'notification' => 'fawrynotification',
            ]);

            $text = __('dashboard.Order Confirmation').'#'.$OrderAfterPay->id.' : '.__('website.added successfully').' '.\LaravelLocalization::localizeUrl('user/complete/'.$OrderAfterPay->id);
            $userFireBaseTokens = UserApiToken::where('user_id', $OrderAfterPay->user_id)
                    // ->where('user_type', 1)
                ->whereNotNull('firebase_token')
                ->pluck('firebase_token')->toArray();

            $notification = [
                'device_token' => $userFireBaseTokens,
                'title' => 'store',
                'body' => $text,
                'id' => 1, 'badge' => 0,
                'click_action' => '/',
            ];

            \App\Http\Controllers\helper\HelperController::pushNotification($notification);

            return $this->NewApiResponse('', 'sent successfully...', 'true', '200');
        }
        LogApi::create([
            'url' => $request->url(),
            'body' => 'failed',
            'notification' => 'fawrynotification',
        ]);

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
        if (! empty($request->file('image'))) {
            $ex = $request->file('image')->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {

                if (isset($oldImage) && $oldImage != null) {
                    if (file_exists(public_path('website/images/passport/small/'.$oldImage))) {
                        unlink('website/images/passport/'.$oldImage);
                    }
                    if (file_exists(public_path('website/images/passport/'.$oldImage))) {
                        unlink('website/images/passport/'.$oldImage);
                    }
                }

                self::UploadImagesblog($request->file('image'), $image_name, 'passport'.DIRECTORY_SEPARATOR.'small', '', '');
                self::UploadImagesblog($request->file('image'), $image_name, 'passport', '', '');

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
}
