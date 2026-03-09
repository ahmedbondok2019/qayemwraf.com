<?php

namespace App\Http\Livewire\Dashboard\Vendor;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderOption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $orderID;

    public $pages;

    protected $listeners = ['orderAdded' => '$refresh'];

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
        $vendorsOrders = OrderDetail::where('vendor_id', Auth::id())->pluck('order_id');
        if ($this->pages == 'all') {
            $data['orders'] = Order::whereIn('id', $vendorsOrders)->orderByDesc('id')->paginate(25);
        }
        if ($this->pages == 'return') {
            $data['orders'] = Order::whereIn('id', $vendorsOrders)->where('status', 5)->orderByDesc('id')->paginate(25);
        }
        if ($this->pages == 'not_completed') {
            $data['orders'] = Order::whereIn('id', $vendorsOrders)->where('status', 6)->orderByDesc('id')->paginate(25);
        }

        return view('livewire.dashboard.vendor.orders', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Order::where('id', $this->deleteId)->delete();
        OrderDetail::where('order_id', $this->deleteId)->delete();
        OrderOption::where('order_id', $this->deleteId)->delete();
        $this->emit('orderAdded');
    }

    public function deleteConfirm($orderID)
    {
        Order::where('id', $this->deleteId)->delete();
        OrderDetail::where('order_id', $this->deleteId)->delete();
        OrderOption::where('order_id', $this->deleteId)->delete();
        $this->emit('orderAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        // $this->title = '';
    }
}
