<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::with('group')->latest()->paginate(10);
        return view('dashboard.admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Group::all();
        return view('dashboard.admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'permission_group' => 'required|exists:groups,id',
            'status' => 'required|in:0,1',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'permission_group' => $request->permission_group,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.admins.index')->with('success', trans_db('dashboard.Admin created successfully.'));
    }

    public function edit(Admin $admin)
    {
        $roles = Group::all();
        return view('dashboard.admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'permission_group' => 'required|exists:groups,id',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'permission_group' => $request->permission_group,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', trans_db('dashboard.Admin updated successfully.'));
    }

    public function destroy(Admin $admin)
    {
        if ($admin->name == 'admin' || $admin->id == auth('admin')->id()) {
            return redirect()->back()->with('error', trans_db('dashboard.Cannot delete this admin.'));
        }
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', trans_db('dashboard.Admin deleted successfully.'));
    }
}
