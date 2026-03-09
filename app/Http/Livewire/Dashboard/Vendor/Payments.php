<?php

namespace App\Http\Livewire\Dashboard\Vendor;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Payments extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $PaymentID;

    public $title;

    public $search;

    protected $listeners = ['PaymentAdded' => '$refresh'];

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
        $data['payments'] = Payment::whereLike('amount', $search ?? '')
            ->whereLike('paid_status', $search ?? '')
            ->whereLike('order_id', $search ?? '')
            ->where('vendor_id', Auth::id())
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.vendor.payments', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Payment::where('id', $this->deleteId)->delete();
        $this->emit('PaymentAdded');
    }

    public function deleteConfirm($PaymentID)
    {
        Payment::where('id', $this->deleteId)->delete();
        $this->emit('PaymentAdded');
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
