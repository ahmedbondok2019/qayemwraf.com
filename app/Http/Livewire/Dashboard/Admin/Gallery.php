<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Gallery as ModelsGallery;
use App\Models\GalleryImage;
use App\Models\GalleryTranslation;
use App\Models\GalleryVideo;
use Livewire\Component;
use Livewire\WithPagination;

class Gallery extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['galleryAll' => '$refresh'];

    public $search = '';

    public function render()
    {
        $IDS = GalleryTranslation::whereLike('gallery_name', $this->search ?? '')->pluck('gallery_id');
        $data['galleries'] = ModelsGallery::whereHas('GalleryTranslation')->whereIn('id', $IDS)
            ->orderByDesc('id')->paginate(25);

        return view('livewire.dashboard.admin.gallery', $data);
    }

    public function deleteConfirm($galleryID)
    {
        ModelsGallery::where('id', $galleryID)->delete();
        GalleryTranslation::where('gallery_id', $galleryID)->delete();
        GalleryImage::where('gallery_id', $galleryID)->delete();
        GalleryVideo::where('gallery_id', $galleryID)->delete();

        session()->flash('message', __('website.deleted successfully..'));
        $this->emit('galleryAll');
    }
}
