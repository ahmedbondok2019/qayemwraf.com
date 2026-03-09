<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Country;
use App\Models\CountryTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Countries extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $CountryID;

    public $title;

    protected $listeners = ['CountryAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:area_translations,title,deleted_at,id',
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

    /* خاص بالفلترة */
    public $sortBy = 'id';

    public $field;

    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
    /* خاص بالفلترة */

    public function render()
    {
        if (! in_array('21', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['countries'] = Country::whereHas('translations');
        if ($this->sortBy == 'id') {
            $data['countries'] = $data['countries']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['countries'] = $data['countries']->join('country_translations', 'countries.id', 'country_translations.country_id')
                ->where('country_translations.lang_id', app()->getLocale())
                ->select('countries.*')
                ->orderBy('country_translations.title', $this->sortDirection);
        } elseif ($this->sortBy == 'parent_id') {
            $data['countries'] = $data['countries']->orderBy('parent_id', $this->sortDirection);
        } else {
            $data['countries'] = $data['countries']->orderByDesc('id');
        }
        $data['countries'] = $data['countries']->paginate(10);

        return view('livewire.dashboard.admin.countries', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId != 1) {
            Country::where('id', $this->deleteId)->delete();
            CountryTranslation::where('country_id', $this->deleteId)->delete();
        }
        $this->emit('CountryAdded');
    }

    public function deleteConfirm($CountryID)
    {
        Country::where('id', $CountryID)->delete();
        $this->emit('CountryAdded');
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
