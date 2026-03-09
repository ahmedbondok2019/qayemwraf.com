<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->header('lang') ?? $request->query('lang') ?? $request->header('language', 'ar');
        
        if (empty($language)) {
            $language = 'ar';
        }
        
        App::setLocale($language);
        $request->attributes->set('language', $language);
        return $next($request);
    }
}
