<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Product;
use App\Models\ShippingCategory as ModelsShippingCategory;
use App\Models\ShippingCategoryTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ShippingCategory extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ShippingCategoryID;

    public $title;

    protected $listeners = ['ShippingCategoryAdded' => '$refresh'];

    public $deleteId = '';

    public $search = '';

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:area_translations,title,deleted_at,id',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    // public function updatingSearch()
    // {
    //     $this->resetPage('commentsPage');
    // }

    public function render()
    {
        if (! in_array('25', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $IDS = ShippingCategoryTranslation::whereLike('title', $this->search ?? '')->pluck('shipping_category_id');
        $data['shipping_categories'] = ModelsShippingCategory::whereHas('translations')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.shipping-category', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('28', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $shipping_category = Product::distinct('shipping_category')->pluck('shipping_category');

        $allowed = ModelsShippingCategory::where('id', $this->deleteId)->first();
        if (! in_array($allowed->id, collect($shipping_category)->values()->all())) {
            ModelsShippingCategory::where('id', $this->deleteId)->delete();
            ShippingCategoryTranslation::where('shipping_category_id', $this->deleteId)->delete();

            session()->flash('message', __('website.deleted successfully..'));
            $this->emit('ShippingCategoryAdded');
        } else {
            $shipping_category = Product::where('shipping_category', $this->deleteId)->pluck('id');
            session()->flash('message', __('dashboard.not allowed to delete used category').' : '.implode(',', collect($shipping_category)->values()->all()));
            $this->emit('ShippingCategoryAdded');
        }
    }

    public function deleteConfirm($ShippingCategoryID)
    {
        if (! in_array('28', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $shipping_category = Product::distinct('shipping_category')->pluck('shipping_category');

        $allowed = ModelsShippingCategory::where('id', $ShippingCategoryID)->first();
        if (! in_array($allowed->id, collect($shipping_category)->values()->all())) {
            ModelsShippingCategory::where('id', $ShippingCategoryID)->delete();
            ShippingCategoryTranslation::where('shipping_category_id', $ShippingCategoryID)->delete();

            session()->flash('message', __('website.deleted successfully..'));
            $this->emit('ShippingCategoryAdded');
        } else {
            $shipping_category = Product::where('shipping_category', $ShippingCategoryID)->pluck('id');
            session()->flash('message', __('dashboard.not allowed to delete used category').' : '.implode(',', collect($shipping_category)->values()->all()));
            $this->emit('ShippingCategoryAdded');
        }
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->title = '';
    }
}
