<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Group;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends BackendController
{

    public function home(Request $request)
    {

        
        // Existing Dashboard Data (keeping commented out as per original file, just in case)
        // ... (previous commented code) ...

        // Sales Statistics
        $deliveredStatuses = ['delivered', 3, 'completed'];
        
        $todaySales = Order::whereIn('status', $deliveredStatuses)
                           ->whereDate('created_at', now()->today())
                           ->sum('total');

        $thisMonthSales = Order::whereIn('status', $deliveredStatuses)
                               ->whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->sum('total');
                               
        $lastMonthSales = Order::whereIn('status', $deliveredStatuses)
                               ->whereMonth('created_at', now()->subMonth()->month)
                               ->whereYear('created_at', now()->subMonth()->year)
                               ->sum('total');

        $difference = $thisMonthSales - $lastMonthSales;
        $growth = 0;
        $growthDirection = 'neutral'; // 'up', 'down', 'neutral'

        if ($lastMonthSales > 0) {
            $growth = ($difference / $lastMonthSales) * 100;
        } elseif ($thisMonthSales > 0) {
            $growth = 100; // If last month was 0 and this month > 0, it's 100% growth (effectively infinite)
        }

        if ($growth > 0) {
            $growthDirection = 'up';
        } elseif ($growth < 0) {
            $growthDirection = 'down';
        }
        
        $growth = abs($growth); // Use absolute value for display, direction handles sign

        // Orders Statistics
        $todayOrdersCount = Order::whereDate('created_at', now()->today())->count();
        $totalOrdersCount = Order::count();

        // Profit Statistics (Net Sales since Cost is not tracked)
        $totalProfit = Order::whereIn('status', $deliveredStatuses)->sum('total');

        // Customer Statistics
        $totalCustomers = User::count();
        $newCustomersThisMonth = User::whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)
                                     ->count();

        // Product Statistics
        $totalProducts = Product::count();
        $availableProducts = Product::where('quantity', '>', 0)->count();
        $outOfStockProducts = Product::where('quantity', '<=', 0)->count();

        // Top Selling Products
        $topSellingProducts = \App\Models\OrderDetail::whereHas('order', function($q) use ($deliveredStatuses) {
                $q->whereIn('status', $deliveredStatuses);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with(['product' => function($q) {
                $q->with('translation');
            }])
            ->get();

        // Least Selling Products (Bottom 5)
        $leastSellingProducts = \App\Models\OrderDetail::whereHas('order', function($q) use ($deliveredStatuses) {
                $q->whereIn('status', $deliveredStatuses);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'asc')
            ->take(5)
            ->with(['product' => function($q) {
                $q->with('translation');
            }])
            ->get();

        // Top Selling Categories
        $topSellingCategories = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('product_categories', 'order_details.product_id', '=', 'product_categories.product_id')
            ->join('category_translations', 'product_categories.category_id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', app()->getLocale())
            ->whereIn('orders.status', $deliveredStatuses)
            ->select('category_translations.title as name', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->groupBy('product_categories.category_id', 'category_translations.title')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Order Status Counts
        $ordersProcessing = Order::whereIn('status', ['processing', 1])->count();
        $ordersShipped = Order::whereIn('status', ['shipped', 2])->count(); // 2 = OnTheWay
        $ordersDelivered = Order::whereIn('status', ['delivered', 3, 'completed'])->count(); // 3 = Receive
        $ordersCancelled = Order::whereIn('status', ['cancelled', 4])->count();

        // Recent Orders
        $latestOrders = Order::with('user')->latest()->take(10)->get();

        // Chart Data: Last 30 Days Sales & Orders
        $dates = collect();
        foreach (range(-29, 0) as $i) {
            $date = \Carbon\Carbon::now()->addDays($i)->format('Y-m-d');
            $dates->put($date, 0);
        }

        $salesRaw = Order::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))
            ->whereIn('status', $deliveredStatuses)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->pluck('revenue', 'date');
        
        $ordersRaw = Order::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartDates = $dates->keys()->toArray();
        $chartSales = $dates->merge($salesRaw)->values()->toArray();
        $chartOrders = $dates->merge($ordersRaw)->values()->toArray();

        // category Pie Chart Data
        $pieLabels = $topSellingCategories->pluck('name')->toArray();
        $pieSeries = $topSellingCategories->pluck('total_sold')->toArray();

        return view('dashboard.admin.home', compact('todaySales', 'thisMonthSales', 'lastMonthSales', 'growth', 'growthDirection', 'todayOrdersCount', 'totalOrdersCount', 'totalProfit', 'totalCustomers', 'newCustomersThisMonth', 'totalProducts', 'availableProducts', 'outOfStockProducts', 'topSellingProducts', 'leastSellingProducts', 'topSellingCategories', 'ordersProcessing', 'ordersShipped', 'ordersDelivered', 'ordersCancelled', 'latestOrders', 'chartDates', 'chartSales', 'chartOrders', 'pieLabels', 'pieSeries'));
    }


    public function MarkAsRead()
    {
        $user = Admin::find(auth('admin')->id());

        // $user->unreadNotifications()->update(['read_at' => now()]);
        $user->unreadNotifications->markAsRead();

        return response()->json(['msg' => 'done']);
    }

    public function adminJson()
    {
        $CurrentUsers = Admin::all();

        return response()->json(['data' => $CurrentUsers]);
    }

    public function employees()
    {
        if (! in_array('11', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['CurrentUsers'] = Admin::paginate(25);
        $data['title'] = trans_db('dashboard.users');
        $data['table'] = 'Admin';
        $data['route'] = 'edit_admins';
        $data['UserType'] = 'admin';
        $data['routeForm'] = 'Admins';
        $data['DeleteRoute'] = 'admin';

        return view('dashboard.admin.users.employees', $data);
    }

    public function index()
    {
        if (! in_array('5', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['CurrentUsers'] = Admin::all();
        $data['title'] = trans_db('dashboard.users');
        $data['table'] = 'Admin';
        $data['route'] = 'edit_admins';
        $data['UserType'] = 'admin';
        $data['routeForm'] = 'Admins';
        $data['DeleteRoute'] = 'admin';

        return view('dashboard.admin.users.admins', $data);
    }

    public function customer()
    {
        $data['CurrentUsers'] = User::orderbyDesc('id')->get();
        $data['title'] = trans_db('dashboard.Customers');
        $data['table'] = 'users';
        $data['route'] = 'edit_users';
        $data['UserType'] = 'user';
        $data['routeForm'] = 'Users';
        $data['DeleteRoute'] = 'user';

        return view('dashboard.admin.users.users', $data);
    }

    public function vendor()
    {
        if (! in_array('21', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['CurrentUsers'] = Vendor::orderbyDesc('id')->get();
        $data['title'] = trans_db('dashboard.Vendors');
        $data['table'] = 'vendors';
        $data['route'] = 'edit_vendors';
        $data['UserType'] = 'vendor';
        $data['routeForm'] = 'Vendors';
        $data['DeleteRoute'] = 'vendor';

        // $route = 'edit_admins'; $UserType = 'admin'; else{ $route = 'edit_users'; $UserType = 'user'; }
        // $routeForm = 'Admins'; $DeleteRoute = 'admin'; else{ $routeForm = 'Users'; $DeleteRoute = 'user'; }

        return view('dashboard.admin.users.vendors', $data);
    }

    public function permission()
    {
        if (! in_array('1', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $PermissionGroups = Group::all();

        return view('dashboard.admin.users.userspermission', compact('PermissionGroups'));
    }

    public function viewpermission(Request $request)
    {
        if (! in_array('3', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $PermissionGroupsDetails = Group::where('id', $request->id)->with('permissions')->firstOrFail();

        return view('dashboard.admin.users.userspermissiondetails', compact('PermissionGroupsDetails'));
    }

    public function addpermission(Request $request)
    {
        if (! in_array('2', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.users.createuserspermission');
    }

    public function StorePermission(Request $request)
    {
        if (! in_array('2', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:groups',
        ]);

        if ($validator->fails()) {
            return redirect('/admin-2023/users/permission/add')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->name != 'admin') {
            $data = Group::create(['name' => $request->name]);
            if ($data) {
                $data->permissions()->attach($request->permission_role);
            }
            alert()->success('Permission Role Added Successfully', trans_db('dashboard.congratulation'));
        } else {
            alert()->error('Permission Role failed to add', trans_db('dashboard.'));
        }

        return redirect('/admin-2023/users/permission');
    }

    public function UpdatePermission(Request $request)
    {
        if (! in_array('2', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:groups,name,'.$request->id,
        ]);

        if ($validator->fails()) {
            return redirect('/admin-2023/users/permission/'.$request->id)
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->name != 'admin') {
            $data = Group::where('id', $request->id)->firstOrFail();
            $data->update(['name' => $request->name]);
            $data->permissions()->sync($request->permission_role);
            alert()->success('Permission Role Updated Successfully', trans_db('dashboard.congratulation'));
        } else {
            alert()->error('Permission Role Update Failed', trans_db('dashboard.attention'));
        }

        return redirect('/admin-2023/users/permission');
    }

    public function deletepermission(Request $request)
    {
        if (! in_array('4', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $deleted = false;
        if (Group::count() > 1) {
            $GroupPermission = \App\Models\GroupPermission::pluck('permission_id')->toArray();
            if (in_array('1', $GroupPermission)) {
                $deleted = true;
                $data = Group::where('id', $request->id)->delete();
                //  $data->permissions() ->detach($request->permission_role);
                alert()->success('تم حذف المجموعة بنجاح', trans_db('dashboard.congratulation'));
            }
        }

        if ($deleted == false) {
            alert()->success('يجب ان تكون مجموعة على الاقل تحتوى على الحسابات والصلاحيات', trans_db('dashboard.congratulation'));
        }

        return redirect()->back();
    }

    public function viewadd()
    {
        if (! in_array('6', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('dashboard.admin.users.addusers');
    }

    public function viewedit(Request $request)
    {
        if (! in_array('7', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['userdetails'] = User::where('id', $request->id)->firstOrFail();
        $data['type'] = 'client';

        return view('dashboard.admin.users.editusers', $data);
    }

    public function vieweditAdmins(Request $request)
    {
        if (! in_array('7', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['type'] = 'admin';
        $data['userdetails'] = Admin::where('id', $request->id)->firstOrFail();

        return view('dashboard.admin.users.editusers', $data);
    }

    public function createUser(Request $request)
    {
        if (! in_array('6', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string',
            'admin' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin-2023/users/admin')
                ->withErrors($validator)
                ->withInput();
        }

        $test = Admin::where('name', $request->name)->where('email', $request->email)->first();
        if (empty($test)) {
            $data = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'permission_group' => $request->admin,
                'send_code' => Str::random(80),
                'admin_type' => 1,
                'status' => 1,
            ]);

            alert()->success('User Added Successfully', 'Congratulations');

            return redirect('admin-2023/users/admin');
        } else {
            alert()->error('User Exists Already', 'Wrong');

            return redirect('admin-2023/users/admin');
        }
    }

    public function updateUser(Request $request)
    {
        if (! in_array('7', Session::get('permissionData'))) {
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

    public function updateAdmin(Request $request)
    {
        if (! in_array('7', Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (is_numeric($request->id)) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:admins,name,'.$request->id,
                'email' => 'required|string|email|max:255|unique:admins,email,'.$request->id,
                'password' => 'nullable|string|min:8',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //            if ($request->name == 'admin' && Auth::user()->name != $request->name) {
            //                alert()->error('Not Allowed To Edit Admin' ,'Wrong');
            // //                return redirect('/admin-2023/users/editusers/'.$request->id)->withInput();
            //                return redirect()->back()->withInput();
            //            }
            $data = Admin::findOrFail($request->id);
            if ($data) {
                $data->name = $request->name;
                $data->email = $request->email;
                $data->status = $request->status;
                if (isset($request->password) && $request->password != '') {
                    $data->password = Hash::make($request->password);
                }
                if (isset($request->permission_group) && $request->permission_group != '') {
                    $data->permission_group = $request->permission_group;
                }
                $data->save();

                alert()->success(trans_db('dashboard.updated'), trans_db('dashboard.congratulation'));

                return redirect('/admin-2023/users/all');
            } else {
                alert()->error(trans_db('dashboard.account not found', trans_db('dashboard.attention')));

                //   return redirect('/admin-2023/users/editusers/'.$request->id);
                return redirect()->back();
            }
        } else {
            alert()->error(trans_db('dashboard.User Id Wrong', trans_db('dashboard.attention')));

            return redirect()->back();
        }
    }

    public function deleteUser(Request $request)
    {
        if (! in_array('8', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = User::where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/users/customer');
    }

    public function deleteAdmin(Request $request)
    {
        if (! in_array('8', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = Admin::where('id', '=', $request->id)->first();
        if ($data->name == 'admin') {
            alert()->success(trans_db('dashboard.Admin Can not Be Deleted'), trans_db('dashboard.congratulation'));

            return redirect('admin-2023/users/admin');
            //            ->with('msg', 'Admin Can not Be Deleted');
        }
        $data->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect('admin-2023/users/admin');
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

    public function deleteMultiAdmins(Request $request)
    {
        if (empty($request->select)) {
            alert()->warning(trans_db('dashboard.NothingSelected', trans_db('dashboard.attention')));

            return redirect()->route('users.admin');
        }
        foreach ($request->select as $key => $needToDelete) {
            $user = Admin::where('id', $needToDelete)->first();
            if (isset($user)) {
                $user->delete();
            }
        }
        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.congratulation'));

        return redirect()->route('users.admin');
    }

    public function change_status(Request $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'status' => $request->user_status,
        ]);

        return response()->json(['data' => 'success']);

    }

    public function profile()
    {
        $admin = Admin::find(auth('admin')->id());
        return view('dashboard.admin.profile', compact('admin'));
    }

    public function update_profile(Request $request)
    {
        $admin = Admin::find(auth('admin')->id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->back()->with('success', trans_db('dashboard.Profile updated successfully.'));
    }
}
