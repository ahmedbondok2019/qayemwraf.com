<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferTranslation;
use App\Models\Category;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with(['translation', 'category.translations'])->orderBy('sort_order')->get();
        return view('dashboard.admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Assuming Category translates via separate table or similar pattern
        $categories = Category::with('translations')->get(); 
        return view('dashboard.admin.offers.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
            // Slug can be auto-generated if not provided, usually
        }

        $request->validate($rules);

        $data = [
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->extension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'offers';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $imageName);
            $data['image'] = 'storage/website/images/offers/' . $imageName;
        }

        $offer = Offer::create($data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
             $name = $request->input("name_$localeCode");
             // Generate slug if not provided? Or just from name.
             // Usually slugs should be unique.
             $slug = Str::slug($name);
             
             // Ensure uniqueness
             $count = OfferTranslation::where('slug', $slug)->count();
             if ($count > 0) {
                 $slug .= '-' . time();
             }

            OfferTranslation::create([
                'offer_id' => $offer->id,
                'locale' => $localeCode,
                'name' => $name,
                'slug' => $slug,
            ]);
        }

        return redirect()->route('admin.offers.index')->with('success', trans_db('dashboard.Product added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        return view('dashboard.admin.offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $categories = Category::with('translations')->get();
        return view('dashboard.admin.offers.edit', compact('offer', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        $rules = [
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["name_$localeCode"] = 'required|string|max:255';
        }

        $request->validate($rules);

        $data = [
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($offer->image) {
                $oldPath = str_replace('storage/', '', $offer->image);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($offer->image))) {
                    unlink(public_path($offer->image));
                } elseif (file_exists(public_path('website/images/offers/' . $offer->image))) {
                    unlink(public_path('website/images/offers/' . $offer->image));
                }
            }

            $file = $request->file('image');
            $imageName = time() . '.' . $file->extension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'offers';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $imageName);
            $data['image'] = 'storage/website/images/offers/' . $imageName;
        }

        $offer->update($data);

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = OfferTranslation::where('offer_id', $offer->id)->where('locale', $localeCode)->first();
            
            $name = $request->input("name_$localeCode");
            $transData = [
                'name' => $name,
            ];

             if ($translation) {
                 // Should we update slug? usually no unless explicitly asked, or if it changed?
                 // For now let's keep slug as is or update if needed. 
                 // If we update name, good practice to update slug ?? debatable.
                 // Often better not to break old links.
                 $translation->update($transData);
            } else {
                $slug = Str::slug($name);
                $count = OfferTranslation::where('slug', $slug)->count();
                if ($count > 0) {
                     $slug .= '-' . time();
                }

                $transData['offer_id'] = $offer->id;
                $transData['locale'] = $localeCode;
                $transData['slug'] = $slug;
                OfferTranslation::create($transData);
            }
        }

        return redirect()->route('admin.offers.index')->with('success', trans_db('dashboard.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        if ($offer->image) {
            $oldPath = str_replace('storage/', '', $offer->image);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            } elseif (file_exists(public_path($offer->image))) {
                unlink(public_path($offer->image));
            } elseif (file_exists(public_path('website/images/offers/' . $offer->image))) {
                unlink(public_path('website/images/offers/' . $offer->image));
            }
        }
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', trans_db('dashboard.deleted successfully'));
    }
}
