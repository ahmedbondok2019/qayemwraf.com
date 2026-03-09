<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\ProfitGroup;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProfitGroup extends Component
{
    use WithFileUploads;

    public $GroupsID;

    public $title;

    public $value;

    public $type;

    protected $listeners = ['GroupsAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'value' => 'required|string|max:255',
        'type' => 'required|string|max:255',
    ];

    protected $messages = [
        'name.required' => 'Required Field',
        'name.string' => 'String Field',
        'name.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        if (! in_array('85', Session::get('permissionData'))) {
            return redirect()->back();
        }

        return view('livewire.dashboard.admin.add-profit-group');
    }

    public function createGroups()
    {
        if (! in_array('86', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = ProfitGroup::where('title', $this->title)
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            ProfitGroup::create([
                'title' => $this->title,
                'value' => $this->value,
                'type' => $this->type,
            ]);
        }

        session()->flash('message', 'Groups successfully Created.');

        $this->title = '';
        $this->value = '';
        $this->type = '';
        $this->emit('GroupsAdded');

        $this->reset(['title']);

    }
}
