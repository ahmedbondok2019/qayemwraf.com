<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Faq as ModelsFaq;
use App\Models\FaqTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['FaqAdded' => '$refresh'];

    public $FaqID;

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
        if (! in_array('103', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $IDS = FaqTranslation::whereLike('title', $this->search ?? '')->pluck('faq_id');
        $faqs = ModelsFaq::whereHas('FaqTranslation')->whereIn('id', $IDS)->orderByDesc('id')->paginate(10);

        return view('livewire.dashboard.admin.faqs', [
            'faqs' => $faqs,
        ]);
    }

    public function deleteConfirm($FaqID)
    {
        if (! in_array('106', Session::get('permissionData'))) {
            return redirect()->back();
        }

        ModelsFaq::where('id', $FaqID)->delete();
        FaqTranslation::where('faq_id', $FaqID)->delete();

        session()->flash('message', __('dashboard.deleted successfully'));
        $this->emit('FaqAdded');
    }
}
