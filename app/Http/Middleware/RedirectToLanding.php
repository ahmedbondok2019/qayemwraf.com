<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToLanding
{
    public function handle(Request $request, Closure $next)
    {
        // // قائمة بالمسارات المسموح بها (يمكن توسيعها)
        // $allowedPaths = [
        //     'landing',
        //     'cache-clear',
        //     'convert',
        //     'TextToSpeech',
        //     'service-account-file.json',
        //     'sitemap.xml',
        //     'sitemap/*',
        //     'create_sitemap',
        //     'api/*',
        //     'admin-2023*', // هذا يشمل admin-2023/login
        //     'admin-2023/*',
        //     'ar/admin-2023*',
        //     'en/admin-2023*',
        //     '_ignition/*',
        //     'telescope/*',
        //     'ar/getAllArea',
        //     'ar/getAllCity',
        //     'ar/getAllZones',
        //     'guest-order-direct',
        //     'get-shipping-cost',
        //     'health',
        // ];

        // foreach ($allowedPaths as $path) {
        //     if ($request->is($path)) {
        //         return $next($request);
        //     }
        // }

        // if ($request->is('livewire/*') || $request->is('*/livewire/*')) {
        //     return $next($request);
        // }
        // return redirect()->route('landing');
        return $next($request);
    }
}
