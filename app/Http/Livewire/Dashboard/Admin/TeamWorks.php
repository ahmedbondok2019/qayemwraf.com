<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\TeamWork;
use App\Models\TeamWorkImage;
use App\Models\TeamWorkTranslation;
use Livewire\Component;
use Livewire\WithPagination;

class TeamWorks extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['team_workAdded' => '$refresh'];

    public $team_workID;

    public $deleteId;

    public $price;

    public $sale_price;

    public $select = [];

    public $multi_status;

    public $category_id;

    public $search = '';

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

    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $IDS = TeamWorkTranslation::whereLike('title', $this->search ?? '');
        $IDS = $IDS->orwhere('team_work_id', $this->search ?? '')
            ->pluck('team_work_id');

        $team_works = TeamWork::whereHas('translations');
        if ($this->sortBy == 'id') {
            $team_works = $team_works->whereIn('id', $IDS)->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $team_works = $team_works->join('team_work_translations', 'team_works.id', 'team_work_translations.team_work_id')
                ->select('team_works.*')
                ->whereIn('team_works.id', $IDS)
                ->orderBy('team_work_translations.title', $this->sortDirection);
        } elseif ($this->sortBy == 'status') {
            $team_works = $team_works->whereIn('id', $IDS)->orderBy('status', $this->sortDirection);
        } else {
            $team_works = $team_works->orderByDesc('id');
        }
        $team_works = $team_works->paginate(10);

        return view('livewire.dashboard.admin.team-works', [
            'team_works' => $team_works,
        ]);
    }

    public function deleteConfirm($team_workID)
    {
        if (! in_array('145', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }
        TeamWork::where('id', $team_workID)->delete();
        TeamWorkTranslation::where('team_work_id', $team_workID)->delete();
        $team_workImage = TeamWorkImage::where('team_work_id', (string) $team_workID)->get();
        if ($team_workImage) {
            TeamWorkImage::where('team_work_id', $team_workID)->delete();
        }

        session()->flash('message', __('dashboard.deleted successfully'));
        $this->emit('team_workAdded');
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('145', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }

        TeamWork::where('id', $this->deleteId)->delete();
        TeamWorkTranslation::where('team_work_id', $this->deleteId)->delete();
        TeamWorkImage::where('team_work_id', (string) $this->deleteId)->delete();

        session()->flash('message', __('dashboard.deleted successfully'));

        $this->emit('team_workAdded');
    }

    public function multiStatus()
    {
        if (! in_array('144', \Illuminate\Support\Facades\Session::get('permissionData'))) {
            return redirect()->back();
        }

        if (! empty($this->select)) {
            TeamWork::whereIn('id', $this->select)->update([
                'status' => $this->multi_status,
            ]);
        }

        $this->emit('team_workAdded');
    }

    public function closeModal()
    {
        $this->resetInput();
    }
}
