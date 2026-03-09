<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Currency;
use App\Models\Order;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomersController extends BackendController
{
    public function index()
    {
        if (! in_array('13', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['CurrentUsers'] = User::orderbyDesc('id')->get();
        $data['title'] = trans_db('dashboard.Customers');
        $data['table'] = 'users';
        $data['route'] = 'edit_users';
        $data['UserType'] = 'user';
        $data['routeForm'] = 'Users';
        $data['DeleteRoute'] = 'user';

        return view('dashboard.admin.customers.index', $data);
    }

    public function viewedit(Request $request)
    {
        if (! in_array('15', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $userdetails = User::where('id', $request->id)->firstOrFail();

        return view('dashboard.admin.users.editusers', compact('userdetails'));
    }

    public function profile(Request $request)
    {
        if (! in_array('15', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['Details'] = User::find($request->id);
        if ($data['Details'] == null) {
            return redirect('/admin-2023/customers/all');
        }
        $data['id'] = $request->id;
        $data['favorite'] = Wishlist::where('user_id', $request->id)->get();
        $data['user'] = User::findorFail($request->id);
        $data['orders'] = Order::where('user_id', $request->id)->orderByDesc('id')->get();

        $currency = Currency::where('status', 1)->first();
        $rate = $currency->rate;
        $data['rate'] = $rate;

        $data['cart'] = Cart::where('user_id', $request->id)->with('options')->get();
        $data['sum'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                $optionId = \App\Models\CartOption::where('cart_id', $item['id'])->where('product_id', $item['product_id'])->first();
                $cartOption = $optionId == null ? null : $optionId->option_item_id;
                $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy($item['product_id'], $cartOption);
                if ($ProQty != null) {
                    // return $carry + ($item["price"] + $item["tax"]) * $item["quantity"] * $rate;
                    return $carry + $item['price'] * $item['quantity'] * $rate;
                }
            }, 0);
        $data['prices'] = collect($data['cart'])
            ->reduce(function ($carry, $item) use ($rate) {
                $optionId = \App\Models\CartOption::where('cart_id', $item['id'])->where('product_id', $item['product_id'])->first();
                $cartOption = $optionId == null ? null : $optionId->option_item_id;
                $ProQty = \App\Http\Controllers\helper\HelperController::getProductQuantiy($item['product_id'], $cartOption);
                if ($ProQty != null) {
                    return $carry + ($item['price'] * $item['quantity'] * $rate);
                }
            }, 0);

        return view('dashboard.admin.customers.profile', $data);
    }

    public function updateUser(Request $request)
    {
        if (! in_array('15', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if (is_numeric($request->id)) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:users,name,'.$request->id,
                'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
                'password' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect('/admin-2023/users/editusers/'.$request->id)
                    ->withErrors($validator)
                    ->withInput();
            }

            $data = User::findOrFail($request->id);
            if ($data) {
                $data->name = $request->name;
                $data->email = $request->email;
                if (isset($request->password) && $request->password != '') {
                    $data->password = Hash::make($request->password);
                } else {
                    alert()->error('Password Mismatch', trans_db('dashboard.attention'));

                    return redirect('/admin-2023/users/editusers/'.$request->id);
                }
                if (isset($request->status) && $request->status != '') {
                    $data->status = 0;
                } else {
                    $data->status = 1;
                }
                
                if (isset($request->gift_page_enabled)) {
                     $data->gift_page_enabled = 1;
                } else {
                     $data->gift_page_enabled = 0;
                }

                //      if (isset($request->branch_id) && $request->branch_id != ''){ $data->branch_id = $request->branch_id; }
                $data->save();

                alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

                return redirect('/admin-2023/users/editusers/'.$request->id);
            } else {
                alert()->error(trans_db('dashboard.account not found', trans_db('dashboard.attention')));

                return redirect('/admin-2023/users/editusers/'.$request->id);
            }
        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public function deleteUser(Request $request)
    {
        if (! in_array('16', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = User::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/users/customer');
    }

    public function deleteMultiUsers(Request $request)
    {
        if (empty($request->select)) {
            alert()->warning(trans_db('dashboard.NothingSelected', trans_db('dashboard.attention')));

            return redirect()->route('users.client');
        }
        foreach ($request->select as $key => $needToDelete) {
            $user = User::where('id', $needToDelete)->first();
            if (isset($user)) {
                $user->delete();
            }
        }
        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect()->route('users.client');
    }

    public function change_status(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'status' => $request->user_status,
        ]);

        return response()->json(['data' => 'success']);

    }
}
