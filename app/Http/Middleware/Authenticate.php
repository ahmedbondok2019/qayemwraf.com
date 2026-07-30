<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            return null;
        }

        if ($request->routeIs(LaravelLocalization::transRoute('admin.*'))) {
            return route('admin.login');
        }
        if ($request->routeIs(LaravelLocalization::transRoute('vendor.*'))) {
            return route('vendor.login');
        }
        if ($request->routeIs(LaravelLocalization::transRoute('user.*'))) {
            return route('login');
        }
        
        return route('login');
    }
}
