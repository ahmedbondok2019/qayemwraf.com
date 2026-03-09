<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Models\Offer;
use App\Models\OfferTranslation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddTopOffer extends Component
{
    use WithFileUploads;

    public $offerID;

    public $title;

    public $image;

    public $topOffer;

    public $show_image;

    protected $listeners = ['topOfferAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'image' => 'required|mimes:jpeg,bmp,png,webp,jfif,jpg,webp',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function mount()
    {
        $offerData = Offer::where('static', 1)->first()->offer_translations();
        $this->title = $offerData->title;
        $this->image = $offerData->image;
    }

    public function render()
    {
        $data['topOffer'] = Offer::where('static', 1)->first();

        return view('livewire.dashboard.admin.add-top-offer', $data);
    }

    public function createOffer()
    {
        if (! in_array('34', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        self::store($this->title, $this->image);

        session()->flash('message', 'Offer successfully Created.');
        $this->emit('topOfferAdded');
    }

    public static function store($title, $image)
    {
        $CreateOffer = Offer::where('static', 1)->first();

        $data = self::imageUpload($image);
        $image_name = $data['image'];

        OfferTranslation::where('offer_id', $CreateOffer->id)->where('lang_id', app()->getLocale())->update([
            'title' => strip_tags($title),
            'image' => $image_name,
            'offer_id' => $CreateOffer->id,
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
                self::UploadImagesblog($image, $image_name, 'offers', '64', '64');

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
