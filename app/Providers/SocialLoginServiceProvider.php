<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::find(1);
            if ($settings) {
                if ($settings->facebook_client_id) {
                    Config::set('services.facebook.client_id', $settings->facebook_client_id);
                }
                if ($settings->facebook_client_secret) {
                    Config::set('services.facebook.client_secret', $settings->facebook_client_secret);
                }
                if ($settings->facebook_redirect) {
                    Config::set('services.facebook.redirect', $settings->facebook_redirect);
                }

                if ($settings->google_client_id) {
                    Config::set('services.google.client_id', $settings->google_client_id);
                }
                if ($settings->google_client_secret) {
                    Config::set('services.google.client_secret', $settings->google_client_secret);
                }
                if ($settings->google_redirect) {
                    Config::set('services.google.redirect', $settings->google_redirect);
                }
            }
        }
    }
}
