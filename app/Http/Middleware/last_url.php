<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class last_url
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $notAccepted = [
            \LaravelLocalization::localizeUrl('user/login/facebook/callback#_=_'),
            \LaravelLocalization::localizeUrl('user/login/google/callback#_=_'),
            \LaravelLocalization::localizeUrl('user/login/facebook#_=_'),
            \LaravelLocalization::localizeUrl('user/login/facebook/callback'),
            \LaravelLocalization::localizeUrl('user/login/google/callback'),
            \LaravelLocalization::localizeUrl('user/login/facebook'),
            \LaravelLocalization::localizeUrl('user/login/google'),
            \LaravelLocalization::localizeUrl('user/login/*'),
            \LaravelLocalization::localizeUrl('user/register/*'),
            \LaravelLocalization::localizeUrl('user/login'),
            \LaravelLocalization::localizeUrl('user/register'),
            \LaravelLocalization::localizeUrl('admin-2023/*'),
            \LaravelLocalization::localizeUrl('vendor/*'),
        ];

        if (! in_array(Request::url(), $notAccepted)) {
            if ($request->method() != 'POST') {
                Session::put(['CurrentUrl' => Request::url()]);
                if (Session::get('CurrentUrl') == null) {
                    Session::put(['CurrentUrl' => Request::url()]);
                }
            }
        }

        //  dd(Request::root());
        //  dd(Session::get('CurrentUrl'));
        return $next($request);
    }
}
