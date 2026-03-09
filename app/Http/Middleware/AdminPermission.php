<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Str::startsWith($request->url(), 'https://www.souqelmlabes.com')) {
            return redirect()->to(str_replace('www.', '', $request->url()), 301);
        }

        if (empty(Session::get('permissionNames'))) {
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
                if ($user->group) {
                    $permissionNames = $user->group->permissions()->pluck('name')->toArray();
                } else {
                    $permissionNames = [];
                }
            } else {
                $permissionNames = [];
            }
            Session::put(['permissionNames' => $permissionNames]);
        }

        return $next($request);
    }
}
