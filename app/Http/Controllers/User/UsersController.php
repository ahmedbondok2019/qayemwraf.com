<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\helper\HelperController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WebController;
use App\Http\Requests\users\CreateUserRequest;
use App\Http\Requests\users\UpdateUserRequest;
use App\Models\Area;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\LogApi;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\Order;
use App\Models\PhoneCheck;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Verification;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Socialite;

class UsersController extends WebController
{
    public function login()
    {
        if (\auth()->check()) {
            return redirect(LaravelLocalization::localizeUrl('user/home'));
        }

        return view('dashboard.user.login');
    }

    public function register(Request $request)
    {
        if (\auth()->check()) {
            return redirect(LaravelLocalization::localizeUrl('user/home'));
        }

        $countries = \App\Models\Country::active()->with('translations')->get();

        return view('dashboard.user.register', compact('countries'));
    }

    public function forgetPassword(Request $request)
    {
        if (\auth()->check()) {
            return redirect(LaravelLocalization::localizeUrl('user/home'));
        }

        return view('dashboard.user.forget_password');
    }

    public function create(CreateUserRequest $request)
    {
        // dd($request->all());
        $save = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'country_id' => $request->country_id,
            'status' => 1,
            'password' => Hash::make($request->password),
            'accept' => $request->accept,
            'permission_sms' => $request->permission_sms,
            'permission_email' => $request->permission_email,
            'permission_phone_call' => $request->permission_phone_call,
        ]);

        if ($save) {
            Auth::login($save, true);
            // $Code = self::randomCode($request->phone);
            // Session::put(['UserCode' => $Code , 'UserPhone' => $request->phone]);
            // $text = env('APP_NAME') . "كود التحقق فى  : " . $Code;
            // self::sendSms($request->phone, $text);

            if (isset($request->email) && isset($request->phone)) {
                Newsletter::create([
                    'email' => $request->email,
                    'number' => $request->phone,
                ]);
            }

            $CurrentUrl = Session::put(['CurrentUrl' => $request->url()]);
            $CurrentUrl == null ? $targetUrl = LaravelLocalization::localizeUrl('user/home') : $targetUrl = $CurrentUrl;

            return redirect($targetUrl);
        } else {
            alert()->error(__('dashboard.notsaved'), __('website.can not update user , please try again'));

            return redirect(route('user.register'));
        }
    }

    public function validateEmail()
    {
        $text = Str::random(80);
        $url = 'https://souqelmlabes.com/'.app()->getLocale().'/user/validate/'.$text.'/2';
        HelperController::sendCode($url);
        Verification::create(['user_id' => Auth::id(), 'code' => $text, 'type' => 1]);

        return __('website.We Sent Verification Message');
    }

    public function validatePhone()
    {
        $text = Str::random(80);
        $url = 'https://souqelmlabes.coms.com/'.app()->getLocale().'/user/validate/'.$text.'/2';
        self::sendSms(Auth::user()->phone, $url);
        Verification::create(['user_id' => Auth::id(), 'code' => $text, 'type' => 2]);

        return __('website.We Sent Verification Message');
    }

    public function validateLink(Request $request)
    {
        $validateLink = Verification::where('code', $request->code)->where('type', $request->type)->first();
        if ($validateLink) {
            $updateUser = User::where('id', $validateLink->user_id);
            if ($request->type == 1) {
                $updateUser = $updateUser->update(['email_verified_at' => Carbon::now()]);
            } else {
                $updateUser = $updateUser->update(['phone_verified_at' => Carbon::now()]);
            }
        }

        return redirect('user/myaccount');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::where('id', Auth::id())->first();
        if (! is_null($request->oldpassword)) {
            if (Hash::check($request->oldpassword, $user->password)) {
                if (! is_null($request->password)) {
                    $user->password = Hash::make($request->password);
                }
            } else {
                alert()->error(__('dashboard.notsaved'), __('website.wrong password'));

                return redirect(LaravelLocalization::localizeUrl('user/myaccount'));
            }
        }
        if (isset($request->name) && $request->name != '') {
            $user->name = $request->name;
        }
        // if (isset($request->email) && $request->email != ''){ $user->email = $request->email; }
        if (isset($request->phone) && $request->phone != '') {
            $user->phone = $request->phone;
        }
        if (isset($request->permission_sms) && $request->permission_sms != '') {
            $user->permission_sms = $request->permission_sms;
        }
        if (isset($request->permission_email) && $request->permission_email != '') {
            $user->permission_email = $request->permission_email;
        }
        if (isset($request->permission_phone_call) && $request->permission_phone_call != '') {
            $user->permission_phone_call = $request->permission_phone_call;
        }

        if ($user->save()) {
            // if($request->ajax()){
            // return response()->json(['msg' => __('dashboard.saved') , 'data' => $user]);
            // }
            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

            return redirect(LaravelLocalization::localizeUrl('user/myaccount'));
            // }else{
            // if($request->ajax()){
            // return response()->json(['msg' => __('dashboard.notsaved') , 'data' => $user]);
            // }
            alert()->error(__('dashboard.notsaved'), __('website.can not update user , please try again'));

            return redirect(LaravelLocalization::localizeUrl('user/myaccount'));
        }
        // }else{

        // }
        // return response()->json(['msg' => __('dashboard.notsaved') , 'data' => $user]);

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::id().',deleted_at'],
            'password' => ['nullable', 'string', 'min:8', 'max:30'],
            'cpassword' => ['nullable', 'string', 'min:8', 'max:30', 'same:password'],
        ]);

        $user = User::where('id', Auth::id())->first();

        // if (Hash::check($request->oldpassword, $user->password)) {
        if (isset($request->name) && $request->name != '') {
            $user->name = $request->name;
        }
        if (isset($request->email) && $request->email != '') {
            $user->email = $request->email;
        }
        if (isset($request->phone) && $request->phone != '') {
            $user->phone = $request->phone;
        }
        if (isset($request->permission_sms) && $request->permission_sms != '') {
            $user->permission_sms = $request->permission_sms;
        }
        if (isset($request->permission_email) && $request->permission_email != '') {
            $user->permission_email = $request->permission_email;
        }
        if (isset($request->permission_phone_call) && $request->permission_phone_call != '') {
            $user->permission_phone_call = $request->permission_phone_call;
        }
        if (! is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

            return redirect(LaravelLocalization::localizeUrl('user/myaccount'));
        } else {
            alert()->error(__('dashboard.notsaved'), __('website.can not update user , please try again'));

            return redirect(LaravelLocalization::localizeUrl('user/myaccount'));
        }
        // }else{
        //     alert()->error( __('dashboard.notsaved') , __('website.wrong password'));
        //     return redirect(\LaravelLocalization::localizeUrl('user/myaccount'));
        // }

    }

    public function username()
    {
        $field = \request()->input('username');
        $login = filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        \request()->merge([$login => $field]);

        return $login;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    // protected function attemptLogin(Request $request)
    // {
    //     return $this->guard()->attempt(
    //         $this->credentials($request), $request->filled('remember')
    //     );
    // }
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function check(Request $request)
    {
        $this->validateLogin($request);
        if (Auth::guard('web')->attempt($this->credentials($request), $request->filled('remember'))) {
            $CurrentUrl = Session::get('CurrentUrl');
            $CurrentUrl == null ? $targetUrl = LaravelLocalization::localizeUrl('user/home') : $targetUrl = $CurrentUrl;

            return redirect($targetUrl);
            // return redirect()->route('user.home');
        } else {
            alert()->error(__('website.please try again'), __('website.wrong email or password'));

            return redirect(LaravelLocalization::localizeUrl('user/login'))->withInput();
        }
    }

    public function verify()
    {
        $testVerfiy = PhoneCheck::where('phone', Auth::user()->phone)->first();
        if (empty($testVerfiy)) {
            return redirect()->route('user.verify')->with('msg', 'الهاتف غير موجود.');
        } else {
            if ($testVerfiy->status == 1) {
                return redirect()->route('home');
            }
        }

        return view('auth.verification_code');
    }

    public function chechVerificationCode(Request $request)
    {
        $code = str_replace(',', '', $request->code);
        $chechCode = PhoneCheck::where('phone', Auth::user()->phone)->where('check_code', $code)->first();
        if (empty($chechCode)) {
            return response()->json(['msg' => '', 'status' => false]);
        } else {
            if ($chechCode->status != 1) {
                $chechCode->update(['status' => 1]);
            }

            return response()->json(['msg' => '', 'status' => true]);
        }
    }

    public function verification_resend()
    {
        return view('auth.verification_code')->with('msg', 'تم ارسال رمز التحقق مرة اخرى');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return redirect(LaravelLocalization::localizeURL('/'));
    }

    public function index(Request $request)
    {
        // $chechCode = PhoneCheck::where('phone' , Auth::user()->phone)->where('status' , 1)->first();
        // if(empty($chechCode)){
        //     return redirect()->route('user.verify');
        // }

        $data['sliders'] = Slider::whereHas('SliderTranslation')->orderByDesc('id')->get();
        $product = ProductCategory::pluck('product_id');
        $Cat = ProductCategory::pluck('category_id');
        $data['top_categories'] = Category::whereNotNull('show_category')->static()
            ->where('parent_id', 0)->whereHas('CategoryTranslation')->get();
        $data['home_categories'] = Category::whereNotNull('show_category')->where('parent_id', 0)->static()->whereIN('id', $Cat)->whereHas('CategoryTranslation')->limit(16)->get();
        $data['static_category'] = Category::whereNotNull('show_category')->where('static', 1)->whereHas('CategoryTranslation')->first();
        // $categories = Category::whereIN('id', $productCat)->whereHas('CategoryTranslation')->pluck('id');
        $orders = DB::table('order_details')
            ->select(DB::raw('count(*) as product_id'))
            ->groupBy('product_id')
            ->pluck('product_id');

        $data['best'] = Product::active()->where(function ($query) use ($product, $orders) {
            $query->whereIn('id', $product)->orwhereIn('id', $orders);
        })->whereHas('translations')->inRandomOrder()->limit(15)->get();
        $flashdeals = ProductsController::getFlashSale();
        $data['flash'] = Product::active()
            ->whereIn('id', explode(',', $flashdeals[0]))
            ->whereHas('translations')
            ->whereHas('categories')
            ->get();
        $data['products'] = Product::active()->whereIn('id', $product)->whereHas('translations')->limit(15)->orderByDesc('id')->get();
        $data['offers'] = Offer::whereHas('offer_translations', function ($query) {
            $query->where('position', 2);
        })->get();
        $data['brands'] = Brand::whereHas('BrandTranslations')->limit(10)->get();

        return view('dashboard.user.home', $data);
    }

    public function myaccount(Request $request)
    {
        $data['user'] = User::findorFail(Auth::id());

        return view('dashboard.user.account-details', $data);
    }

    public function delete_account(Request $request)
    {
        User::where('id', Auth::id())->delete();

        return redirect('login');
    }

    public function myorders(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $data['user'] = User::findorFail(Auth::id());
        $data['orders'] = Order::where('user_id', Auth::id())->orderByDesc('id')->get();

        return view('dashboard.user.orders', $data);
    }

    public function order_details(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $data['details'] = Order::where('id', $request->id)->where('user_id', Auth::id())->firstOrFail();

        return view('dashboard.user.order_details', $data);
    }

    public function myaddresses(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $data['user'] = User::find(Auth::id());

        return view('dashboard.user.user_address', $data);
    }

    public function getAllArea(Request $request)
    {
        $data = Area::whereHas('translations')->get();

        return response()->json(['data' => $data]);
    }

    public function getAllCity(Request $request)
    {
        // التحقق من الـ ID
        if (! $request->filled('id')) {
            return response()->json(['data' => '<option value="">'.__('dashboard.Choose').'</option>']);
        }

        // جلب المدن المرتبطة بالمنطقة (area_id = parent_id)
        $cities = City::where('parent_id', $request->id)
            ->whereHas('translations', function ($q) {
                $q->where('lang_id', app()->getLocale());
            })
            ->with(['translations' => function ($q) {
                $q->where('lang_id', app()->getLocale());
            }])
            ->get();

        $selected = $request->get('selected', '');
        $options = '<option value="">'.__('dashboard.Choose').'</option>';

        foreach ($cities as $city) {
            $title = $city->translations->first()?->title ?? '---';
            $selectedAttr = $city->id == $selected ? 'selected' : '';
            $options .= "<option value=\"{$city->id}\" {$selectedAttr}>{$title}</option>";
        }

        return response()->json(['data' => $options]);
    }

    public function getAllZones(Request $request)
    {
        $data = Zone::where('parent_id', $request->id)->whereHas('translations')->get();
        $selected = isset($request->selected) ? $request->selected : '';
        $select = '';
        foreach ($data as $value) {
            $value->id == $selected ? $selectedValue = 'selected' : $selectedValue = '';
            $select .= "<option value='".$value->id."' ".$selectedValue.'>'.$value->translations()->first()->title.'</option>';
        }

        return response()->json(['data' => $select]);
    }

    public function getAddress(Request $request)
    {
        return response()->json([
            'html' => view('dashboard.user.address.create')->render(),
        ]);
    }

    public function editAddress(Request $request)
    {
        $address = UserAddress::find($request->id);

        return response()->json([
            'html' => view('dashboard.user.address.edit', ['address' => $address])->render(),
        ]);
    }

    public static function getCurrentAddress()
    {
        $value = '-';
        $address = optional(optional(Auth::user())->address)->first();
        if ($address) {
            $city = optional(City::find($address->city))->translations()->first()->title;
            $area = optional(Area::find($address->area))->translations()->first()->title;

            return $city.'-'.$area;
        }

        return $value;
    }

    public function getShippingCost(Request $request)
    {
        $id = preg_replace('/[^0-9]/', '', $request->address);
        if ($id == 0) {
            $addresID = UserAddress::create([
                'user_id' => Auth::id(),
                'address' => $request->address_title,
                'name' => $request->name,
                'phone' => $request->phone,
                'city' => $request->user_city,
                'area' => $request->user_area,
            ]);
            $request->merge(['address' => $addresID->id]);
        }

        // / shipping cost.
        $getShippingCost = OrderController::getShippingCost($request);
        if (empty($getShippingCost['userCart']) || $getShippingCost['userCart'] == null) {
            return response()->json(['status' => false, 'msg' => __('website.invalid data')]);
        }

        $shipping_cost = 0;
        if ($getShippingCost != null) {
            if ($getShippingCost['shippingCost'] != null) {
                $shipping_cost = $getShippingCost['shippingCost'];
            } else {
                if ($getShippingCost['costArray']) {
                    $shipping_cost = max($getShippingCost['costArray']);
                }
            }
        }

        $data = CartController::getAllCosts($request);
        array_merge($data, ['shipping_cost' => $shipping_cost]);

        return response()->json($data);

        // return response()->json([
        //     'status' => true,
        //     'shipping_cost' => $shipping_cost,
        // ]);
    }

    public function addAddress(Request $request)
    {
        // dd(json_decode($request->getContent(), true));
        if (! auth()->check()) {
            return response()->json([
                'status' => true,
                'shipping_cost' => '',
                'msg' => __('website.invalid data').'111',
                'html' => '',
            ]);
        }

        $dataCart = json_decode($request->getContent(), true);
        if (Str::length($dataCart['phone']) < 11 || Str::length($dataCart['phone']) > 11) {
            return response()->json([
                'status' => false,
                'shipping_cost' => '',
                'msg' => __('website.invalid phone').'222',
                'html' => '',
            ]);
        }

        $address = UserAddress::where('user_id', Auth::id())
            ->where('city', $dataCart['userCity'])
            ->where('area', $dataCart['userArea'])
            ->where('address', $dataCart['addressTitle'])->exists();
        if ($address == false) {
            $UserAddress = UserAddress::create([
                'user_id' => Auth::id(),
                'city' => $dataCart['userCity'],
                'area' => $dataCart['userArea'],
                'address' => $dataCart['addressTitle'],
                'phone' => $dataCart['phone'],
                'name' => $dataCart['name'],
                'lat' => isset($dataCart['lat']) ?? '',
                'lng' => isset($dataCart['lng']) ?? '',
            ]);
            $request->merge(['address' => $UserAddress->id]);
            // if(url()->previous() != \LaravelLocalization::localizeUrl('user/myaddresses')){
            //     $shipping_cost = 0;
            //     $getShippingCost = OrderController::getShippingCost($request);
            //     if ($getShippingCost != null) {
            //         if ($getShippingCost['shippingCost'] != null) {
            //             $shipping_cost = $getShippingCost['shippingCost'];
            //         }else{
            //             if($getShippingCost['costArray']){
            //                 $shipping_cost = max($getShippingCost['costArray']);
            //             }
            //         }
            //     }
            // }

            $view = view('dashboard.user.address.result_row', [
                'address' => $UserAddress,
                'order' => true,
                'selected' => $UserAddress->id,
            ])->render();

            return response()->json([
                'status' => true,
                'msg' => __('website.added successfully'),
                'html' => $view,
            ]);
        } else {
            return response()->json(['status' => false, 'msg' => __('website.Duplicate Fields'), 'html' => '']);
        }
    }

    public static function getCityOptions($area)
    {
        $cities = City::where('parent_id', $area)->pluck('id');
        $cityTrans = \App\Models\CityTranslation::where('lang_id', app()->getLocale())->whereIn('city_id', $cities)->get();
        $select = '';
        foreach ($cityTrans as $trans) {
            $select .= "<option value='".$trans->city_id."'>".$trans->title.'</option>';
        }

        return $select;
    }

    public function updateAddress(Request $request)
    {
        if (Str::length($request->phone) < 11) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'msg' => __('website.invalid data')]);
            }

            return redirect()->back();
        }

        if (! auth()->check()) {
            return redirect('login');
        }
        $id = preg_replace('/[^0-9]/', '', $request->id);
        $address = UserAddress::where('id', $id)->first();
        if ($address) {
            $address->update([
                'user_id' => Auth::id(),
                'city' => $request->user_city,
                'area' => $request->user_area,
                'address' => $request->address,
                'phone' => $request->phone,
                'name' => $request->name,
                'lat' => $request->lat,
                'lng' => $request->lng,
            ]);

            $request->merge(['address' => $address->id]);
            $shipping_cost = 0;
            $getShippingCost = OrderController::getShippingCost($request);
            if ($getShippingCost != null) {
                if ($getShippingCost['shippingCost'] != null) {
                    $shipping_cost = $getShippingCost['shippingCost'];
                } else {
                    if ($getShippingCost['costArray']) {
                        $shipping_cost = max($getShippingCost['costArray']);
                    }
                }
            }

            if ($request->ajax()) {
                if (\Request::routeIs('user.updateAddress')) {
                    $view = view('dashboard.user.address.preview', ['user' => Auth::user()])->render();
                } else {
                    $view = view('dashboard.user.address.result_row', ['address' => $address])->render();
                }

                return response()->json([
                    'status' => true,
                    'shipping_cost' => $shipping_cost,
                    'msg' => __('website.added successfully'),
                    'html' => $view,
                ]);
            }

            return redirect()->back()->with('msg', __('dashboard.updated'));
        }

        return redirect()->back()->with('msg', __('website.data error'));
    }

    public function deleteAddress(Request $request)
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        UserAddress::where('id', $request->id)->delete();

        // if($request->ajax()){
        return response()->json([
            'status' => true,
            'shipping_cost' => '',
            'msg' => __('website.deleted successfully'),
            'html' => '',
        ]);
        // }
        // return redirect()->back()->with('msg', __('website.deleted successfully'));
    }



    public static function randomCode($phone)
    {
        $random = substr(str_shuffle('0123456789'), 0, 4);
        $theCode = PhoneCheck::where('phone', $phone)
            //  ->where('check_code', $random)
            //  ->where('status', 1)
            ->first();
        if (empty($theCode)) {
            if (is_numeric($phone)) {
                PhoneCheck::create([
                    'phone' => $phone,
                    'check_code' => $random,
                    'status' => 0,
                ]);
            }
        } else {
            if ($theCode->status == 0) {
                PhoneCheck::where('phone', $phone)->update(['check_code' => $random]);
            }
            if ($theCode->status == 1) {
                PhoneCheck::where('phone', $phone)->update(['status' => 0, 'check_code' => $random]);
            }
        }

        return $random;
    }

    public static function sendSms($mobile, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            // CURLOPT_URL => 'https://smsmisr.com/api/SMS/?environment=1&username=dd2a9f07-0571-4b16-ad05-41f7fdcd86e1&password=e8c21c389963c3137643422e920627e342b30035fd5247d276012ddc16190703&language=2&sender=4ee7a4e469f5ab7ae44ade51184091f5a7cff4f260d3a3d0e5439838667621f0&mobile='.$mobile.'&message='. htmlentities(urlencode($message)).'&DelayUntil=X',
            // CURLOPT_URL => 'https://smsmisr.com/api/SMS/?environment=1&username=dd2a9f07-0571-4b16-ad05-41f7fdcd86e1&password=e8c21c389963c3137643422e920627e342b30035fd5247d276012ddc16190703&language=2&sender=4ee7a4e469f5ab7ae44ade51184091f5a7cff4f260d3a3d0e5439838667621f0&mobile=01110181371&message=%D8%B1%D9%85%D8%B2%20%D8%A7%D9%84%D8%AA%D8%AD%D9%82%D9%82%20%D9%84%D9%84%D8%AA%D8%B3%D8%AC%D9%8A%D9%84%20%D9%81%D9%8A%20%D9%85%D8%AF%D8%B2%D9%88%D9%86%20%D9%87%D9%88%20%3A%200200&DelayUntil=X',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => ['Content-Length: 0'],
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        LogApi::create([
            'url' => 'smsmisr',
            'body' => json_encode($response),
            'fire_base_result' => '',
            'userFireBaseTokens' => '',
        ]);
    }

    public function setMainAddress(Request $request, $id)
    {
        $address = \App\Models\UserAddress::where('user_id', \auth()->id())->findOrFail($id);
        
        // Reset all addresses to not main
        \App\Models\UserAddress::where('user_id', \auth()->id())->update(['is_main' => false]);
        
        // Set this one as main
        $address->update(['is_main' => true]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => __('website.Address set as main successfully')]);
        }

        return back()->with('success', __('website.Address set as main successfully'));
    }

    public function getCities($country_id)
    {
        $cities = \App\Models\City::active()->where('country_id', $country_id)->with('translations')->get();
        return response()->json($cities->map(function($city) {
            return [
                'id' => $city->id,
                'name' => $city->translation->name ?? $city->translations->first()->name ?? ''
            ];
        }));
    }

    public function getAreas($city_id)
    {
        $areas = \App\Models\Area::where('city_id', $city_id)->with('translations')->get();
        return response()->json($areas->map(function($area) {
            return [
                'id' => $area->id,
                'name' => $area->translation->name ?? $area->translations->first()->name ?? ''
            ];
        }));
    }
}
