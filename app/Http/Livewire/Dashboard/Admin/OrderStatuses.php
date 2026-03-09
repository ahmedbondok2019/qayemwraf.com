<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\OrderStatus;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class OrderStatuses extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ID;

    public $order_id;

    protected $listeners = ['OrderAdded' => '$refresh'];

    public function render()
    {
        if (! in_array('57', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['order_statuses'] = OrderStatus::where('order_id', $this->order_id)->get();

        return view('livewire.dashboard.admin.order-statuses', $data);
    }
}
