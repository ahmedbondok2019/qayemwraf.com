<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with('translation')->orderBy('sort_order')->get();
        return view('dashboard.admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'required|string|max:255';
            $rules["content_$localeCode"] = 'required';
        }

        $request->validate($rules);

        $data = [
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/pages'), $imageName);
            $data['image'] = 'website/images/pages/' . $imageName;
        }

        $page = Page::create($data);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            PageTranslation::create([
                'page_id' => $page->id,
                'locale' => $localeCode,
                'title' => $request->input("title_$localeCode"),
                'content' => $request->input("content_$localeCode"),
                'slug' => Str::slug($request->input("title_en") . '-' . $localeCode), // Simple slug gen
                'meta_title' => $request->input("meta_title_$localeCode"),
                'meta_description' => $request->input("meta_description_$localeCode"),
                'meta_keywords' => $request->input("meta_keywords_$localeCode"),
            ]);
        }

        return redirect()->route('admin.pages.index')->with('success', trans_db('dashboard.Product added successfully')); // Reusing existing message
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('dashboard.admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'required|string|max:255';
            $rules["content_$localeCode"] = 'required';
        }

        $request->validate($rules);

        $data = [
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($page->image && file_exists(public_path($page->image))) {
                unlink(public_path($page->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/pages'), $imageName);
            $data['image'] = 'website/images/pages/' . $imageName;
        }

        $page->update($data);

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = PageTranslation::where('page_id', $page->id)->where('locale', $localeCode)->first();
            
            $transData = [
                'title' => $request->input("title_$localeCode"),
                'content' => $request->input("content_$localeCode"),
                // Keep existing slug or update, let's keep it simple for now, maybe update provided slug?
                // 'slug' => ... 
                'meta_title' => $request->input("meta_title_$localeCode"),
                'meta_description' => $request->input("meta_description_$localeCode"),
                'meta_keywords' => $request->input("meta_keywords_$localeCode"),
            ];

             if ($translation) {
                $translation->update($transData);
            } else {
                $transData['page_id'] = $page->id;
                $transData['locale'] = $localeCode;
                $transData['slug'] = Str::slug($request->input("title_$localeCode") . '-' . $localeCode);
                PageTranslation::create($transData);
            }
        }

        return redirect()->route('admin.pages.index')->with('success', trans_db('dashboard.Product updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
         if ($page->image && file_exists(public_path($page->image))) {
            unlink(public_path($page->image));
        }
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', trans_db('dashboard.deleted successfully'));
    }
}
