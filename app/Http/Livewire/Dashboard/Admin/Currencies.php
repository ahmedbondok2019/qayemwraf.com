<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Currency;
use App\Models\CurrencyTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Currencies extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $currencyID;

    public $name;

    public $slug;

    public $rate;

    public $image;

    protected $listeners = ['CurrencyAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:translations,title,deleted_at,id',
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
        if (! in_array('81', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['currencies'] = Currency::whereHas('translations')->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.currencies', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('84', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Currency::where('id', $this->deleteId)->delete();
        CurrencyTranslation::where('currency_id', $this->deleteId)->delete();
        $this->emit('CurrencyAdded');
    }

    public function deleteConfirm($currencyID)
    {
        if (! in_array('84', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Currency::where('id', $this->deleteId)->delete();
        CurrencyTranslation::where('currency_id', $this->deleteId)->delete();
        $this->emit('CurrencyAdded');
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
