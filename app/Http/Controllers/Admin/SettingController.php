<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends BackendController
{
    public function index(Request $request)
    {
      
        $data['Setting'] = Setting::find(1);
        if (empty($data['Setting'])) {
            $data['Setting'] = new Setting;
        }

        return view('dashboard.admin.setting.setting', $data);
    }

    public function update(Request $request)
    {
    

        $validator = Validator::make($request->all(), [
            'app_name' => 'nullable|array',
            'app_meta_title' => 'nullable|array',
            'app_meta_desc' => 'nullable|array',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|array',
            'logo' => 'nullable|image',
            'logo_dark' => 'nullable|image',
            'fav_icon' => 'nullable|image',
            'min_order_for_gift' => 'nullable|numeric',
            'max_gift_items' => 'nullable|integer',
            'msg_processing' => 'nullable|array',
            'msg_shipped' => 'nullable|array',
            'msg_completed' => 'nullable|array',
            'msg_cancelled' => 'nullable|array',
            'msg_delivered' => 'nullable|array',
            'facebook_client_id' => 'nullable|string',
            'facebook_client_secret' => 'nullable|string',
            'facebook_redirect' => 'nullable|string',
            'google_client_id' => 'nullable|string',
            'google_client_secret' => 'nullable|string',
            'google_redirect' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'show_ratings' => 'nullable',
            'enable_reviews' => 'nullable',
            'primary_color' => 'nullable|string',
            'primary_color_to' => 'nullable|string',
            'why_choose_us_title' => 'nullable|array',
            'why_choose_us_subtitle' => 'nullable|array',
            'why_choose_us_items' => 'nullable|array',
            'catalog_title' => 'nullable|array',
            'catalog_description' => 'nullable|array',
            'catalog_pdf' => 'nullable|file|mimes:pdf|max:51200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepare data for update/create
        $data = [
            'app_name' => $request->app_name,
            'app_meta_title' => $request->app_meta_title,
            'app_meta_desc' => $request->app_meta_desc,
            'address' => $request->address,
            'phone' => $request->phone,
            'contact_email' => $request->contact_email,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'whatsapp' => $request->whatsapp,
            'linkedin' => $request->linkedin,
            'min_order_for_gift' => $request->min_order_for_gift,
            'max_gift_items' => $request->max_gift_items,
            'msg_processing' => $request->msg_processing,
            'msg_shipped' => $request->msg_shipped,
            'msg_completed' => $request->msg_completed,
            'msg_cancelled' => $request->msg_cancelled,
            'msg_delivered' => $request->msg_delivered,
            'facebook_client_id' => $request->facebook_client_id,
            'facebook_client_secret' => $request->facebook_client_secret,
            'facebook_redirect' => $request->facebook_redirect,
            'google_client_id' => $request->google_client_id,
            'google_client_secret' => $request->google_client_secret,
            'google_redirect' => $request->google_redirect,
            'show_ratings' => $request->has('show_ratings'),
            'enable_reviews' => $request->has('enable_reviews'),
            'primary_color' => $request->primary_color,
            'primary_color_to' => $request->primary_color_to,
            'why_choose_us_title' => $request->why_choose_us_title,
            'why_choose_us_subtitle' => $request->why_choose_us_subtitle,
            'why_choose_us_items' => $request->why_choose_us_items,
            'catalog_title' => $request->catalog_title,
            'catalog_description' => $request->catalog_description,
        ];

        // Handle Images
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = HelperController::make_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . Carbon::now()) . '.' . $file->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $fileName;
            
            HelperController::upload_images($fullStoragePath, $destination, $file, '204', '98', null);
     
             $data['logo'] = 'storage/website/images/logo/' . $fileName;
        }

        if ($request->hasFile('logo_dark')) {
            $file = $request->file('logo_dark');
            $fileName = HelperController::make_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . Carbon::now()) . '.' . $file->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $fileName;

            HelperController::upload_images($fullStoragePath, $destination, $file, '204', '98', null);
            $data['logo_dark'] = 'storage/website/images/logo/' . $fileName;
        }

        if ($request->hasFile('fav_icon')) {
            $file = $request->file('fav_icon');
            $fileName = HelperController::make_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . Carbon::now()) . '.png';
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $fileName;

            HelperController::upload_images($fullStoragePath, $destination, $file, '100', '100', 'png');
            $data['fav_icon'] = 'storage/website/images/logo/' . $fileName;
        }

        if ($request->hasFile('catalog_pdf')) {
            $file = $request->file('catalog_pdf');
            $fileName = 'catalog_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('catalogs', $fileName, 'public');
            $data['catalog_pdf'] = 'storage/' . $path;
        }

        Setting::updateOrCreate(['id' => 1], $data);

        alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));

        return redirect()->back(); // Stay on page or redirect to index
    }
}
