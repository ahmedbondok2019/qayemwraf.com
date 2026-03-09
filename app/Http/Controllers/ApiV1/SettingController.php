<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Resources\ApiV1\SettingResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group General
 * 
 * APIs for general app settings and configuration.
 */
class SettingController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Settings
     * 
     * Returns the app settings and social links.
     */
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            return $this->errorResponse('Settings not found', 404);
        }

        return $this->successResponse(new SettingResource($setting));
    }

    /**
     * Get Configuration (Legacy)
     * 
     * Specific endpoint for old Flutter app versions.
     */
    public function configuration()
    {
        $setting = Setting::first();

        if (!$setting) {
             return response()->json([
                'status' => false,
                'data' => null,
                'error' => 'Settings not found',
                'code' => '404'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'social_login' => [
                    'facebook' => true,
                    'google' => true,
                ],
                'accept_sms' => true,
                'accept_email' => true,
                'maintenance' => false,
                'default_lang' => 'ar',
                'about' => $setting->translate('about') ?: 'About Mushaf Home',
                'privacy' => $setting->translate('privacy') ?: 'Privacy Policy',
                'terms' => $setting->translate('terms') ?: 'Terms & Conditions',
                'contact' => $setting->phone,
                'intro' => [],
                'splash' => [
                    'title' => $setting->translate('app_name'),
                    'image' => $setting->logo ? asset($setting->logo) : null,
                ],
                'logo' => $setting->logo ? asset($setting->logo) : null,
                'currencey' => 'EGP',
            ],
            'error' => null,
            'code' => '200'
        ], 200);
    }
}
