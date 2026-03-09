<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Review as ModelsReview;
use App\Models\ReviewTranslation;
use Livewire\Component;
use Livewire\WithPagination;

class Review extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['reviewAll' => '$refresh'];

    public $search = '';

    public function render()
    {
        $IDS = ReviewTranslation::whereLike('title', $this->search ?? '')->pluck('review_id');
        $data['Reviews'] = ModelsReview::whereHas('ReviewTranslation')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.review', $data);
    }

    public function deleteConfirm($galleryID)
    {
        ModelsReview::where('id', $galleryID)->delete();
        ReviewTranslation::where('review_id', $galleryID)->delete();

        session()->flash('message', __('website.deleted successfully..'));
        $this->emit('reviewAll');
    }
}
