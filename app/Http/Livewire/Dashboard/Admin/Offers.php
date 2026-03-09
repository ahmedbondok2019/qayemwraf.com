<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Offers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $offerID;

    public $title;

    public $image;

    protected $listeners = ['offerAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:offer_translations,title,deleted_at,id',
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

    public function render()
    {
        if (! in_array('33', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['offers'] = Offer::whereHas('offer_translations')->whereNull('static')->orderByDesc('id')->paginate(25);
        $data['categories'] = Category::whereHas('CategoryTranslation')->orderByDesc('id')->get();

        return view('livewire.dashboard.admin.offers', $data);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Offer::where('id', $this->deleteId)->delete();
        OfferTranslation::where('offer_id', $this->deleteId)->delete();
        $this->emit('offerAdded');
    }

    public function deleteConfirm($offerID)
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Offer::where('id', $this->deleteId)->delete();
        OfferTranslation::where('offer_id', $this->deleteId)->delete();
        $this->emit('offerAdded');
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
