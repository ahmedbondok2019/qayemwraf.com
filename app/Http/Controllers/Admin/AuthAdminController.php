<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthAdminController extends Controller
{
    public function login()
    {
        return view('dashboard.admin.login');
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'exists:admins,email'],
            'password' => ['required', 'string', 'min:8', 'max:30'],
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];

        if (Auth::guard('admin')->attempt($credentials, true)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->with('failed', 'wrong email or password or inactive account');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Session::forget(['permissionData']);

        return redirect()->route('admin.login');
    }
}
