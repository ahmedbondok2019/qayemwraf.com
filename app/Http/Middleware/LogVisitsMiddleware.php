<?php

namespace App\Http\Middleware;

use App\Models\Currency;
use App\Models\CurrencyTranslation;
use App\Models\VisitLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class LogVisitsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Using terminate to avoid slowing the response.
     */
    public function terminate($request, $response): void
    {
        try {
            // 1) Get real IP (Cloudflare-aware)
            $ip = $this->getClientIp($request);

            // تجاهل IPات غير مفيدة
            if (! $ip || $ip === '127.0.0.1' || $ip === '::1') {
                $geo = null;
            } else {
                // 2) Cache ip-api result for this IP to reduce calls
                $cacheKey = 'geoip:ipapi:' . $ip;

                $geo = Cache::remember($cacheKey, now()->addHours(12), function () use ($ip) {
                    // ip-api free endpoint is http; if you have pro, use https
                    $url = "http://ip-api.com/json/{$ip}";

                    $res = Http::timeout(2)
                        ->retry(1, 200)
                        ->get($url);

                    if (! $res->successful()) {
                        return null;
                    }

                    $data = $res->json();
                    if (! is_array($data) || ($data['status'] ?? null) !== 'success') {
                        return $data; // store even fail responses
                    }

                    return $data;
                });
            }

             $currency = Currency::where('type', $geo['countryCode'])->first() ?? Currency::first();
             $currency_trans = CurrencyTranslation::where('currency_id', $currency->id)->where('lang_id', app()->getLocale())->first();
             $rate = $currency->rate;

             switch ($geo['countryCode'] ) {
                 case 'EG':
                     $rate = 1;
                     break;
                 case 'SA':
                     $rate = 15;
                     break;
                 case 'AE':
                     $rate = 25;
                     break;
                 default:
                     $rate = 50;
                     break;
             }
             
            View::share([
                'currency' => $currency ?? "",
                'Currency' => $currency_trans ?? "",
                'rate' => $rate ?? "",
            ]);

            // 3) Insert log row
            VisitLog::create([
                'user_id'      => optional($request->user())->id,
                'ip'           => $ip,
                'session_id'   => $request->hasSession() ? $request->session()->getId() : null,

                'method'       => $request->getMethod(),
                'url'          => $request->fullUrl(),
                'referer'      => $request->headers->get('referer'),
                'user_agent'   => $request->userAgent(),

                'status'       => $geo['status'] ?? null,
                'country'      => $geo['country'] ?? null,
                'country_code' => $geo['countryCode'] ?? null,
                'region'       => $geo['region'] ?? null,
                'region_name'  => $geo['regionName'] ?? null,
                'city'         => $geo['city'] ?? null,
                'zip'          => $geo['zip'] ?? null,
                'lat'          => $geo['lat'] ?? null,
                'lon'          => $geo['lon'] ?? null,
                'timezone'     => $geo['timezone'] ?? null,
                'isp'          => $geo['isp'] ?? null,
                'org'          => $geo['org'] ?? null,
                'as'           => $geo['as'] ?? null,
                'query'        => $geo['query'] ?? $ip,

                'raw'          => $geo,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Visit logging failed: ' . $e->getMessage());
        }
    }

    private function getClientIp(Request $request): ?string
    {
        // Cloudflare headers
        $cfConnectingIp = $request->header('CF-Connecting-IP');
        if ($cfConnectingIp) {
            return trim($cfConnectingIp);
        }

        // Fallbacks (لو عندك Proxy/Load balancer مضبوط)
        $xForwardedFor = $request->header('X-Forwarded-For');
        if ($xForwardedFor) {
            // أول IP هو العميل غالباً
            $parts = array_map('trim', explode(',', $xForwardedFor));
            if (! empty($parts[0])) {
                return $parts[0];
            }
        }

        return $request->ip();
    }
}
