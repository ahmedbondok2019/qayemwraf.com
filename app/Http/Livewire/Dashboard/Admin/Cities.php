<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\City;
use App\Models\CityTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Cities extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $CityID;

    public $title;

    protected $listeners = ['CityAdded' => '$refresh'];

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
        $data['cities'] = City::whereHas('translations');
        if ($this->sortBy == 'id') {
            $data['cities'] = $data['cities']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['cities'] = $data['cities']->join('city_translations', 'cities.id', 'city_translations.city_id')
                ->where('city_translations.lang_id', app()->getLocale())
                ->select('cities.*')
                ->orderBy('city_translations.title', $this->sortDirection);
        } elseif ($this->sortBy == 'parent_id') {
            $data['cities'] = $data['cities']->orderBy('parent_id', $this->sortDirection);
        } else {
            $data['cities'] = $data['cities']->orderByDesc('id');
        }
        $data['cities'] = $data['cities']->paginate(10);

        return view('livewire.dashboard.admin.cities', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId != 1) {
            City::where('id', $this->deleteId)->delete();
            CityTranslation::where('city_id', $this->deleteId)->delete();
        }
        $this->emit('CityAdded');
    }

    public function deleteConfirm($CityID)
    {
        City::where('id', $CityID)->delete();
        $this->emit('CityAdded');
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
