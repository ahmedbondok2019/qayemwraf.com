<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\ProfitGroup as ModelsProfitGroup;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ProfitGroup extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $GroupsID;

    public $title;

    public $value;

    public $type;

    protected $listeners = ['GroupsAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:profit_groups,title,deleted_at,id',
        'value' => 'required|string',
        'type' => 'required|string',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

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
        if (! in_array('85', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['groups'] = ModelsProfitGroup::orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.profit-group', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('88', Session::get('permissionData'))) {
            return redirect()->back();
        }
        ModelsProfitGroup::where('id', $this->deleteId)->delete();
        $this->emit('GroupsAdded');
    }

    public function deleteConfirm($GroupsID)
    {
        if (! in_array('84', Session::get('permissionData'))) {
            return redirect()->back();
        }
        ModelsProfitGroup::where('id', $this->deleteId)->delete();
        $this->emit('GroupsAdded');
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
