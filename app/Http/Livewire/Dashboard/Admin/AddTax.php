<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Tax;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddTax extends Component
{
    use WithFileUploads;

    public $taxID;

    public $title;

    public $value;

    public $status;

    protected $listeners = ['taxAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'value' => 'required|string|max:255',
        'status' => 'required|string|max:255',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        if (! in_array('107', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('livewire.dashboard.admin.add-tax');
    }

    public function createTax()
    {
        if (! in_array('108', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = Tax::where('title', $this->title)
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            Tax::create([
                'title' => $this->title,
                'value' => $this->value,
                'status' => $this->status,
            ]);
        }

        session()->flash('message', 'tax successfully Created.');

        $this->title = '';
        $this->value = '';
        $this->status = '';
        $this->emit('taxAdded');

        $this->reset(['title']);

    }
}
