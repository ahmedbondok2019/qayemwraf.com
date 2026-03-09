<?php

namespace App\Http\Livewire\Dashboard\Vendor;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddOrderStatus extends Component
{
    public $ID;

    public $status;

    public $notes;

    public $user_id;

    public $order_id;

    protected $listeners = ['OrderAdded' => '$refresh'];

    protected $rules = [
        'notes' => 'nullable|string|max:100000',
        'status' => 'required|string|max:10',
    ];

    protected $messages = [
        'notes.required' => 'Required Field',
        'notes.string' => 'String Field',
        'notes.max' => 'max Field 255',
    ];

    public function render()
    {
        return view('livewire.dashboard.vendor.add-order-status');
    }

    public function createOrderStatus()
    {
        $this->validate();
        $withoutTrashed = OrderStatus::where('notes', $this->notes)->where('status', $this->status)
            ->where('user_id', $this->user_id)->where('order_id', $this->order_id)
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            $notPreviousStatus = OrderStatus::where('user_id', $this->user_id)
                ->where('order_id', $this->order_id)->orderByDesc('status')->first();
            if (isset($notPreviousStatus)) {
                if ($this->status > $notPreviousStatus->status) {
                    self::store($this->notes, $this->status, $this->user_id, $this->order_id);
                }
            } else {
                self::store($this->notes, $this->status, $this->user_id, $this->order_id);
            }
        }

        session()->flash('message', 'Status successfully Created.');

        $this->notes = '';
        $this->status = '';
        $this->emit('OrderAdded');

        $this->reset(['notes', 'status']);

    }

    public static function store($notes, $status, $user_id, $order_id)
    {
        if ($status > 0) {
            Order::where('id', $order_id)->where('user_id', $user_id)->update([
                'status' => $status,
            ]);

            OrderStatus::create([
                'status' => $status,
                'notes' => $notes,
                'user_id' => $user_id,
                'order_id' => $order_id,
                'vendor_id' => Auth::id(),
            ]);
        }

    }
}
