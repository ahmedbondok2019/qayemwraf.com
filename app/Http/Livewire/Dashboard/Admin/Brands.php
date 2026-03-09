<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Brand;
use App\Models\BrandTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $brandID;

    public $title;

    public $image;

    protected $listeners = ['brandAdded' => '$refresh'];

    public $deleteId = '';

    protected $rules = [
        'title' => 'required|string|max:255|unique:brand_translations,title,deleted_at,id',
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
        if (! in_array('33', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data['brands'] = Brand::query();
        if ($this->sortBy == 'id') {
            $data['brands'] = $data['brands']->whereHas('BrandTranslations')->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['brands'] = $data['brands']->join('brand_translations', 'brands.id', 'brand_translations.brand_id')
                ->select('brands.*')
                ->where('brand_translations.lang_id', app()->getLocale())
                ->orderBy('brand_translations.title', $this->sortDirection);
        } else {
            $data['brands'] = $data['brands']->whereHas('BrandTranslations')->orderByDesc('id');
        }
        $data['brands'] = $data['brands']->paginate(10);

        return view('livewire.dashboard.admin.brands', $data);
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
        Brand::where('id', $this->deleteId)->delete();
        BrandTranslation::where('brand_id', $this->deleteId)->delete();
        $this->emit('brandAdded');
    }

    public function deleteConfirm($brandID)
    {
        if (! in_array('36', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Brand::where('id', $this->deleteId)->delete();
        BrandTranslation::where('brand_id', $this->deleteId)->delete();
        $this->emit('brandAdded');
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
