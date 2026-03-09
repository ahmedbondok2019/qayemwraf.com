<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Country;
use App\Models\CountryTranslation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCountry extends Component
{
    use WithFileUploads;

    public $CountryID;

    public $title;

    public $image = '';

    protected $listeners = ['CountryAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255|unique:country_translations,title,NULL,id,deleted_at,NULL',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        $data['cities'] = Country::whereHas('translations')->get();

        return view('livewire.dashboard.admin.add-country', $data);
    }

    public function createCountry()
    {
        if (! in_array('18', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = CountryTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            // dd($this->image);
            self::store($this->title, $this->image);
        }

        session()->flash('message', 'Country successfully Created.');

        $this->title = '';
        $this->emit('CountryAdded');

        $this->reset(['title']);

    }

    public static function store($title, $image)
    {
        $data = self::imageUpload($image);
        $image_name = $data['image'];

        $CreateCountry = Country::create([
            'lang_id' => app()->getLocale(),
            'image' => $image_name,
        ]);

        CountryTranslation::create([
            'title' => strip_tags($title),
            'country_id' => $CreateCountry->id,
            'lang_id' => app()->getLocale(),
        ]);
    }

    public static function imageUpload($image)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';
        if (! empty($image)) {
            $ex = $image->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif', 'webp'])) {
                self::UploadImagesblog($image, $image_name, 'flags', '63', '45');

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
