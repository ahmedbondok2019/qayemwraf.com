<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Product;
use App\Models\ShippingSetting as ModelsShippingSetting;
use App\Models\ShippingSettingTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ShippingSetting extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ShippingSettingID;

    public $title;

    protected $listeners = ['ShippingSettingAdded' => '$refresh'];

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
        if (! in_array('134', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $IDS = ShippingSettingTranslation::whereLike('title', $this->search ?? '')->pluck('shipping_setting_id');
        $data['shipping_categories'] = ModelsShippingSetting::whereHas('translations')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.shipping-category', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('137', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $shipping_category = Product::distinct('shipping_category')->pluck('shipping_category');

        $allowed = ModelsShippingSetting::where('id', $this->deleteId)->first();
        if (! in_array($allowed->id, collect($shipping_category)->values()->all())) {
            ModelsShippingSetting::where('id', $this->deleteId)->delete();
            ShippingSettingTranslation::where('shipping_setting_id', $this->deleteId)->delete();

            session()->flash('message', __('website.deleted successfully..'));
            $this->emit('ShippingSettingAdded');
        } else {
            $shipping_category = Product::where('shipping_category', $this->deleteId)->pluck('id');
            session()->flash('message', __('dashboard.not allowed to delete used category').' : '.implode(',', collect($shipping_category)->values()->all()));
            $this->emit('ShippingSettingAdded');
        }
    }

    public function deleteConfirm($ShippingSettingID)
    {
        if (! in_array('137', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $shipping_category = Product::distinct('shipping_category')->pluck('shipping_category');

        $allowed = ModelsShippingSetting::where('id', $ShippingSettingID)->first();
        if (! in_array($allowed->id, collect($shipping_category)->values()->all())) {
            ModelsShippingSetting::where('id', $ShippingSettingID)->delete();
            ShippingSettingTranslation::where('shipping_setting_id', $ShippingSettingID)->delete();

            session()->flash('message', __('website.deleted successfully..'));
            $this->emit('ShippingSettingAdded');
        } else {
            $shipping_category = Product::where('shipping_category', $ShippingSettingID)->pluck('id');
            session()->flash('message', __('dashboard.not allowed to delete used category').' : '.implode(',', collect($shipping_category)->values()->all()));
            $this->emit('ShippingSettingAdded');
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
