<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\helper\helperController;
use App\Http\Controllers\ApiController;
use App\Http\Resources\address;
use App\Http\Resources\alerts;
use App\Http\Resources\area as ResourcesArea;
use App\Http\Resources\city as ResourcesCity;
use App\Http\Resources\currencies;
use App\Http\Resources\getPhoneData;
use App\Http\Resources\messages;
use App\Http\Resources\old\code;
use App\Http\Resources\products\products;
use App\Http\Resources\users;
use App\Models\Area;
use App\Models\City;
use App\Models\Currency;
use App\Models\CustomerMessage;
use App\Models\Newsletter;
use App\Models\PhoneCheck;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserApiToken;
use App\Models\Vendor;
use App\Models\Wishlist;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use stdClass;

class UserController extends ApiController
{
    use ApiResponseTrait;

    public function wishlist(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $userData = User::find($user->user_id);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if ($userData->wishlist != null) {
            $Userwishlist = $userData->wishlist->pluck('product_id')->toArray();
            $wishlist = Product::active()->whereIn('id', $Userwishlist)
                ->whereHas('translations')
                ->orderByDesc('id')->get();
        }

        return $this->NewApiResponse(products::collection($wishlist), 'true', '200');
    }

    public function AddToWishlist(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'true', '200');
        }

        $data = Wishlist::where('product_id', $request->id)->first();
        if (! isset($data) || $data == '') {

            Wishlist::create([
                'product_id' => $request->product_id,
                'user_id' => $user->user_id,
            ]);

            return $this->NewApiResponse(new stdClass, __('website.added successfully'), 'true', '200');
        }
    }

    public function deleteFromWishlist(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'true', '200');
        }

        $data = Wishlist::where('product_id', $request->product_id)->first();
        if (isset($data) && $data != '') {
            $data->delete();

            return $this->NewApiResponse(false, __('website.deleted successfully'), 'true', '200');
        } else {
            return $this->NewApiResponse(false, __('website.product not found'), 'true', '200');
        }
    }

    public function notifications(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $userData = User::find($user->user_id);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        Session::put(['user_notification_title' => 'مرحبا بك فى موقعنا : '.$userData->name]);
        Session::put(['user_notification_image' => 'products/test.jpg']);

        // Notification::send( $userData , new UserNotification($userData));

        $notifications = $userData->notifications;
        if ($notifications) {
            //            return $this->NewApiResponse($notifications, '' , "true", '200');
            return $this->NewApiResponse([
                'notification' => alerts::collection($notifications),
                'count_unRead' => $userData->unreadNotifications->count(),
            ], '', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, '', 'false', '200');
        }
    }

    public function updateNotification(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $userData = User::find($user->user_id);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        // $userData->unreadNotifications()->update(['read_at' => now()]);
        foreach ($userData->unreadNotifications as $notification) {
            $notification->id == $request->id ? $notification->update(['read_at' => now()]) : null;
        }

        // Notification::send( $userData , new UserNotification($userData));
        $notifications = $userData->notifications;
        if ($notifications) {
            return $this->NewApiResponse(true, '', 'true', '200');
            // return $this->NewApiResponse(alerts::collection($notifications), '' , "true", '200');
        } else {
            return $this->NewApiResponse(new \stdClass, '', 'false', '200');
        }
    }

    public function check(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $userData = User::find($user->user_id);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        $userData = User::find($user->user_id);
        $theCode = PhoneCheck::where('phone', $userData->phone)
            ->where('status', 1)
            ->first();
        if ($theCode == null) {
            return $this->NewApiResponse(new \stdClass, __('website.account not verified'), 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, '', 'true', '200');
        }
    }

    public function createRandomCode(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse('', __('website.account not found'), 'false', '404');
        }

        $userData = User::find($user->user_id);
        $data = self::randomCode($userData->phone);
        self::sendSms([$userData->phone], 'رمز التحقق من الجوال هو : '.$data);

        return $this->NewApiResponse($data, 'تم ارسال كود اخر الى الهاتف', 'true', '200');
    }

    public static function randomCode($phone)
    {
        $random = substr(str_shuffle('0123456789'), 0, 4);
        $theCode = PhoneCheck::where('phone', $phone)
            //                ->where('check_code', $random)
            //                ->where('status', 1)
            ->first();
        if (empty($theCode)) {
            PhoneCheck::create([
                'phone' => $phone,
                'check_code' => $random,
                'status' => 0,
            ]);
        } else {
            if ($theCode->status == 0) {
                PhoneCheck::where('phone', $phone)->update(['check_code' => $random]);
            }
        }

        return $random;
    }

    public function validCode(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $userData = User::find($user->user_id);
        if (! $userData) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        $userData = User::find($user->user_id);
        $theCode = PhoneCheck::where('phone', $userData->phone)
            ->orwhere('phone', $userData->name)
            ->where('status', 0)
            ->first();
        if (! empty($theCode)) {
            PhoneCheck::where('phone', $userData->phone)
                ->where('status', 0)
                ->update([
                    'status' => 1,
                ]);

            return $this->NewApiResponse(new \stdClass, 'valid', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, 'invalid', 'false', '200');
        }
    }

    public static function sendSms($phones, $text)
    {
        //        $url="https://api.taqnyat.sa/v1/messages";
        //        $authorization="67fb17e6de01f0b32e09b7bc2883e232";
        //        $data = array(
        //            //Sender Name must be pre approved by the operator before being used
        //            //يجب ان يتم الموافقة على اسم المرسل من قبل مزود الخدمة قبل البدئ باستخدامه
        //            'sender'=> "wadhefatech",
        //
        //            //You may send message to 1 destination or multiple destinations by supply destinations number in one string and separate the numbers with "," or provide a array of strings
        //            //يمكنك ارسال الرسائل الى جهة واحدة من خلال او اكثر تزويدنا بالارقام في متغير نصي واحد تكون فيه الارقام مفصولة عن بعضها باستخدام "," او من خلال تزويدنا بمصفوفة من الارقام
        //            'recipients'=> $phones, //array("966542320335"),
        //
        //            'body'=> $text,   // "ازى حضرتك بقى ",
        //        );
        //
        //        $data=json_encode($data);
        //
        //        $curl = curl_init();
        //
        //
        //        curl_setopt_array($curl, array(
        //            CURLOPT_URL => $url,
        //            CURLOPT_RETURNTRANSFER => true,
        //            CURLOPT_ENCODING => "",
        //            CURLOPT_MAXREDIRS => 10,
        //            CURLOPT_TIMEOUT => 10,
        //            CURLOPT_FOLLOWLOCATION => true,
        //            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //            CURLOPT_CUSTOMREQUEST => "POST",
        //            CURLOPT_POSTFIELDS=>$data,
        //            CURLOPT_HTTPHEADER => array("Authorization: Bearer ".$authorization)
        //        ));
        //
        //
        //        $response = curl_exec($curl);
        // //        print_r($response);
        // //        return $response;
    }

    public function ForgetPasswordcheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        $test = User::where('phone', $request->phone)->where('status', 1)->first();
        if (empty($test)) {
            return $this->NewApiResponse(new \stdClass, __('validation.attributes.InValidUser'), 'false', '200');
        } else {
            $random = substr(str_shuffle('0123456789'), 0, 4);
            $theCode = PhoneCheck::create([
                'phone' => $request->phone,
                'check_code' => $random,
            ]);

            return $this->NewApiResponse(new code($theCode), '', 'true', '200');
        }
    }

    public function CreateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|email:rfc,dns|unique:users',
            'password' => 'required|string',
            //   'password_confirm' => 'required|string',
            'phone' => 'required|string|unique:users|max:15|min:11',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(
                new \stdClass,
                $validator->errors()->first(),
                'false',
                '200'
            );
        }

        $validPhone = false;
        $valid_network = ['015', '010', '011', '012', '00966', '966'];
        foreach ($valid_network as $network) {
            if (Str::startsWith($request->phone, $network)) {
                $validPhone = true;
            }
        }

        if ($validPhone == false) {
            return $this->NewApiResponse(
                new \stdClass,
                'رقم الهاتف يجب ان يكون صحيحاً',
                'false',
                '200'
            );
        }

        if (! ctype_digit($request->phone)) {
            return $this->NewApiResponse(
                new \stdClass,
                'الهاتف أرقام فقط',
                'false',
                '200'
            );
        }

        $image_name = helperController::make_slug($request->name).'.jpg';
        $request->email == null ? $email = $request->name.env('APP_NAME') : $email = $request->email;
        $user = new User;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->email = $email;
        $user->password = Hash::make($request->password);
        $user->status = 1;

        if ($user->save()) {
            if (isset($request->email) && isset($request->phone)) {
                Newsletter::create([
                    'email' => $request->email,
                    'number' => $request->phone,
                ]);
            }

            $Code = self::randomCode($request->phone);
            $token = Str::random(80);

            $userToken = new UserApiToken;
            $userToken->user_id = $user->id;
            $userToken->api_token = $token;
            $userToken->save();

            if ($request->has('image')) {
                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$image_name);

                helperController::upload_images($path, $destination, $request->file('image'), '150', '150');
            }

            $path = 'https://souqelmlabes.coms.coms.com/website/images/users/';
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone == null ? '' : $user->phone,
                'status' => $user->status,
                'image' => $user->image == null ? '' : $path.$user->image,
                'token' => $token == null ? '' : $token,
                'code' => $Code,
            ];

            $text = 'رمز التحقق للتسجيل في التطبيق هو : '.$Code;
            self::sendSms([$user->phone], $text);
            $userDatas = ['name' => $user->name, 'email' => $user->email, 'title' => $text, 'code' => $Code];

            Mail::send('code', $userDatas, function ($message) use ($userDatas) {
                $message->from('notification@souqelmlabes.com', 'Activation Code');
                $message->to($userDatas['email']);
                $message->subject('Activation Code : '.$userDatas['name']);
            });

            return $this->NewApiResponse($userData, '', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, __('api.RegisterFailed'), 'false', '200');
        }
    }

    public function Update(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'true', '200');
        }

        if ($user_type == 1) {
            $data = User::find($user_id->user_id);

            $validator = Validator::make($request->all(), [
                'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif,',
                'name' => 'nullable|string|max:255|unique:users,name,'.$user_id->user_id,
                'email' => 'nullable|string|email|max:255|unique:users,email,'.$user_id->user_id,
                'phone' => 'nullable|string|min:11|max:11',
                'password' => 'nullable|string|min:6',
            ]);
        } else {
            $data = Vendor::find($user_id->user_id);

            $validator = Validator::make($request->all(), [
                'image' => 'nullable|mimes:jpeg,bmp,png,webp,jfif,',
                'name' => 'nullable|string|max:255|unique:vendors,name,'.$user_id->user_id,
                'email' => 'nullable|string|email|max:255|unique:vendors,email,'.$user_id->user_id,
                'phone' => 'nullable|string|min:11|max:11',
                'password' => 'nullable|string|min:6',
            ]);

            if ($request->phone != null) {
                $DubplicatePhone = Vendor::where('phone', $request->phone)->where('id', '<>', $data->id)->first();
                if ($DubplicatePhone) {
                    return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'true', '200');
                }
            }
        }

        if ($validator->fails()) {
            return $this->NewApiResponse(new users($data), $validator->errors()->first(), 'false', '200');
        }

        if (! isset($data)) {
            return $this->NewApiResponse($user_id->user_id, __('website.account not found'), 'false', '404');
        }

        $image_name = helperController::make_slug($request->name).'.jpg';
        if (isset($request->name)) {
            $data->name = $request->name;
        }
        if ($request->has('image')) {
            $data->image = $image_name;
        }
        if (isset($request->email)) {
            $data->email = $request->email;
        }
        if (isset($request->phone)) {
            $data->phone = $request->phone;
        }
        if (isset($request->password) && $request->password != '') {
            $data->password = Hash::make($request->password);
        }

        // if ($user_type == 1){
        if ($request->has('image')) {
            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$image_name);

            helperController::upload_images($path, $destination, $request->file('image'), '150', '150');
        }
        // }

        if ($data->save()) {
            // if ($user_type == 1){
            $data = User::find($user_id->user_id);

            // }
            // else{
            //     $data = Vendor::find($user_id->user_id);
            // }
            return $this->NewApiResponse(new users($data), __('dashboard.saved'), 'true', '200');
        } else {
            return $this->NewApiResponse(new users($data), 'حدث خطأ جرب مرة أخرى', 'false', '200');
        }
    }

    public function userData(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse($request->header('Authorization'), __('website.account not found'), 'true', '200');
        }

        // if ($user_type == 2){
        //     $data = Vendor::where('id', $user_id->vendor_id)->first();
        // }else{
        $data = User::where('id', $user_id->user_id)->first();

        // }
        return $this->NewApiResponse(new users($data), '', 'true', '200');
    }

    public function delete_account(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse($request->header('Authorization'), __('website.account not found'), 'true', '200');
        }

        // if ($user_type == 2){
        //     Vendor::where('id', $user_id->vendor_id)->delete();
        // }else{
        User::where('id', $user_id->user_id)->delete();

        // }
        return $this->NewApiResponse(new \stdClass, '', 'true', '200');
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
            // return self::NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
            return ['result' => false, 'user_id' => $user->user_id, 'user_type' => $user_type];
        }

        return ['result' => true, 'user_id' => $user->user_id, 'user_type' => $user_type];
    }

    public function userAddress(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $data = User::where('id', self::getUserStatus($request)['user_id'])->first();

        return $this->NewApiResponse(address::collection($data->address), '', 'true', '200');
    }

    public function getAllArea(Request $request)
    {
        // if (self::getUserStatus($request)['result'] == false) {
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $data = Area::whereHas('translations')->get();

        return $this->NewApiResponse(ResourcesArea::collection($data), '', 'true', '200');
    }

    public function getAllCity(Request $request)
    {
        // if (self::getUserStatus($request)['result'] == false) {
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $data = City::where('parent_id', $request->area)->whereHas('translations')->get();

        return $this->NewApiResponse(ResourcesCity::collection($data), '', 'true', '200');
    }

    public function addAddress(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $address = UserAddress::where('user_id', self::getUserStatus($request)['user_id'])
            ->where('city', $request->city)
            ->where('area', $request->area)
            ->where('address', $request->address)->first();
        if (empty($address)) {
            UserAddress::create([
                'user_id' => self::getUserStatus($request)['user_id'],
                'city' => $request->city,
                'area' => $request->area,
                'address' => $request->address,
                'phone' => $request->phone,
                'name' => $request->name,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);

            return $this->NewApiResponse(new stdClass, __('website.added successfully'), 'true', '200');
        }

        return $this->NewApiResponse(new stdClass, __('website.data error'), 'true', '200');
    }

    public function updateAddress(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $address = UserAddress::where('id', $request->id)->first();
        if ($address) {
            $address->update([
                'user_id' => self::getUserStatus($request)['user_id'],
                'city' => $request->city,
                'area' => $request->area,
                'address' => $request->address,
                'phone' => $request->phone,
                'name' => $request->name,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);

            return $this->NewApiResponse(new stdClass, __('dashboard.updated'), 'true', '200');
        }

        return $this->NewApiResponse(new stdClass, __('website.data error'), 'true', '200');
    }

    public function deleteAddress(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        UserAddress::where('id', $request->id)->delete();

        return $this->NewApiResponse(new stdClass, __('website.deleted successfully'), 'true', '200');
    }

    public function currencies(Request $request)
    {
        // if (self::getUserStatus($request)['result'] == false) {
        //     return $this->NewApiResponse( __("website.account not found"),  __("website.account not found") , 'false', '404');
        // }

        $currencies = Currency::where('status', 1)->whereHas('translations')->get();

        return $this->NewApiResponse(currencies::collection($currencies), '', 'true', '200');
    }

    public function supporttickets(Request $request)
    {
        if (self::getUserStatus($request)['result'] == false) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $messages = CustomerMessage::where('contact_user_id', self::getUserStatus($request)['user_id'])->get();

        return $this->NewApiResponse(messages::collection($messages), '', 'true', '200');
    }

    public function phoneList(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        $phones = Input::json()->all();
        $usersList = [];
        $phoneCheck = [];
        foreach ($phones['phones'] as $phone) {
            $phone = trim($phone);
            $phone = str_replace('+2', '', $phone);
            $phone = str_replace('+966', '', $phone);
            $phone = str_replace('+971', '', $phone);
            if (! in_array($phone, $phoneCheck)) {
                $phoneCheck[] = $phone;

                $userFind = User::where('phone', $phone)->first();
                if ($userFind != null) {
                    $usersList[] = ['data' => $userFind, 'status' => true];
                }

                if (empty($userFind)) {
                    $vendorsFind = Vendor::where('phone', $phone)->first();
                    if ($vendorsFind != null) {
                        $usersList[] = ['data' => $vendorsFind, 'status' => true];
                    } else {
                        $data = [
                            'id' => '',
                            'name' => $phone,
                            'phone' => $phone,
                            'email' => '',
                            'status' => '',
                            'image' => '',
                        ];
                        $usersList[] = ['data' => $data, 'status' => false];
                    }
                }
            }
        }

        return $this->NewApiResponse(getPhoneData::collection($usersList), '', 'false', '200');
    }

    public function getPhoneData(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }

        if ($user_type == 2) {
            $user = Vendor::where('phone', $request->phone)->first();
        } else {
            $user = User::where('phone', $request->phone)->first();
        }

        return $this->NewApiResponse(new getPhoneData($user), '', 'false', '200');
    }

    public function UserFirebase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user_id)) {
            return $this->NewApiResponse(new \stdClass, __('website.account not found'), 'false', '404');
        }
        $user_id->update([
            'firebase_token' => $request->firebase_token,
        ]);

        return $this->NewApiResponse(new \stdClass, '', 'true', '200');
    }

    public function ResetPassword(Request $request)
    {
        // $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;

        // $user_id = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        // if (!isset($user_id)){
        //     return $this->NewApiResponse( $request->header('Authorization') ,  __("website.account not found") , 'false', '404');
        // }

        $validator = Validator::make($request->all(), [
            // 'old_password' => 'required|string|max:13',
            'identify' => 'nullable|string',
            // 'phone' => 'nullable|string|max:13',
            // 'email' => 'nullable|string',
            'password' => 'required|string|max:13',
            // 'confirm_password' => 'nullable|string|max:13',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }
        // if ($request->password != $request->confirm_password){
        //     return $this->NewApiResponse( $request->header('Authorization') ,  "كلمة المرور الجديدة غير متطابقة" , 'false', '200');
        // }

        if ($user_type == 'user' || $user_type == null) {
            $user = User::query();
        } else {
            $user = Vendor::query();
        }

        if (is_numeric($request->get('identify'))) {
            return ['identify' => $request->get('identify'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('identify'), FILTER_VALIDATE_EMAIL)) {
            return ['identify' => $request->get('identify'), 'password' => $request->get('password')];
        }
        $data = ['identify' => $request->get('identify'), 'password' => $request->get('password')];

        $user = $user->where($data)->first();
        if (isset($user) && $user != '') {
            // if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password),
            ])->save();

            return $this->NewApiResponse(new \stdClass, 'تم تعديل كلمة المرور بنجاح', 'true', '200');
            // } else {
            //     return $this->NewApiResponse(new \stdClass(), "كلمة المرور الحالية غير صحيحة", 'false', '200');
            // }
        } else {
            return $this->NewApiResponse(new \stdClass, 'حساب غير موجود', 'false', '200');
        }
    }

    public function credentials(Request $request): array
    {
        if (is_numeric($request->get('phone'))) {
            return ['phone' => $request->get('phone'), 'password' => $request->get('password'), 'status' => 1];
        } elseif (filter_var($request->get('phone'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('phone'), 'password' => $request->get('password'), 'status' => 1];
        }

        return ['name' => $request->get('phone'), 'password' => $request->get('password'), 'status' => 1];
    }

    /**
     * تسجيل دخول المستخدم
     *
     * هذه الدالة تقوم بتسجيل دخول المستخدم عن طريق الهاتف وكلمة المرور
     * وتقوم بإنشاء رمز API token للمستخدم بعد التحقق من صحة البيانات
     *
     * @param  Request  $request  تحتوي على بيانات الهاتف وكلمة المرور
     * @return JsonResponse نتائج عملية تسجيل الدخول
     *
     * البيانات المطلوبة:
     * - phone: (string) رقم الهاتف مطلوب
     * - password: (string) كلمة المرور مطلوبة
     *
     * @response {
     *   "status": "true",
     *   "code": "200",
     *   "message": "message or verification code",
     *   "data": {
     *     "id": 1,
     *     "name": "User Name",
     *     "email": "user@example.com",
     *     "user_type": "user",
     *     "phone": "01234567890",
     *     "active": 1,
     *     "image": "users/image.jpg",
     *     "token": "random_api_token_here"
     *   }
     * }
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //            'phone' => 'required|string|max:13|min:9',
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        // $credentials = $request->only('phone', 'password');

        // if ($user_type == 2){
        //     if (Auth::guard('vendor')->attempt([
        //         'phone' => $request->phone,
        //         'password' => $request->password,
        //         'status' => 1
        //     ])){
        //         $user = Vendor::where('phone', $request->phone)->first();
        //     }
        // }else{
        // dd($credentials);
        // if (Auth::guard('web')->attempt([
        //     'phone' => $request->phone,
        //     'password' => $request->password,
        //     'status' => 1
        // ])){
        //     $user = User::where('phone', $request->phone)->first();
        // }else{
        //     if(Auth::guard('web')->attempt([
        //         'email' => $request->phone,
        //         'password' => $request->password,
        //         'status' => 1
        //     ])){
        //         $user = User::where('phone', $request->phone)->first();
        //     }
        // }

        if (Auth::guard()->attempt($this->credentials($request))) {
            $user = Auth::user();
        }
        // }

        if (! (Auth::user()) && ! isset($user)) {
            // dd(Auth::user());
            return $this->NewApiResponse(new \stdClass, __('website.FailedToLogin'), 'false', '200');
        }

        $token = Str::random(80);

        $userToken = new UserApiToken;
        $userToken->user_id = $user->id;
        $userToken->api_token = $token;
        $userToken->user_type = $user_type;
        $userToken->save();

        //        if ($user->status == 0) {
        //            return $this->NewApiResponse( new \stdClass(), __("website.account not verified"), 'false', '200');
        //        }else{
        $path = 'users/';
        if ($user_type == 2) {
            $userData = [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'user_type' => 'vendor',
                'phone' => Auth::user()->phone == null ? '' : Auth::user()->phone,
                'active' => Auth::user()->active,
                'image' => Auth::user()->image == null ? '' : $path.Auth::user()->image,
                'token' => $token == null ? '' : $token,
            ];
        } else {

            $userData = [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'user_type' => 'user',
                'phone' => Auth::user()->phone == null ? '' : Auth::user()->phone,
                'active' => Auth::user()->status,
                'image' => Auth::user()->image == null ? '' : $path.Auth::user()->image,
                'token' => $token == null ? '' : $token,
            ];
        }

        $theCode = PhoneCheck::where('phone', $request->phone)
            ->where('status', 1)
            ->first();
        if (! isset($theCode)) {
            $data = self::randomCode($request->phone);
            self::sendSms([$request->phone], 'رمز التحقق من الهاتف هو : '.$data);

            return $this->NewApiResponse($userData, $data, 'true', '200');
        } else {
            return $this->NewApiResponse($userData, '', 'true', '200');
        }
    }

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:15|min:11',
            'email' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(new \stdClass, $validator->errors()->first(), 'false', '200');
        }

        $user = User::where('phone', $request->phone)->orwhere('email', $request->email)->first();
        if ($user && $user != '') {
            $random = substr(str_shuffle('0123456789'), 0, 4);
            if ($user->phone != null) {
                $data = PhoneCheck::where('phone', $user->phone)->first();
                if ($data) {
                    $data->update(['check_code' => $random]);
                    self::sendMail($user, $random);

                    return $this->NewApiResponse(new code($data), '', 'true', '200');
                } else {
                    PhoneCheck::create([
                        'phone' => $user->phone,
                        'check_code' => $random,
                        'status' => 0,
                    ]);

                    return $this->NewApiResponse(new code($data), '', 'true', '200');
                }
            }
            self::sendMail($user, $random);

            return $this->NewApiResponse($random, '', 'true', '200');
        } else {
            return $this->NewApiResponse(new \stdClass, __('website.data error'), 'false', '200');
        }
    }

    public static function sendMail($user, $random)
    {
        // / send email.

        $userData = ['name' => $user->name, 'email' => $user->email, 'code' => $random];

        Mail::send('code', $userData, function ($message) use ($userData) {
            $message->from('notification@souqelmlabes.com', 'activation Code');
            $message->to($userData['email']);
            $message->subject('كود التحقق هو : '.$userData['name']);
        });
        // / send sms.
    }

    public function logout(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;

        $userToken = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($userToken)) {
            return $this->NewApiResponse(false, __('website.login first'), 'false', '200');
        }
        $userToken->delete();

        return $this->NewApiResponse(true, __('website.logged out'), 'true', '200');
    }
}
