<?php

namespace App\Http\Livewire\Dashboard\Vendor;

use App\Models\OrderStatus;
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
        $data['order_statuses'] = OrderStatus::where('order_id', $this->order_id)->get();

        return view('livewire.dashboard.vendor.order-statuses', $data);
    }
}
