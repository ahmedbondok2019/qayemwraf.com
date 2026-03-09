<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Page as ModelsPage;
use App\Models\PageTranslation;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['pageAll' => '$refresh'];

    public $search = '';

    public function render()
    {
        $IDS = PageTranslation::whereLike('title', $this->search ?? '')->pluck('page_id');
        $data['Pages'] = ModelsPage::whereHas('PageTranslation')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.page', $data);
    }

    public function changeStatus($pageID, $status)
    {
        ModelsPage::where('id', $pageID)->update(['status' => $status]);

        session()->flash('message', __('dashboard.updated'));
        $this->emit('pageAll');
    }

    public function deleteConfirm($pageID)
    {
        ModelsPage::where('id', $pageID)->delete();
        PageTranslation::where('page_id', $pageID)->delete();

        session()->flash('message', __('website.deleted successfully..'));
        $this->emit('pageAll');
    }
}
