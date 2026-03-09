<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementTranslation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::with('translation', 'translations')->latest()->get();
        return view('dashboard.admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        $categories = Category::with('translation')->whereNull('parent_id')->get();
        return view('dashboard.admin.advertisements.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|in:home,category,popup',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $advertisement = Advertisement::create([
                'location' => $request->location,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_active' => $request->has('is_active'),
            ]);

            // Upload Image
            $path = '';
            if ($request->hasFile('image')) {
                 $path = $request->file('image')->store('advertisements', 'public');
            }

            // Save Translations
            foreach (['en', 'ar'] as $locale) {
                AdvertisementTranslation::create([
                    'advertisement_id' => $advertisement->id,
                    'locale' => $locale,
                    'title' => $request->input("title_$locale"),
                    'link' => $request->input("link_$locale"),
                    'image' => $path, // Using same image for MVP
                ]);
            }

            DB::commit();
            return redirect()->route('admin.advertisements.index')->with('success', trans_db('dashboard.saved'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Advertisement $advertisement)
    {
        $categories = Category::with('translation')->whereNull('parent_id')->get();
        return view('dashboard.admin.advertisements.edit', compact('advertisement', 'categories'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
         $request->validate([
            'location' => 'required|in:home,category,popup',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $advertisement->update([
                'location' => $request->location,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_active' => $request->has('is_active'),
            ]);

            // Handle Image Upload
            if ($request->hasFile('image')) {
                 $path = $request->file('image')->store('advertisements', 'public');
                 // Update all translations with new image
                 $advertisement->translations()->update(['image' => $path]);
            }

            // Update Translations
            foreach (['en', 'ar'] as $locale) {
                $translation = $advertisement->translations()->where('locale', $locale)->first();
                if ($translation) {
                    $translation->update([
                        'title' => $request->input("title_$locale"),
                        'link' => $request->input("link_$locale"),
                    ]);
                } else {
                    // Create if missing
                     AdvertisementTranslation::create([
                        'advertisement_id' => $advertisement->id,
                        'locale' => $locale,
                        'title' => $request->input("title_$locale"),
                        'link' => $request->input("link_$locale"),
                        'image' => $advertisement->translations->first()->image ?? '',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.advertisements.index')->with('success', trans_db('dashboard.updated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();
        return redirect()->route('admin.advertisements.index')->with('success', trans_db('dashboard.deleted'));
    }
}
