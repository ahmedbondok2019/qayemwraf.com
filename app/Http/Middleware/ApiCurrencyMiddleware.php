<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Currency;

class ApiCurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Priority: Check Header (Flutter can send X-Currency: SAR)
        $code = $request->header('X-Currency');

        if (!$code) {
            // 2. Detect Country by IP (Stateless)
            $countryCode = 'EG'; // Default
            
            if ($request->header('CF-IPCountry')) {
                $countryCode = $request->header('CF-IPCountry');
            } else {
                $ip = $request->ip();
                if ($ip != '127.0.0.1' && $ip != '::1') {
                    try {
                        $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
                        if ($response->successful()) {
                            $data = $response->json();
                            $countryCode = $data['countryCode'] ?? 'EG';
                        }
                    } catch (\Exception $e) {
                        // Fail silently
                    }
                }
            }

            // Map Country to Currency Code (Same logic as Web)
            $code = 'USD';
            if ($countryCode == 'EG') {
                $code = 'EGP';
            } elseif ($countryCode == 'SA') {
                $code = 'SAR';
            }
        }

        // 3. Get Currency from DB
        $currency = Currency::where('code', $code)->active()->first();
        
        if (!$currency) {
            $currency = Currency::where('is_default', 1)->first() ?? Currency::first();
        }

        if ($currency) {
            config(['app.currency_code' => $currency->code]);
            config(['app.currency_symbol' => $currency->symbol]);
            config(['app.exchange_rate' => $currency->exchange_rate]);
        } else {
            // Fallback
            config(['app.currency_code' => 'EGP']);
            config(['app.currency_symbol' => 'ج.م']);
            config(['app.exchange_rate' => 1]);
        }

        return $next($request);
    }
}
