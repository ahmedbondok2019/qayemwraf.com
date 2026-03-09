<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class News extends Component
{
    use WithFileUploads;

    public $ID;

    public $newsletter_title;

    public $newsletter_description;

    public $Setting;

    public $newsletter_image_to_send;

    protected $listeners = ['newsletterData' => '$refresh'];

    protected $rules = [
        'newsletter_title' => 'required|string|max:100000',
        'newsletter_description' => 'required|string',
        'newsletter_image_to_send' => 'required|mimes:jpeg,jpg,PNG,JPEG,JPG,bmp,png,webp,jfif',
    ];

    protected $messages = [
        'newsletter_title.required' => 'Required Field',
        'newsletter_title.string' => 'String Field',
        'newsletter_description.required' => 'Required Field',
        'newsletter_description.string' => 'String Field',
        'newsletter_image_to_send.required' => 'required Field',
        'newsletter_image_to_send.mimes' => 'not valid extension',
    ];

    public function mount($Setting)
    {
        $this->newsletter_title = $Setting->newsletter_title;
        $this->newsletter_description = $Setting->newsletter_description;
        $this->newsletter_image_to_send = $Setting->newsletter_image_to_send;
    }

    public function render()
    {
        return view('livewire.dashboard.admin.news');
    }

    public function storeNewsletterData()
    {
        if (! in_array('101', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $data = Setting::where('lang_id', app()->getLocale())->first();

        $imageUpload = self::imageUpload($this->newsletter_image_to_send);
        $image_name = $imageUpload['image'];

        if ($data) {
            $data->update([
                'newsletter_title' => htmlspecialchars($this->newsletter_title),
                'newsletter_description' => htmlspecialchars($this->newsletter_description),
                'newsletter_image_to_send' => $image_name,
            ]);
        }

        session()->flash('message', __('dashboard.saved'));
        $this->emit('newsletterData');
    }

    public static function imageUpload($image)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';
        if (! empty($image)) {
            $ex = $image->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {
                self::UploadImagesblog($image, $image_name, 'newsletter_image');

                return ['image' => $image_name, 'body' => __('dashboard.saved'), 'title' => __('dashboard.congratulation'), 'type' => 'success'];
            } else {
                return ['image' => $image_name, 'body' => __('dashboard.notsaved'), 'title' => __('dashboard.attention'), 'type' => 'error'];
            }
        } else {
            return ['image' => $image_name, 'body' => __('dashboard.InValidImage'), 'title' => __('dashboard.attention'), 'type' => 'error'];
        }
    }

    public static function UploadImagesBlog($image, $name, $folder, $width = null, $height = null)
    {
        $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder);
        $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$name);

        return HelperController::upload_images($path, $destination, $image, $width, $height);
    }
}
