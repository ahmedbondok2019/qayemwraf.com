<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Area;
use App\Models\AreaTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddArea extends Component
{
    public $areaID;

    public $title;

    protected $listeners = ['areaAdded' => '$refresh'];

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:area_translations,title,deleted_at,id',
        'title' => 'required|string|max:255',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        return view('livewire.dashboard.admin.add-area');
    }

    public function createArea()
    {
        if (! in_array('22', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $onlyTrashed = AreaTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->onlyTrashed()->exists();
        $withoutTrashed = AreaTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        // dd($onlyTrashed . '-' . $withoutTrashed);
        if (! $withoutTrashed) {
            self::store($this->title);
        }

        session()->flash('message', 'Area successfully Created.');

        $this->title = '';
        $this->emit('areaAdded');

        $this->reset(['title']);

    }

    public static function store($title)
    {
        $CreateArea = Area::create([
            'lang_id' => app()->getLocale(),
        ]);

        AreaTranslation::create([
            'title' => strip_tags($title),
            'area_id' => $CreateArea->id,
            'lang_id' => app()->getLocale(),
        ]);
    }
}
