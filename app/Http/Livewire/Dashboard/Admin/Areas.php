<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Area as ModelsArea;
use App\Models\AreaTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Areas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $areaID;

    public $title;

    protected $listeners = ['areaAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:area_translations,title,deleted_at,id',
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

        $data['areas'] = ModelsArea::whereHas('translations');
        if ($this->sortBy == 'id') {
            $data['areas'] = $data['areas']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['areas'] = $data['areas']->join('area_translations', 'areas.id', 'area_translations.area_id')
                ->where('area_translations.lang_id', app()->getLocale())
                ->select('areas.*')
                ->orderBy('area_translations.title', $this->sortDirection);
        } else {
            $data['areas'] = $data['areas']->orderByDesc('id');
        }
        $data['areas'] = $data['areas']->paginate(10);

        return view('livewire.dashboard.admin.areas', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId != 1) {
            ModelsArea::where('id', $this->deleteId)->delete();
            AreaTranslation::where('area_id', $this->deleteId)->delete();
        }
        $this->emit('areaAdded');
    }

    public function deleteConfirm($areaID)
    {
        ModelsArea::where('id', $areaID)->delete();
        $this->emit('areaAdded');
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
