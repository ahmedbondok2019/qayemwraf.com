<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Team as ModelsTeam;
use App\Models\TeamImage;
use App\Models\TeamTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Team extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['teamAdded' => '$refresh'];

    public $teamID;

    public $search = '';

    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage('commentsPage');
    }

    public function render()
    {
        if (! in_array('25', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $IDS = TeamTranslation::whereLike('team_name', $this->search ?? '')->pluck('team_id');
        $teams = ModelsTeam::whereHas('TeamTranslation')->whereIn('id', $IDS)->orderByDesc('id')->paginate(10);

        return view('livewire.dashboard.admin.team', [
            'teams' => $teams,
        ]);
    }

    public function deleteConfirm($teamID)
    {
        if (! in_array('28', Session::get('permissionData'))) {
            return redirect()->back();
        }

        ModelsTeam::where('id', $teamID)->delete();
        TeamTranslation::where('team_id', $teamID)->delete();
        TeamImage::where('team_id', $teamID)->delete();

        session()->flash('message', __('dashboard.deleted successfully'));
        $this->emit('teamAdded');
    }
}
