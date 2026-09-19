<?php

namespace App\Http\Middleware;

use App\Models\Currency;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SetCurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentIp = $request->ip();

        if (! Session::has('currency_code') || Session::get('last_ip') !== $currentIp) {
            // 1. Detect Country
            $countryCode = 'EG'; // Default
            // Cloudflare Header
            if ($request->header('CF-IPCountry')) {
                $countryCode = $request->header('CF-IPCountry');
            } else {
                // Fallback: Use an IP API if not in dev environment/localhost
                $ip = $request->ip();
                if ($ip != '127.0.0.1' && $ip != '::1') {
                    try {
                        // Simple timeout to avoid blocking
                        $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
                        if ($response->successful()) {
                            $data = $response->json();
                            $countryCode = $data['countryCode'] ?? 'EG';
                        }
                    } catch (\Exception $e) {
                        // Fail silently to default
                    }
                }
            }
            // 2. Map Country to Currency Code
            $code = 'USD';
            if ($countryCode == 'EG') {
                $code = 'EGP';
            } elseif ($countryCode == 'SA') {
                $code = 'SAR';
            }

            // 3. Fetch Currency from DB
            $currency = Currency::where('code', $code)->active()->first();

            // Fallback if not found in DB
            if (! $currency) {
                $currency = Currency::where('is_default', 1)->first()
                            ?? Currency::first();
            }

            if ($currency) {
                Session::put('currency_code', $currency->code);
                Session::put('currency_symbol', $currency->symbol);
                Session::put('exchange_rate', $currency->exchange_rate);
            } else {
                // Absolute fallback
                Session::put('currency_code', 'EGP');
                Session::put('currency_symbol', 'ج.م');
                Session::put('exchange_rate', 1);
            }

            Session::put('last_ip', $currentIp);
        }

        return $next($request);
    }
}
