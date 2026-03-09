<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\helper\HelperController;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferTranslation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddOffer extends Component
{
    use WithFileUploads;

    public $offerID;

    public $title;

    public $image;

    public $slug;

    public $category;

    public $position;

    public $link;

    protected $listeners = ['offerAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'link' => 'required|string|max:255',
        // 'category' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'image' => 'required|mimes:jpeg,bmp,png,webp,jfif,avif,jpg,webp',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        $data['categories'] = Category::whereHas('CategoryTranslation')->orderByDesc('id')->get();

        return view('livewire.dashboard.admin.add-offer', $data);
    }

    public function createOffer()
    {
        if (! in_array('34', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        // dd('test');
        $withoutTrashed = OfferTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            self::store($this->title, $this->image, $this->slug, $this->category, $this->position, $this->link);
        }

        session()->flash('message', 'Offer successfully Created.');

        // $this->title = "";
        // $this->slug = "";
        // $this->link = "";
        // $this->category = "";
        // $this->position = "";
        // $this->image = "";
        $this->emit('offerAdded');

        // $this->reset(['title']);

    }

    public static function store($title, $image, $slug, $category, $position, $link)
    {
        $max = Offer::max('views');
        $CreateOffer = Offer::create([
            'views' => $max,
            'link' => $link,
        ]);

        $data = self::imageUpload($image, $position);
        $image_name = $data['image'];

        OfferTranslation::create([
            'title' => strip_tags($title),
            'slug' => strip_tags($slug),
            'category' => $category,
            'position' => $position,
            'image' => $image_name,
            'offer_id' => $CreateOffer->id,
            'lang_id' => app()->getLocale(),
        ]);
    }

    public static function imageUpload($image, $position)
    {
        $image_nam = HelperController::make_slug(Str::random('8').'_'.str_replace(' ', '', Carbon::today()));
        $image_name = str_replace(' ', '', $image_nam).'.png';
        $scale = OffersController::getImageScale($position);
        if (! empty($image)) {
            $ex = $image->getClientOriginalExtension();
            if (in_array($ex, ['png', 'jpeg', 'jpg', 'JPG', 'jfif', 'avif', 'webp'])) {
                self::UploadImagesblog($image, $image_name, 'offers', $scale['width'], $scale['height']);

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
