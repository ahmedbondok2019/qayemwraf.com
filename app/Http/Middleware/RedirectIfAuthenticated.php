<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect()->route('admin.home');
                }

                if ($guard === 'vendor') {
                    return redirect()->route('vendor.home');
                }
                if ($guard === 'web' || $guard === null) {
                    return redirect()->route('frontend.index');
                }
                if ($guard === 'user') {
                    return redirect()->route('frontend.index');
                }
            }
        }

        return $next($request);
    }
}
