<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\helper\HelperController;
use App\Http\Requests\vendors\CreateVendorRequest;
use App\Http\Requests\vendors\finishVendorRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VendorController extends VendorBackendController
{
    public function home(Request $request)
    {
        $vendorsOrders = OrderDetail::where('vendor_id', Auth::id())->pluck('order_id');
        $data['orders_all'] = Order::whereIn('id', $vendorsOrders)->orderByDesc('id')->count();
        $data['order_returns'] = Order::whereIn('id', $vendorsOrders)->where('status', 5)->orderByDesc('id')->count();
        $data['orders_notcompleted'] = Order::whereIn('id', $vendorsOrders)->where('status', 6)->orderByDesc('id')->count();
        $data['new_orders'] = Order::whereIn('id', $vendorsOrders)->where('status', 0)->count();
        $data['products'] = Product::where('vendor_id', Auth::id())->count();

        if (! Auth::user()->status == 1) {
            Auth::logout();

            alert()->warning(__('dashboard.NotActive'), __('dashboard.attention'));

            return redirect()->route('vendor.login')->withErrors(['Your account is inactive']);
        }

        return view('dashboard.vendor.home', $data);
    }

    public function login(Request $request)
    {
        if (\auth()->check()) {
            return redirect(\LaravelLocalization::localizeUrl('vendor/home'));
        }

        return view('dashboard.vendor.login');
    }

    public function first_step(Request $request)
    {
        if (\auth()->guard('vendor')->check()) {
            return redirect(\LaravelLocalization::localizeUrl('vendor/home'));
        }

        return view('dashboard.vendor.first_step');
    }

    public function finish(finishVendorRequest $request)
    {
        if (\auth()->guard('vendor')->check()) {
            return redirect(\LaravelLocalization::localizeUrl('vendor/home'));
        }

        $data['types'] = $request->only('account_type', 'profit_group');
        if ($request->profit_group == null) {
            return redirect()->route('vendor.register');
        }
        Session::put(['types' => $data['types']]);

        return redirect(\LaravelLocalization::localizeUrl('vendor/create_account'));
    }

    public function create_account(Request $request)
    {
        if (\auth()->guard('vendor')->check()) {
            return redirect(\LaravelLocalization::localizeUrl('vendor/home'));
        }

        $data['types'] = Session::get('types');
        Arr::add($request->all(), 'account_type', $data['types']['account_type']);
        Arr::add($request->all(), 'profit_group', $data['types']['profit_group']);

        return view('dashboard.vendor.register', $data);
    }

    public function forgetPassword(Request $request)
    {
        if (\auth()->check()) {
            return redirect(\LaravelLocalization::localizeUrl('vendor/home'));
        }

        return view('dashboard.vendor.forget_password');
    }

    public function create(CreateVendorRequest $request)
    {
        $data = Session::get('types');
        Arr::add($request->all(), 'account_type', $data['account_type']);
        Arr::add($request->all(), 'profit_group', $data['profit_group']);

        if ($request->has('commerical_license')) {
            $getClientOriginalName1 = explode('.', $request->file('commerical_license')->getClientOriginalName());
            $commerical_license = HelperController::make_slug($getClientOriginalName1[0].Carbon::now()).'.png';

            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'commerical_license');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'commerical_license'.DIRECTORY_SEPARATOR.$commerical_license);
            HelperController::upload_images($path, $destination, Input::file('commerical_license'), null, null, 'png');
        }

        if ($request->has('tax_license')) {
            $getClientOriginalName1 = explode('.', $request->file('tax_license')->getClientOriginalName());
            $tax_license = HelperController::make_slug($getClientOriginalName1[0].Carbon::now()).'.png';

            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'tax_license');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'tax_license'.DIRECTORY_SEPARATOR.$tax_license);
            HelperController::upload_images($path, $destination, Input::file('tax_license'), null, null, 'png');
        }

        if ($request->has('identity_card1')) {
            $getClientOriginalName1 = explode('.', $request->file('identity_card1')->getClientOriginalName());
            $identity_card1 = HelperController::make_slug($getClientOriginalName1[0].Carbon::now()).'.png';

            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'identity_card1');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'identity_card1'.DIRECTORY_SEPARATOR.$identity_card1);
            HelperController::upload_images($path, $destination, Input::file('identity_card1'), null, null, 'png');
        }

        if ($request->has('identity_card2')) {
            $getClientOriginalName1 = explode('.', $request->file('identity_card2')->getClientOriginalName());
            $identity_card2 = HelperController::make_slug($getClientOriginalName1[0].Carbon::now()).'.png';

            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'identity_card2');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'identity_card2'.DIRECTORY_SEPARATOR.$identity_card2);
            HelperController::upload_images($path, $destination, Input::file('identity_card2'), null, null, 'png');
        }

        if ($request->has('address_prove')) {
            $getClientOriginalName1 = explode('.', $request->file('address_prove')->getClientOriginalName());
            $address_prove = HelperController::make_slug($getClientOriginalName1[0].Carbon::now()).'.png';

            $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'address_prove');
            $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'address_prove'.DIRECTORY_SEPARATOR.$address_prove);
            HelperController::upload_images($path, $destination, Input::file('address_prove'), null, null, 'png');
        }

        $vendor = Vendor::create([
            'name' => $request->name,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'area_id' => $request->area_id,
            'city_id' => $request->city_id,
            'website' => $request->website,
            'account_type' => $data['account_type'],
            'profit_group' => $data['profit_group'],
            'bank_name' => $request->bank_name,
            'bank_iban' => $request->bank_iban,
            'commerical_license' => isset($commerical_license) ? $commerical_license : null,
            'tax_license' => isset($tax_license) ? $tax_license : null,
            'identity_card1' => isset($identity_card1) ? $identity_card1 : null,
            'identity_card2' => isset($identity_card2) ? $identity_card2 : null,
            'address_prove' => isset($address_prove) ? $address_prove : null,
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);

        if ($vendor) {
            Auth::guard('vendor')->login($vendor);

            return redirect()->route('vendor.home');
        } else {
            alert()->error(__('dashboard.Duplicate User', __('dashboard.attention')));

            return redirect()->route('vendor.register')->withInput();
        }
    }

    public function check(Request $request)
    {
        $customMessages = [
            'exists' => __('validation.exists'),
            'required' => __('validation.title required'),
            'string' => __('validation.string'),
            'password' => __('validation.password required'),
            'password' => __('validation.password min'),
        ];

        $request->validate([
            'email' => ['required', 'string', 'email', 'exists:vendors,email'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
        ], $customMessages);

        // $credentials = $request->only('email', 'password');
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];

        if (Auth::guard('vendor')->attempt($credentials, true)) {
            return redirect()->route('vendor.home');
        } else {
            return redirect()->back()->with('failed', 'wrong email or password');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();

        return redirect()->route('vendor.login');
    }

    public function getAllArea(Request $request)
    {
        $data = Area::whereHas('translations')->get();

        return response()->json(['data' => $data]);
    }

    public function getAllCity(Request $request)
    {
        $data = City::where('parent_id', $request->id)->whereHas('translations')->get();
        $selected = isset($request->selected) ? $request->selected : '';
        $select = '';
        foreach ($data as $value) {
            $value->id == $selected ? $selectedValue = 'selected' : $selectedValue = '';
            $select .= "<option value='".$value->id."' ".$selectedValue.'>'.$value->translations()->first()->title.'</option>';
        }

        return response()->json(['data' => $select]);
    }

    public function getAccountType(Request $request)
    {
        if ($request->account_type == 1) {
            $view = view('dashboard.vendor.includes.private_fields')->render();
        } else {
            $view = view('dashboard.vendor.includes.company_fields')->render();
        }

        return response()->json(['view' => $view]);
    }

    public function vieweditAdmins(Request $request)
    {
        $data['userdetails'] = Vendor::where('id', $request->id)->firstOrFail();

        return view('dashboard.vendor.users.editusers', $data);
    }

    public function updateProfile(Request $request)
    {
        if (is_numeric($request->id)) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:vendors,name,'.$request->id,
                'email' => 'required|string|email|max:255|unique:vendors,email,'.$request->id,
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = Vendor::findOrFail($request->id);
            if ($data) {
                $data->name = $request->name;
                $data->full_name = $request->full_name;
                $data->phone = $request->phone;
                $data->email = $request->email;
                $data->address = $request->address;
                $data->area_id = $request->area_id;
                $data->city_id = $request->city_id;
                $data->website = $request->website;
                $data->bank_name = $request->bank_name;
                $data->bank_iban = $request->bank_iban;
                if (isset($request->password) && $request->password != '') {
                    $data->password = Hash::make($request->password);
                }
                if (isset($request->permission_group) && $request->permission_group != '') {
                    $data->permission_group = $request->permission_group;
                }
                $data->save();

                alert()->success(__('dashboard.updated'), __('dashboard.congratulation'));

                return redirect('/vendor/profile/'.$request->id);
            } else {
                alert()->error(__('dashboard.account not found', __('dashboard.attention')));

                return redirect()->back();
            }
        } else {
            alert()->error(__('dashboard.User Id Wrong', __('dashboard.attention')));

            return redirect()->back();
        }
    }

    public function downloadContract()
    {
        $setting = Setting::first();
        // if (!in_array('11', Session::get("permissionData"))){
        //     return redirect()->back();
        // }

        if ($setting->contract != null) {
            $file = public_path().'/website/uploads/contract/'.$setting->contract;
            $headers = [
                'Content-Type: application/pdf',
            ];

            return FacadesResponse::download($file, 'contract_'.$setting->contract, $headers);
        }

        return redirect()->back();
    }
}
