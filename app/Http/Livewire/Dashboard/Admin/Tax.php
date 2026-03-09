<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Tax as ModelsTax;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Tax extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $taxID;

    public $title;

    public $value;

    public $status;

    protected $listeners = ['taxAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:taxes,title,deleted_at,id',
        'value' => 'required|string',
        'status' => 'required|string',
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
        if (! in_array('107', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['taxes'] = ModelsTax::orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.tax', $data);
    }

    public function changeStatus($taxID, $status)
    {
        if (! in_array('108', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->status = $status;
        ModelsTax::where('id', $taxID)->update(['status' => $status]);

        session()->flash('message', __('dashboard.updated'));
        $this->emit('taxAdded');
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('110', Session::get('permissionData'))) {
            return redirect()->back();
        }
        ModelsTax::where('id', $this->deleteId)->delete();
        $this->emit('taxAdded');
    }

    public function deleteConfirm($taxID)
    {
        if (! in_array('110', Session::get('permissionData'))) {
            return redirect()->back();
        }
        ModelsTax::where('id', $this->deleteId)->delete();
        $this->emit('taxAdded');
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
