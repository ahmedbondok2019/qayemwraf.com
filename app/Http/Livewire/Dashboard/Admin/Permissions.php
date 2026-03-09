<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $userID;

    public $name;

    protected $listeners = ['groupAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name,deleted_id,id',
    ];

    protected $messages = [
        'name.unique' => 'لا يمكن تكرار الاسم',
        'name.required' => 'Required Field',
        'name.string' => 'String Field',
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
        $data['PermissionGroups'] = Group::select('id', 'name')->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.permissions', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId != 1) {
            Group::where('id', $this->deleteId)->delete();
        }
        $this->emit('groupAdded');
    }

    public function deleteConfirm($userID)
    {
        if ($userID != 1) {
            Group::where('id', $userID)->delete();
        }
        $this->emit('groupAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->name = '';
    }
}
