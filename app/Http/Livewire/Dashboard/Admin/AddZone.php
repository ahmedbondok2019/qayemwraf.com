<?php

namespace App\Http\Livewire\Dashboard\Admin;

use App\Models\Area;
use App\Models\City;
use App\Models\Zone;
use App\Models\ZoneTranslation;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddZone extends Component
{
    public $ZoneID;

    public $title;

    public $zone;

    public $area_id;

    public $city_id;

    public $cities = [];

    protected $listeners = ['ZoneAdded' => '$refresh'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'city_id' => 'required|string|max:100',
        'area_id' => 'required|string|max:100',
    ];

    protected $messages = [
        'title.required' => 'Required Field',
        'title.string' => 'String Field',
        'title.unique' => 'لا يجب تكرار الاسم',
    ];

    public function render()
    {
        $data['areas'] = Area::whereHas('translations')->get();
        if ($this->area_id != null) {
            $data['cities'] = City::whereHas('translations')->where('parent_id', $this->area_id)->get();
            $this->cities = $data['cities'];
        }

        // dd($data);
        return view('livewire.dashboard.admin.add-zone', $data);
    }

    public function createZone()
    {
        if (! in_array('122', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $this->validate();
        $withoutTrashed = ZoneTranslation::where('title', $this->title)->where('lang_id', app()->getLocale())
            ->withoutTrashed()->exists();

        if (! $withoutTrashed) {
            self::store($this->title, $this->area_id, $this->city_id);
        }

        session()->flash('message', 'Zone successfully Created.');

        $this->title = '';
        $this->zone = '';
        $this->emit('ZoneAdded');

        $this->reset(['title', 'zone']);

    }

    public static function store($title, $area_id, $city_id)
    {
        $CreateZone = Zone::create([
            'lang_id' => app()->getLocale(),
            'area_id' => $area_id,
            'parent_id' => $city_id,
        ]);

        ZoneTranslation::create([
            'title' => strip_tags($title),
            'parent_id' => $city_id,
            'zone_id' => $CreateZone->id,
            'lang_id' => app()->getLocale(),
        ]);
    }

    public function mount()
    {
        if ($this->area_id != '') {
            $this->cities = City::where('parent_id', $this->area_id)->get();
        }
    }

    public function updatedAreaId()
    {
        $this->cities = City::where('parent_id', $this->area_id)->get();
    }
}
