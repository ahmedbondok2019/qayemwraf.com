<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with(['translation', 'governorate.translation'])->orderBy('sort_order')->get();
        return view('dashboard.admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $governorates = Governorate::active()->get();
        return view('dashboard.admin.cities.create', compact('governorates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'governorate_id' => 'required|exists:governorates,id',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'governorate_id' => $request->governorate_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $city = City::create($data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            CityTranslation::create([
                'city_id' => $city->id,
                'locale' => $localeCode,
                'name' => $request->input("name_$localeCode"),
            ]);
        }

        return redirect()->route('admin.cities.index')->with('success', trans_db('dashboard.Product added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $governorates = Governorate::active()->get();
        return view('dashboard.admin.cities.edit', compact('city', 'governorates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $rules = [
            'governorate_id' => 'required|exists:governorates,id',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'governorate_id' => $request->governorate_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $city->update($data);

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = CityTranslation::where('city_id', $city->id)->where('locale', $localeCode)->first();
            
            $transData = [
                'name' => $request->input("name_$localeCode"),
            ];

             if ($translation) {
                $translation->update($transData);
            } else {
                $transData['city_id'] = $city->id;
                $transData['locale'] = $localeCode;
                CityTranslation::create($transData);
            }
        }

        return redirect()->route('admin.cities.index')->with('success', trans_db('dashboard.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', trans_db('dashboard.deleted successfully'));
    }
}
