<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\City;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $countries = Country::active()->with('translations')->get();
        return view('frontend.profile.index', compact('user', 'countries'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_id' => $request->country_id,
        ]);

        return redirect()->back()->with('success', trans_db('frontend.Profile updated successfully'));
    }

    public function addresses()
    {
        $user = Auth::user();
        if (!$user->country_id) {
            return redirect()->route('user.home')->with('error', trans_db('frontend.Please select your country first'));
        }
        $addresses = UserAddress::where('user_id', $user->id)->with(['city_rel', 'governorate_rel'])->get();
        $governorates = Governorate::active()->where('country_id', $user->country_id)->with('translations')->get();
        return view('frontend.profile.addresses', compact('user', 'addresses', 'governorates'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'is_main' => 'nullable',
        ]);

        if ($request->is_main) {
            UserAddress::where('user_id', Auth::id())->update(['is_main' => false]);
        }

        UserAddress::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'country_id' => Auth::user()->country_id,
            'governorate_id' => $request->governorate_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'is_main' => $request->is_main ? true : false,
        ]);

        return redirect()->back()->with('success', trans_db('frontend.Address added successfully'));
    }

    public function updateAddress(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'governorate_id' => 'required|exists:governorates,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'is_main' => 'nullable',
        ]);

        if ($request->is_main) {
            UserAddress::where('user_id', Auth::id())->update(['is_main' => false]);
        }

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'governorate_id' => $request->governorate_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'is_main' => $request->is_main ? true : false,
        ]);

        return redirect()->back()->with('success', trans_db('frontend.Address updated successfully'));
    }

    public function deleteAddress($id)
    {
        UserAddress::where('user_id', Auth::id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', trans_db('frontend.Address deleted successfully'));
    }

    public function setMainAddress($id)
    {
        UserAddress::where('user_id', Auth::id())->update(['is_main' => false]);
        UserAddress::where('user_id', Auth::id())->findOrFail($id)->update(['is_main' => true]);
        return redirect()->back()->with('success', trans_db('frontend.Main address set successfully'));
    }

    public function getCities($governorate_id)
    {
        // Fetch cities based on governorate (which corresponds to 'governorate_id' in City model)
        // Adjusting logic to match correct column name
        $cities = City::where('governorate_id', $governorate_id)
            ->whereHas('translations', function ($q) {
                $q->where('locale', app()->getLocale());
            })
            ->with(['translations' => function ($q) {
                $q->where('locale', app()->getLocale());
            }])
            ->get();

        $data = [];
        foreach ($cities as $city) {
            $data[] = [
                'id' => $city->id,
                'name' => $city->translations->first()->name ?? '---',
            ];
        }

        return response()->json($data);
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        
        // Mark as read when viewing
        $user->unreadNotifications->markAsRead();

        return view('frontend.profile.notifications', compact('user', 'notifications'));
    }
    public function orders(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $query = \App\Models\Order::where('user_id', $user->id);

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Type (Gift vs Regular)
        if ($request->filled('type') && $request->type !== 'all') {
            if ($request->type === 'gift') {
                $query->where('payment_method', 'gift');
            } else {
                $query->where(function($q) {
                    $q->whereNull('payment_method')
                      ->orWhere('payment_method', '!=', 'gift');
                });
            }
        }

        $orders = $query->latest()->paginate(6);

        if ($request->ajax()) {
            return view('frontend.profile.partials.order_items', compact('orders'))->render();
        }

        return view('frontend.profile.orders', compact('user', 'orders'));
    }

    public function show_order($id)
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)
            ->with(['order_details.product.translations', 'city', 'governorate', 'order_statuses'])
            ->findOrFail($id);
            
        return view('frontend.profile.order_show', compact('user', 'order'));
    }
}
