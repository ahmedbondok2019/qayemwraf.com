<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function __construct(Request $request)
    {
        $ip = $request->ip();
        if ($request->header('lang') != null) {
            App::setLocale($request->header('lang'));
        }
        Visitor::create([
            'visitor_ip' => $ip,
            'visitor_url' => $request->url(),
            'user_id' => auth()->check() ? Auth::id() : '',
            'lang_id' => app()->getLocale(),
        ]);
    }
}
