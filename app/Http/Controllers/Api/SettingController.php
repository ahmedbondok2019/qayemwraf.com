<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\settings\intro;
use App\Http\Resources\settings\intro1;
use App\Http\Resources\settings\intro2;
use App\Models\Currency;
use App\Models\CustomerMessage;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use stdClass;

class SettingController extends ApiController
{
    use ApiResponseTrait;

    // public function about(Request $request)
    // {
    //     $userData = Page::where('slug_en', 'about-us')->orwhere('slug_en')->first();
    //     if ($userData){

    //         $content1 = strip_tags($userData->page_content_ar);
    //         $content =str_replace("&nbsp;", " ", $content1);
    //         $contents =str_replace("\r\n", " ", $content);
    //         $news_details = html_entity_decode($contents);

    //         $Data = array(
    //             'content' => $userData->page_content_ar == null ? '' : $news_details,
    //         );
    //     }else{$Data = array();}

    //     return $this->NewApiResponse( $Data, '', 'true', '200');
    // }

    public function configuration(Request $request)
    {
        $userData = new stdClass;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        if ($token != null) {
            $user = UserApiToken::where('api_token', $token)->first();
            if ($user) {
                $userData = User::find($user->user_id);
            }
        }

        $setting = Setting::where('lang_id', $request->header('lang'))->first();
        $Currency = Currency::where('status', 1)->first();

        if (Session::get('maintenance') != true) {
            $maintenance = false;
        } else {
            $maintenance = true;
        }

        $data = [
            'social_login' => [
                'facebook' => (bool) $setting->accept_facebook,
                'google' => (bool) $setting->accept_google,
            ],
            'accept_sms' => optional($userData)->accept_sms,
            'accept_email' => optional($userData)->accept_email,
            'default_lang' => optional($userData)->default_lang,
            'maintenance' => $maintenance,
            'about' => \LaravelLocalization::localizeUrl('about'),
            'privacy' => \LaravelLocalization::localizeUrl('privacy'),
            'terms' => \LaravelLocalization::localizeUrl('terms'),
            'contact' => \LaravelLocalization::localizeUrl('contact'),
            'intro' => [
                new intro($setting),
                new intro1($setting),
                new intro2($setting),
            ],
            'splash' => [
                'title' => (string) $setting->splash_title,
                'image' => 'logo/'.(string) $setting->splash_image,
            ],
            'logo' => 'logo/'.(string) $setting->logo,
            'currencey' => $Currency->translations->currency_sign,
            'version' => $setting->version,
        ];

        return $this->NewApiResponse($data, '', 'true', '200');
    }

    public function about(Request $request)
    {
        $userData = Setting::where('lang_id', $request->header('lang'))->first();
        if ($userData) {
            $content1 = strip_tags($userData->about);
            $content = str_replace('&nbsp;', ' ', $content1);
            $contents = str_replace("\r\n", ' ', $content);
            $news_details = html_entity_decode($contents);

            $Data = [
                'content' => $userData->terms == null ? '' : $news_details,
            ];
        } else {
            $Data = [];
        }

        return $this->NewApiResponse($Data, '', 'true', '200');
    }

    public function terms(Request $request)
    {
        $userData = Setting::where('lang_id', $request->header('lang'))->first();
        if ($userData) {
            $content1 = strip_tags($userData->terms);
            $content = str_replace('&nbsp;', ' ', $content1);
            $contents = str_replace("\r\n", ' ', $content);
            $news_details = html_entity_decode($contents);

            $Data = [
                'content' => $userData->terms == null ? '' : $news_details,
            ];
        } else {
            $Data = [];
        }

        return $this->NewApiResponse($Data, '', 'true', '200');
    }

    public function privacy(Request $request)
    {
        $userData = Setting::where('lang_id', $request->header('lang'))->first();
        if ($userData) {
            $content1 = strip_tags($userData->privacy);
            $content = str_replace('&nbsp;', ' ', $content1);
            $contents = str_replace("\r\n", ' ', $content);
            $news_details = html_entity_decode($contents);

            $Data = [
                'content' => $userData->privacy == null ? '' : $news_details,
            ];
        } else {
            $Data = [];
        }

        return $this->NewApiResponse($Data, '', 'true', '200');
    }

    public function contact(Request $request)
    {
        $userData = Setting::first();
        if ($userData) {
            $Data = [
                'phone1' => $userData->phone1 == null ? '' : $userData->phone1,
                'phone2' => $userData->phone2 == null ? '' : $userData->phone2,
                'support_email' => $userData->support_email == null ? '' : $userData->support_email,
                'whatsapp_link' => $userData->whatsapp_link == null ? '' : $userData->whatsapp_link,
                'telegram_link' => $userData->telegram_link == null ? '' : $userData->telegram_link,
                'twitter_link' => $userData->twitter_link == null ? '' : $userData->twitter_link,
                'instagram_link' => $userData->instagram_link == null ? '' : $userData->instagram_link,
                'snapchat_link' => $userData->snapchat_link == null ? '' : $userData->snapchat_link,
                'youtube_link' => $userData->youtube_link == null ? '' : $userData->youtube_link,
                'address_ar' => $userData->address_ar == null ? '' : $userData->address_ar,
            ];
        } else {
            $Data = [];
        }

        return $this->NewApiResponse($Data, '', 'true', '200');
    }

    public function send_message(Request $request)
    {
        // $user_type = $request->header('user_type') == 'user' ? 1 : 2;
        $user_type = 1;
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = UserApiToken::where('api_token', $token)->where('user_type', $user_type)->first();
        if (! isset($user)) {
            return $this->NewApiResponse(__('website.account not found'), __('website.account not found'), 'false', '404');
        }

        $validator = Validator::make($request->all(), [
            'contact_email' => 'nullable|string',
            'contact_name' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_subject' => 'required|string',
            'contact_message' => 'required|string',
            'message_type' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse('', $validator->errors()->first(), 'true', '200');
        }

        // $test = CustomerMessage::where('contact_phone', $request->contact_phone)
        //     ->where('contact_message', $request->contact_message)
        //    ->where('contact_name', $request->contact_name)
        //    ->where('contact_subject', $request->contact_subject)
        //     ->first();
        // if (empty($test))
        // {
        $inputs = Arr::add($request->all(), 'contact_user_id', $user->user_id);
        CustomerMessage::create($inputs);

        return $this->NewApiResponse('', __('website.Sent Successfully'), 'true', '200');
        // }
        // else{
        //     return $this->NewApiResponse( "", __('website.Duplicate Fields'), 'true', '200');
        // }
    }
}
