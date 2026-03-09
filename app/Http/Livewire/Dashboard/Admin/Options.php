<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Option;
use App\Models\OptionTranslation;
use App\Models\ProductOption;
use Livewire\Component;
use Livewire\WithPagination;

class Options extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['optionsAll' => '$refresh'];

    public $search = '';

    public $deleteId = '';

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
        $IDS = OptionTranslation::whereLike('title', $this->search ?? '')->pluck('option_id');

        $data['options'] = Option::whereHas('translations')->whereIn('id', $IDS);
        if ($this->sortBy == 'id') {
            $data['options'] = $data['options']->orderBy('id', $this->sortDirection);
        } elseif ($this->sortBy == 'title') {
            $data['options'] = $data['options']->join('option_translations', 'options.id', 'option_translations.option_id')
                ->where('option_translations.lang_id', app()->getLocale())
                ->select('options.*')
                ->orderBy('option_translations.title', $this->sortDirection);
        } else {
            $data['options'] = $data['options']->orderByDesc('id');
        }
        $data['options'] = $data['options']->paginate(10);

        return view('livewire.dashboard.admin.options', $data);
    }

    public function deleteId($optionID)
    {
        $this->deleteId = $optionID;
    }

    public function delete()
    {
        // $usedOptions = ProductOption::where('option_id', $this->deleteId)->count();
        // if($usedOptions > 0){
        //     session()->flash( 'message', __("dashboard.error in delete"));
        // }else{
        Option::where('id', $this->deleteId)->delete();
        OptionTranslation::where('option_id', $this->deleteId)->delete();
        ProductOption::where('option_id', $this->deleteId)->delete();
        session()->flash('message', __('website.deleted successfully'));
        // }

        $this->emit('optionsAll');
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function deleteConfirm($optionID)
    {
        $usedOptions = ProductOption::where('option_id', $optionID)->count();
        if ($usedOptions > 0) {
            session()->flash('message', __('dashboard.error in delete'));
        } else {
            Option::where('id', $optionID)->delete();
            OptionTranslation::where('option_id', $optionID)->delete();
            session()->flash('message', __('website.deleted successfully'));
        }

        $this->emit('optionsAll');
    }
}
