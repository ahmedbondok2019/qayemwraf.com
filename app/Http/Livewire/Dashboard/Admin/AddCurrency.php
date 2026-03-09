<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Currency;
use App\Models\CurrencyTranslation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCurrency extends Component
{
    use WithFileUploads;

    public $CurrencyID;

    public $name;

    public $image;

    public $slug;

    public $rate;

    public $status;

    public $currency_sign;

    protected $listeners = ['CurrencyAdded' => '$refresh'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'rate' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'currency_sign' => 'required|string|max:255',
        // 'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
    ];

    protected $messages = [
        'name.required' => 'Required Field',
        'name.string' => 'String Field',
        'name.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        if (! in_array('81', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('livewire.dashboard.admin.add-currency');
    }

    public function createCurrency()
    {
        if (! in_array('82', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = CurrencyTranslation::where('name', $this->name)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            if ($this->status == 1) {
                Currency::where('status', $this->status)->update(['status' => 0]);
            }
            $CreateCurrency = Currency::create([
                'rate' => $this->rate,
                'status' => $this->status,
                'lang_id' => app()->getLocale(),
            ]);

            // $data = self::imageUpload($image);
            // $image_name = $data['image'];

            CurrencyTranslation::create([
                'name' => strip_tags($this->name),
                'slug' => strip_tags($this->slug),
                'rate' => $this->rate,
                'status' => $this->status,
                'currency_sign' => $this->currency_sign,
                // "image" => $image_name,
                'currency_id' => $CreateCurrency->id,
                'lang_id' => app()->getLocale(),
            ]);
        }

        session()->flash('message', 'Currency successfully Created.');

        $this->name = '';
        $this->slug = '';
        $this->rate = '';
        $this->status = '';
        $this->currency_sign = '';
        $this->emit('CurrencyAdded');

        $this->reset(['name']);

    }

    public static function imageUpload($image)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';

        if (! empty($image)) {
            $ex = $image->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {
                self::UploadImagesblog($image, $image_name, 'currenciess', '100 ', '100');

                return ['image' => $image_name, 'body' => __('dashboard.saved'), 'name' => __('dashboard.congratulation'), 'type' => 'success'];
            } else {
                return ['image' => $image_name, 'body' => __('dashboard.notsaved'), 'name' => __('dashboard.attention'), 'type' => 'error'];
            }
        } else {
            return ['image' => $image_name, 'body' => __('dashboard.InValidImage'), 'name' => __('dashboard.attention'), 'type' => 'error'];
        }
    }

    public static function UploadImagesBlog($image, $name, $folder, $width = null, $height = null)
    {
        $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder);
        $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$name);

        return HelperController::upload_images($path, $destination, $image, $width, $height);
    }
}
