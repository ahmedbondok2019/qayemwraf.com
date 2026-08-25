<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToLanding
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // If request is on the admin subdomain (e.g. admin.qayemwraf.com)
        if (str_contains($host, 'admin.')) {
            $allowedPatterns = [
                'admin-2026*',
                '*/admin-2026*',
                'admin*',
                '*/admin*',
                'api*',
                '*/api*',
                'docs*',
                '*/docs*',
                'scribe*',
                '*/scribe*',
                '_ignition*',
                'telescope*',
                'sanctum/*',
            ];

            foreach ($allowedPatterns as $pattern) {
                if ($request->is($pattern)) {
                    return $next($request);
                }
            }

            // For any non-admin/api/docs request on admin subdomain, redirect to frontend (qayemwraf.com)
            $frontendUrl = config('app.frontend_url', 'https://qayemwraf.com');
            $requestUri = $request->getRequestUri();

            // Clean up /public from request URI if present
            $requestUri = preg_replace('/^\/public(\/|$)/', '/', $requestUri);

            $targetUrl = rtrim($frontendUrl, '/') . $requestUri;

            return redirect()->away($targetUrl);
        }

        return $next($request);
    }
}
