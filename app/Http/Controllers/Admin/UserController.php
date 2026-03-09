<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\City;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Traits\UploadImageTrait;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use UploadImageTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('users.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" class="rounded-circle" width="40" height="40" alt="' . $row->name . '">';
                    } else {
                        return '<div class="avatar bg-light-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <span class="avatar-content">' . substr($row->name, 0, 1) . '</span>
                                </div>';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge badge-pill badge-light-success">' . trans_db('dashboard.Active') . '</span>';
                    } else {
                        return '<span class="badge badge-pill badge-light-danger">' . trans_db('dashboard.Inactive') . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="' . route('admin.users.cart', $row->id) . '">
                                        <i data-feather="shopping-cart" class="mr-50"></i>
                                        <span>' . trans_db('dashboard.Show Cart') . '</span>
                                    </a>
                                    <a class="dropdown-item" href="' . route('admin.users.wishlist', $row->id) . '">
                                        <i data-feather="heart" class="mr-50"></i>
                                        <span>' . trans_db('dashboard.Show Wishlist') . '</span>
                                    </a>
                                    <a class="dropdown-item" href="' . route('admin.users.edit', $row->id) . '">
                                        <i data-feather="edit-2" class="mr-50"></i>
                                        <span>' . trans_db('dashboard.Edit') . '</span>
                                    </a>
                                    <button type="button" class="dropdown-item w-100 btn-delete" data-id="' . $row->id . '">
                                        <i data-feather="trash" class="mr-50"></i>
                                        <span>' . trans_db('dashboard.Delete') . '</span>
                                    </button>
                                </div>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.users.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('dashboard.admin.users.create', compact('countries'));
    }

    public function getGovernorates($country_id)
    {
        $governorates = Governorate::where('country_id', $country_id)->active()->get()->map(function($gov) {
            return [
                'id' => $gov->id,
                'name' => $gov->name
            ];
        });
        return response()->json($governorates);
    }

    public function getCities($governorate_id)
    {
        $cities = City::where('governorate_id', $governorate_id)->active()->get()->map(function($city) {
            return [
                'id' => $city->id,
                'name' => $city->name
            ];
        });
        return response()->json($cities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable',
            'addresses' => 'nullable|array',
            'addresses.*.country_id' => 'nullable|exists:countries,id',
            'addresses.*.governorate_id' => 'nullable|exists:governorates,id',
            'addresses.*.city_id' => 'nullable|exists:cities,id',
            'addresses.*.address' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['password', 'password_confirmation', 'image', 'status', 'addresses']);
            $data['password'] = Hash::make($request->password);
            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $filename = $this->uploadImage($request->file('image'), 'users');
                $data['image'] = 'uploads/users/' . $filename;
            }

            $user = User::create($data);

            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    if (empty($addressData['country_id']) && empty($addressData['address'])) continue;
                    
                    UserAddress::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'country_id' => $addressData['country_id'] ?? null,
                        'governorate_id' => $addressData['governorate_id'] ?? null,
                        'city_id' => $addressData['city_id'] ?? null,
                        'address' => $addressData['address'] ?? null,
                        'is_main' => isset($addressData['is_main']) ? 1 : 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', trans_db('dashboard.created'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(User $user)
    {
        $countries = Country::all();
        $user->load(['address.governorate_rel', 'address.city_rel']);
        $addresses = $user->address;
        
        // Fetch all necessary governorates and cities for the existing addresses to avoid N+1 in view or JS delays
        $existingGovernorates = [];
        $existingCities = [];

        foreach ($addresses as $address) {
            if ($address->country_id) {
                $existingGovernorates[$address->country_id] = Governorate::where('country_id', $address->country_id)->active()->get();
            }
            if ($address->governorate_id) {
                $existingCities[$address->governorate_id] = City::where('governorate_id', $address->governorate_id)->active()->get();
            }
        }

        return view('dashboard.admin.users.edit', compact('user', 'countries', 'addresses', 'existingGovernorates', 'existingCities'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable',
            'addresses' => 'nullable|array',
            'addresses.*.country_id' => 'nullable|exists:countries,id',
            'addresses.*.governorate_id' => 'nullable|exists:governorates,id',
            'addresses.*.city_id' => 'nullable|exists:cities,id',
            'addresses.*.address' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['password', 'password_confirmation', 'image', 'status', 'addresses']);
            
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $filename = $this->uploadImage($request->file('image'), 'users');
                $data['image'] = 'uploads/users/' . $filename;
            }

            $user->update($data);

            // Sync addresses: delete old and create new
            $user->address()->delete();

            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    if (empty($addressData['country_id']) && empty($addressData['address'])) continue;

                    UserAddress::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'country_id' => $addressData['country_id'] ?? null,
                        'governorate_id' => $addressData['governorate_id'] ?? null,
                        'city_id' => $addressData['city_id'] ?? null,
                        'address' => $addressData['address'] ?? null,
                        'is_main' => isset($addressData['is_main']) ? 1 : 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', trans_db('dashboard.updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }
        $user->delete();
        return response()->json(['success' => trans_db('dashboard.deleted')]);
    }

    public function cart(User $user)
    {
        $carts = Cart::where('user_id', $user->id)->with(['product.translation', 'options.attribute.translation'])->get();
        return view('dashboard.admin.users.cart', compact('user', 'carts'));
    }

    public function wishlist(User $user)
    {
        $wishlists = Wishlist::where('user_id', $user->id)->with(['product.translation'])->get();
        return view('dashboard.admin.users.wishlist', compact('user', 'wishlists'));
    }
}
