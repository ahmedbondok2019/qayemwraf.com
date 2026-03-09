<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Zone;
use App\Models\ZoneTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Zones extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ZoneID;

    public $title;

    protected $listeners = ['ZoneAdded' => '$refresh'];

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
        if (! in_array('121', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['zones'] = Zone::whereHas('translations');
        if ($this->sortBy == 'id') {
            $data['zones'] = $data['zones']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['zones'] = $data['zones']->join('zone_translations', 'zones.id', 'zone_translations.zone_id')
                ->where('zone_translations.lang_id', app()->getLocale())
                ->select('zones.*')
                ->orderBy('zone_translations.title', $this->sortDirection);
        } else {
            $data['zones'] = $data['zones']->orderByDesc('id');
        }
        $data['zones'] = $data['zones']->paginate(10);

        return view('livewire.dashboard.admin.zones', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('124', Session::get('permissionData'))) {
            return redirect()->back();
        }
        if ($this->deleteId != 1) {
            Zone::where('id', $this->deleteId)->delete();
            ZoneTranslation::where('zone_id', $this->deleteId)->delete();
        }
        $this->emit('ZoneAdded');
    }

    public function deleteConfirm($ZoneID)
    {
        if (! in_array('124', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Zone::where('id', $ZoneID)->delete();
        $this->emit('ZoneAdded');
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
