<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Group::latest()->paginate(10);
        return view('dashboard.admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where('status', 1)->get()->groupBy('group_permission');
        return view('dashboard.admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'permissions' => 'required|array',
        ]);

        $role = Group::create([
            'name' => $request->name,
        ]);

        $role->permissions()->attach($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', trans_db('dashboard.Role created successfully.'));
    }

    public function edit(Group $role)
    {
        $permissions = Permission::where('status', 1)->get()->groupBy('group_permission');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('dashboard.admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Group $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $role->id,
            'permissions' => 'required|array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', trans_db('dashboard.Role updated successfully.'));
    }

    public function destroy(Group $role)
    {
        if ($role->id == 1) {
            return redirect()->back()->with('error', trans_db('dashboard.Cannot delete Super Admin role.'));
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', trans_db('dashboard.Role deleted successfully.'));
    }
}
