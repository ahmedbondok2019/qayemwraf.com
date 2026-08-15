<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('format_price')) {
    function format_price($price)
    {
        // For API, we might use config or a custom header-based setting
        // For Web, we use Session
        $currencySymbol = config('app.currency_symbol') ?: Session::get('currency_symbol', 'ج.م');
        $rate = config('app.exchange_rate') ?: Session::get('exchange_rate', 1);

        if ($rate <= 0) $rate = 1;

        $newPrice = $price / $rate;

        return number_format($newPrice, 2) . ' ' . $currencySymbol;
    }
}

if (!function_exists('trans_db')) {
    function trans_db($key, $default = null, $replace = [])
    {
        $locale = app()->getLocale();
        
        $entry = \App\Models\StaticTranslation::where('key', $key)->first();
        if ($entry && isset($entry->translations[$locale]) && !empty($entry->translations[$locale])) {
            return $entry->translations[$locale];
        }

        // Fallback to default translation if not found in DB
        return trans($key, $replace, $locale);
    }
}

if (!function_exists('frontend_site_url')) {
    function frontend_site_url($url)
    {
        $frontendUrl = config('app.frontend_url');
        if (!$frontendUrl) {
            $appUrl = config('app.url');
            $frontendUrl = preg_replace('/:\/\/(www\.)?admin\./i', '://', $appUrl);
        }
        $appUrl = config('app.url');
        return str_replace($appUrl, $frontendUrl, $url);
    }
}

