<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\CountryTranslation;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::with('translation')->orderBy('sort_order')->get();
        return view('dashboard.admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
            'code' => 'nullable|string|max:10',
            'phone_code' => 'nullable|string|max:10',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
            'code' => $request->code,
            'phone_code' => $request->phone_code,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/countries'), $imageName);
            $data['image'] = 'website/images/countries/' . $imageName;
        }

        $country = Country::create($data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            CountryTranslation::create([
                'country_id' => $country->id,
                'locale' => $localeCode,
                'name' => $request->input("name_$localeCode"),
            ]);
        }

        return redirect()->route('admin.countries.index')->with('success', trans_db('dashboard.Product added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('dashboard.admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
            'code' => 'nullable|string|max:10',
            'phone_code' => 'nullable|string|max:10',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
            'code' => $request->code,
            'phone_code' => $request->phone_code,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($country->image && file_exists(public_path($country->image))) {
                unlink(public_path($country->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/countries'), $imageName);
            $data['image'] = 'website/images/countries/' . $imageName;
        }

        $country->update($data);

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = CountryTranslation::where('country_id', $country->id)->where('locale', $localeCode)->first();
            
            $transData = [
                'name' => $request->input("name_$localeCode"),
            ];

             if ($translation) {
                $translation->update($transData);
            } else {
                $transData['country_id'] = $country->id;
                $transData['locale'] = $localeCode;
                CountryTranslation::create($transData);
            }
        }

        return redirect()->route('admin.countries.index')->with('success', trans_db('dashboard.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
         if ($country->image && file_exists(public_path($country->image))) {
            unlink(public_path($country->image));
        }
        $country->delete(); // Or forceDelete if soft deletes not used, I used standard model but let's check. Assuming standard delete is fine.
        return redirect()->route('admin.countries.index')->with('success', trans_db('dashboard.deleted successfully'));
    }
}
