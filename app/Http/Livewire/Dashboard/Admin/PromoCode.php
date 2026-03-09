<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Order;
use App\Models\Promocode as ModelsPromocode;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PromoCode extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $PromoCodeID;

    public $title;

    protected $listeners = ['PromoCodeAdded' => '$refresh'];

    public $deleteId = '';

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
        if (! in_array('65', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['promo_code'] = ModelsPromocode::paginate(20);

        return view('livewire.dashboard.admin.promo-code', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('68', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $code = ModelsPromocode::where('id', $this->deleteId)->first();
        $testUse = Order::where('coupon_code', $code->promo_code)->first();
        if (empty($testUse)) {
            $code->delete();
        }

        $this->emit('PromoCodeAdded');
    }

    public function deleteConfirm($PromoCodeID)
    {
        if (! in_array('68', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $code = ModelsPromocode::where('id', $PromoCodeID)->first();
        $testUse = Order::where('coupon_code', $code->promo_code)->first();
        if (empty($testUse)) {
            $code->delete();
        }

        $this->emit('PromoCodeAdded');
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
