<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Area;
use App\Models\City;
use App\Models\CityTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddCity extends Component
{
    public $CityID;

    public $title;

    public $area;

    protected $listeners = ['CityAdded' => '$refresh'];

    protected $rules = [
        // 'title' => 'required|string|max:255|unique:City_translations,title,deleted_at,id',
        'title' => 'required|string|max:255',
        'area' => 'required|string|max:100',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        $data['areas'] = Area::whereHas('translations')->get();

        return view('livewire.dashboard.admin.add-city', $data);
    }

    public function createCity()
    {
        if (! in_array('18', Session::get('permissionData'))) {
            return redirect()->back();
        }

        // dd($this->area);
        $this->validate();
        $withoutTrashed = CityTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            self::store($this->title, $this->area);
        }

        session()->flash('message', 'City successfully Created.');

        $this->title = '';
        $this->area = '';
        $this->emit('CityAdded');

        $this->reset(['title', 'area']);

    }

    public static function store($title, $area)
    {
        $CreateCity = City::create([
            'lang_id' => app()->getLocale(),
            'parent_id' => $area,
        ]);

        CityTranslation::create([
            'title' => strip_tags($title),
            'parent_id' => $area,
            'city_id' => $CreateCity->id,
            'lang_id' => app()->getLocale(),
        ]);
    }
}
