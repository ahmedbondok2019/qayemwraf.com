<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Area;
use App\Models\Category;
use App\Models\ShippingCategory;
use App\Models\ShippingCategoryTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddShippingCategory extends Component
{
    public $ShippingCategoryID;

    public $title;

    public $area;

    public $slug;

    public $product_category;

    public $price_type;

    public $price;

    protected $listeners = ['ShippingCategoryAdded' => '$refresh'];

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:ShippingCategory_translations,title,deleted_at,id',
        'title' => 'required|string|max:255',
        'area' => 'required|string',
        'product_category' => 'required|string',
        'price_type' => 'required|string',
        'price' => 'required|string',
        'slug' => 'required|string',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'area.required' => 'Required Field',
        'area.string' => 'String Field',
        'product_category.required' => 'Required Field',
        'product_category.string' => 'String Field',
        'price_type.required' => 'Required Field',
        'price_type.string' => 'String Field',
        'price.required' => 'Required Field',
        'price.string' => 'String Field',
        'slug.required' => 'Required Field',
        'slug.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['areas'] = Area::whereHas('translations')->get();
        $data['categories'] = Category::whereHas('CategoryTranslation')->get();

        return view('livewire.dashboard.admin.add-shipping-category', $data);
    }

    public function createShippingCategories()
    {
        if (! in_array('26', Session::get('permissionData'))) {
            return redirect()->back();
        }

        // dd($this->title, $this->slug , $this->area , $this->product_category ,
        // $this->price_type, $this->price);

        $this->validate();

        $withoutTrashed = ShippingCategoryTranslation::where('title', $this->title)
            ->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            self::store(
                $this->title, $this->slug, $this->area, $this->product_category,
                $this->price_type, $this->price
            );
        }

        session()->flash('message', 'ShippingCategory successfully Created.');

        $this->title = '';
        $this->slug = '';
        $this->area = '';
        $this->product_category = '';
        $this->price_type = '';
        $this->price = '';

        $this->emit('ShippingCategoryAdded');
        $this->reset(['title', 'area', 'slug', 'product_category', 'price_type', 'price']);

    }

    public static function store($title, $slug, $area, $product_category, $price_type, $price)
    {
        $CreateShippingCategory = ShippingCategory::create([
            'lang_id' => app()->getLocale(),
            'product_category' => $product_category,
            'admin_id' => Auth::id(),
            'area_id' => $area,
            'price_type' => $price_type,
            'price' => $price,
        ]);

        ShippingCategoryTranslation::create([
            'title' => strip_tags($title),
            'slug' => strip_tags($slug),
            'shipping_category_id' => $CreateShippingCategory->id,
            'product_category' => $product_category,
            'admin_id' => Auth::id(),
            'area_id' => $area,
            'lang_id' => app()->getLocale(),
        ]);
    }
}
