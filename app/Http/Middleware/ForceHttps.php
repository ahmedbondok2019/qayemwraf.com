<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request and enforce HTTPS redirection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Enforce HTTPS if connection is insecure and app.url uses https or environment is production
        if (! $request->isSecure() && (app()->isProduction() || str_starts_with(config('app.url', ''), 'https://'))) {
            // For API state-changing methods (POST, PUT, DELETE, PATCH), use 308 to preserve HTTP method and payload
            $statusCode = in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH']) ? 308 : 301;

            return redirect()->secure($request->getRequestUri(), $statusCode);
        }

        return $next($request);
    }
}
