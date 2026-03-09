<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Blog as ModelsBlog;
use App\Models\BlogTranslation;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['blogAll' => '$refresh'];

    public $search = '';

    public function render()
    {
        $IDS = BlogTranslation::whereLike('title', $this->search ?? '')->pluck('blog_id');
        $data['blogs'] = ModelsBlog::whereHas('BlogTranslation')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.blog', $data);
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function updatingSearch()
    {
        $this->resetPage('commentsPage');
    }

    public function deleteConfirm($productID)
    {
        ModelsBlog::where('id', $productID)->delete();
        BlogTranslation::where('blog_id', $productID)->delete();

        session()->flash('message', __('dashboard.deleted successfully'));
        $this->emit('blogAll');
    }
}
