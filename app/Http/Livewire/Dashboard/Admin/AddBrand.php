<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Brand;
use App\Models\BrandTranslation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddBrand extends Component
{
    use WithFileUploads;

    public $brandID;

    public $title;

    public $image;

    protected $listeners = ['brandAdded' => '$refresh'];

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:brand_translations,title,deleted_at,id',
        'title' => 'required|string|max:255',
        'image' => 'required|mimes:jpeg,bmp,png,webp,jfif',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        return view('livewire.dashboard.admin.add-brand');
    }

    public function createBrand()
    {
        if (! in_array('34', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = BrandTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            self::store($this->title, $this->image);
        }

        session()->flash('message', 'Brand successfully Created.');

        $this->title = '';
        $this->emit('brandAdded');

        $this->reset(['title']);

    }

    public static function store($title, $image)
    {
        $CreateBrand = Brand::create([
            'status' => 1,
            // 'lang_id' => app()->getLocale(),
        ]);

        $data = self::imageUpload($image);
        $image_name = $data['image'];

        BrandTranslation::create([
            'title' => strip_tags($title),
            'brand_id' => $CreateBrand->id,
            'image' => $image_name,
            'lang_id' => app()->getLocale(),
        ]);
    }

    public static function imageUpload($image)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';

        if (! empty($image)) {
            $ex = $image->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif'])) {
                self::UploadImagesblog($image, $image_name, 'brands', '100 ', '100');

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
