<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\users;
use App\Http\Resources\vendors;
use App\Models\ApplicationCashback;
use App\Models\Balance;
use App\Models\Cashback;
use App\Models\LogApi;
use App\Models\Transaction;
use App\Models\User;
use App\Models\users_api_tokens;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCodeController extends Controller
{
    use ApiResponseTrait;

    public function add_amount(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = users_api_tokens::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse('', __('website.account not found'), 'false', '200');
        }

        if (! isset($request->amount)) {
            return $this->NewApiResponse('', __('website.data error'), 'false', '200');
        }
        $amount = $request->amount;
        if ($amount > 0) {
            Balance::create([
                'amount' => $amount,
                'type' => 1,
                'user_id' => $user->user_id,
                'reason' => 1,
                'status' => 1, // 0-pending 1-done
                'user_type' => 'user',
            ]);

            return $this->NewApiResponse(new \stdClass, __('website.added successfully...'), 'true', '200');
        }
    }

    public function send(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = users_api_tokens::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse('', __('website.account not found'), 'false', '404');
        }

        $user_to = 0;
        $Rec_Type = 'user';
        if (isset($request->user_to)) {
            $user_to = $request->user_to;
            $Rec_Type = $request->user_type;
        }

        if (isset($request->send_code)) {
            $findCode = Vendor::where('send_code', $request->send_code)->first();
            if (! empty($findCode)) {
                $user_to = $findCode->id;
                $Rec_Type = 'vendor';
            } else {
                $userTo = User::where('send_code', $request->send_code)->first();
                $user_to = $userTo->id;
                $Rec_Type = 'user';
            }
        }

        // /

        $plus = Balance::where('user_id', $user->user_id)
            ->where('user_type', $user_type)
            ->where('type', 1)->sum('amount');
        $minus = Balance::where('user_id', $user->user_id)
            ->where('user_type', $user_type)
            ->where('type', 2)->sum('amount');
        $balance = intval($plus - $minus);
        if ($balance < 0 || $request->amount > $balance) {
            return $this->NewApiResponse('', __('website.balance not enough'), 'false', '200');
        }

        if (! isset($request->amount) || $request->amount < 1) {
            return $this->NewApiResponse('', __('website.invalid amount'), 'false', '200');
        }
        $amount = $request->amount;
        $code = Str::random(20);

        $transaction = Transaction::create([
            'amount' => $amount,
            'user_from' => $user->user_id,
            'user_to' => $user_to,
            'status' => 1,
            'transaction_code' => $code,
        ]);

        if ($Rec_Type == 'vendor') {
            $vendor = Vendor::find($user_to);
            if ($vendor) {
                $ratio = $vendor->cash_back_ratio;

                if ($ratio > 10) {
                    $clientRatio = 10;
                } else {
                    $clientRatio = $ratio / 2;
                }

                $clientCashBack = $clientRatio * $amount / 100;
                $totalCashBack = $ratio * $amount / 100;

                $createClientCashBack = self::createCashBack(intval($clientCashBack), $transaction->id, $user->user_id, 1);

                $user_discount = self::createBalance($amount, $transaction->id, $user->user_id, 2, 1, $user_type);
                $user_add = self::createBalance($amount - $totalCashBack, $transaction->id, $user_to, 1, 1, $Rec_Type);

                ApplicationCashback::create([
                    'amount' => $totalCashBack - $clientCashBack,
                    'transaction_id' => $transaction->id,
                    'user_id' => $user_to,
                    'balance_id' => $user_add,
                ]);
            }
        } else {
            $user_discount = self::createBalance($amount, $transaction->id, $user->user_id, 2, 1, $user_type);
            $user_add = self::createBalance($amount, $transaction->id, $user_to, 1, 1, $Rec_Type);
        }

        $userFireBaseTokens = users_api_tokens::where('user_id', $user_to)
            ->where('user_type', $Rec_Type)
            ->whereNotNull('firebase_token')
            ->pluck('firebase_token')->toArray();

        $notification = [
            'device_token' => $userFireBaseTokens,
            'title' => 'jaguar',
            'body' => __('dashboard.receive amount from :').' '.$amount.' '.optional(User::find($user->user_id))->name,
            'id' => $user->user_id, 'badge' => 0,
            'click_action' => '/',
        ];

        $result = \App\Http\Controllers\helper\HelperController::pushNotification($notification);
        LogApi::create([
            'url' => $request->url(),
            'body' => $request,
            'fire_base_result' => $result,
            'userFireBaseTokens' => empty($userFireBaseTokens) ? $user_to.$Rec_Type : json_encode($userFireBaseTokens),
        ]);
        // }

        return $this->NewApiResponse('', __('website.sent successfully...'), 'true', '200');
    }

    public function receive(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = users_api_tokens::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if ($user_type == 2) {
            $userData = Vendor::find($user->user_id);
        } else {
            $userData = User::find($user->user_id);
        }

        //        if (!isset($request->code)){
        //            return $this->NewApiResponse( new \stdClass() ,  __("website.data error") , 'false', '200');
        //        }

        //        $amount = $request->code;
        //
        //        $transaction = Transaction::where('transaction_code', $request->code)->first();
        //        $transaction->update([
        //            "status" => 1
        //        ]);
        //
        //        Balance::where("transaction_id" , $transaction->id)->update([
        //            "status" => 1 // 0-pending 1-done
        //        ]);

        if (! empty($userData->send_code)) {
            $image = QrCode::format('png')
                ->size(500)
                ->margin(10)
                ->generate($userData->send_code);

            $output_file = 'img-'.time().'.png';
            Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png

            $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
            $toRemove = '/home/hsuy27cy5ovw/jaguar/public/';
            $url = str_replace($toRemove, '', $path);

            if (empty($request->user_to)) {
                $fullUrl = 'https://jaguar/'.$url.$output_file;
            }

            return $this->NewApiResponse($fullUrl, __('website.received successfully'), 'true', '200');
        } else {
            return $this->NewApiResponse('', __('website.Send Code Empty'), 'true', '200');
        }
    }

    public static function createBalance($amount, $transaction_id, $user_id, $type, $reason, $user_type)
    {
        $data = Balance::create([
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'reason' => $reason,
            'type' => $type,
        ]);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public static function createCashBack($amount, $transaction_id, $user_id, $type)
    {
        $data = Cashback::create([
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'user_id' => $user_id,
            'type' => $type,
        ]);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function sendPushNotification($registration_ids, $message)
    {

        ignore_user_abort();
        ob_start();

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = [
            'to' => $registration_ids,
            'data' => $message,
        ];

        // define('GOOGLE_API_KEY', 'AIzaSyC.......VdYCoD8A');

        $headers = [
            'Authorization:key=AAAA_VZrrAE:APA91bEWRewsM830AgEOallbsfZ0sL78rX4UdS70NN0iXn6ng7vbuujAn4L-NZ7FA_qyc6cb9hzCoQS3hYlkiCq5eSOpBLwcdco56Aduxq3vrCYLXhgsGQPUkoiDHCeFPPqclF3KlQLr',
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === false) {
            exit('Curl failed '.curl_error());
        }

        curl_close($ch);

        return $result;
        ob_flush();
    }

    protected function credentials(Request $request): array
    {
        if (Str::startsWith($request->get('phone'), '01')) {
            return ['phone' => $request->get('phone')];
        }

        return ['name' => $request->get('phone')];
    }

    public function searchUser(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = users_api_tokens::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        $Client = User::where($this->credentials($request))->get();
        if (count($Client) < 1) {
            $Client = Vendor::where($this->credentials($request))->get();
            if (count($Client) < 1) {
                return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
            }

            return $this->NewApiResponse(vendors::collection($Client), '', 'true', '200');
        }

        return $this->NewApiResponse(users::collection($Client), '', 'true', '200');
    }

    public static function simpleQrCode($code)
    {
        $image = QrCode::format('png')
//            ->merge(public_path('website/images/barcode.png'), 0.5, true)
            ->size(250)
            ->margin(100)
            ->generate($code);

        $output_file = 'img-'.time().'.png';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png

        $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
        $toRemove = '/home/hsuy27cy5ovw/jaguar/public/';
        $url = str_replace($toRemove, '', $path);

        return 'https://jaguar/'.$url.$output_file;
    }

    public function colorQrCode()
    {
        return \QrCode::size(300)
            ->backgroundColor(255, 55, 0)
            ->generate('test');
    }

    public function imageQrCode()
    {
        $image = QrCode::format('png')
//            ->merge(public_path('website/images/barcode.png'), 0.5, true)
            ->size(500)
            ->generate('A simple example of QR code!');

        // //////// upload images.
        $output_file = 'img-'.time().'.png';

        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png

        //        $output_file = '/img/qr-code/img-' . time() . '.png';
        //        Storage::disk('local')->put($output_file, $image); //storage/app/public/img/qr-code/img-1557309130.png

        //        return response($image)->header('Content-type','image/png');

    }
}
