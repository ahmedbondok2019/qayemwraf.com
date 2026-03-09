<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\GovernorateTranslation;
use App\Models\Country;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $governorates = Governorate::with(['translation', 'country.translation'])->orderBy('sort_order')->get();
        return view('dashboard.admin.governorates.index', compact('governorates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::active()->get();
        return view('dashboard.admin.governorates.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'country_id' => $request->country_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $governorate = Governorate::create($data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            GovernorateTranslation::create([
                'governorate_id' => $governorate->id,
                'locale' => $localeCode,
                'name' => $request->input("name_$localeCode"),
            ]);
        }

        return redirect()->route('admin.governorates.index')->with('success', trans_db('dashboard.Product added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Governorate $governorate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Governorate $governorate)
    {
        $countries = Country::active()->get();
        return view('dashboard.admin.governorates.edit', compact('governorate', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Governorate $governorate)
    {
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'country_id' => $request->country_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $governorate->update($data);

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = GovernorateTranslation::where('governorate_id', $governorate->id)->where('locale', $localeCode)->first();
            
            $transData = [
                'name' => $request->input("name_$localeCode"),
            ];

             if ($translation) {
                $translation->update($transData);
            } else {
                $transData['governorate_id'] = $governorate->id;
                $transData['locale'] = $localeCode;
                GovernorateTranslation::create($transData);
            }
        }

        return redirect()->route('admin.governorates.index')->with('success', trans_db('dashboard.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->route('admin.governorates.index')->with('success', trans_db('dashboard.deleted successfully'));
    }
}
