<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Payment;
use Illuminate\Support\Facades\Session;
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
        if (! in_array('33', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['payments'] = Payment::whereLike('amount', $search ?? '')
            ->whereLike('paid_status', $search ?? '')
            ->whereLike('order_id', $search ?? '')
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.payments', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Payment::where('id', $this->deleteId)->delete();
        $this->emit('PaymentAdded');
    }

    public function deleteConfirm($PaymentID)
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }
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
