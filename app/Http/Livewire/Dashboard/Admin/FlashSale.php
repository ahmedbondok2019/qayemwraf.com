<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\FlashSale as ModelsFlashSale;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class FlashSale extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $FlashSaleID;

    public $title;

    protected $listeners = ['FlashSaleAdded' => '$refresh'];

    public $deleteId = '';

    public function render()
    {
        if (! in_array('134', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['flash_sale'] = ModelsFlashSale::paginate(20);

        return view('livewire.dashboard.admin.flash-sale', $data);
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

        $code = ModelsFlashSale::where('id', $this->deleteId)->first();
        $testUse = Order::where('flash_sale', $code->id)->first();
        if (empty($testUse)) {
            $code->delete();
        }

        $this->emit('FlashSaleAdded');
    }

    public function deleteConfirm($FlashSaleID)
    {
        if (! in_array('137', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $code = ModelsFlashSale::where('id', $FlashSaleID)->first();
        $testUse = Order::where('flash_sale', $code->id)->first();
        if (empty($testUse)) {
            $code->delete();
        }

        $this->emit('FlashSaleAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }
}
