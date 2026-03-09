<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('translation', 'parent')->latest()->paginate(10);
        return view('dashboard.admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('translation')->whereNull('parent_id')->get();
        return view('dashboard.admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            // Add validation for translations if needed
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/category'), $imageName);
            $imagePath = $imageName;
        }

        $category = Category::create([
            'parent_id' => $request->parent_id,
            'image' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $title = $request->input("title_$localeCode");
            if ($title) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale' => $localeCode,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => $request->input("description_$localeCode"),
                    'meta_title' => $request->input("meta_title_$localeCode"),
                    'meta_description' => $request->input("meta_description_$localeCode"),
                    'meta_keywords' => $request->input("meta_keywords_$localeCode"),
                ]);
            }
        }

        return redirect()->route('admin.categories.index')->with('success', trans_db('dashboard.Category added successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::with('translation')->whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('dashboard.admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('website/images/category/' . $category->image))) {
                unlink(public_path('website/images/category/' . $category->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('website/images/category'), $imageName);
            $category->image = $imageName;
        }

        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order ?? 0;
        $category->is_active = $request->has('is_active') ? 1 : 0;
        $category->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $title = $request->input("title_$localeCode");
            
            CategoryTranslation::updateOrCreate(
                ['category_id' => $category->id, 'locale' => $localeCode],
                [
                    'title' => $title,
                    'slug' => Str::slug($title ?? ''),
                    'description' => $request->input("description_$localeCode"),
                    'meta_title' => $request->input("meta_title_$localeCode"),
                    'meta_description' => $request->input("meta_description_$localeCode"),
                    'meta_keywords' => $request->input("meta_keywords_$localeCode"),
                ]
            );
        }

        return redirect()->route('admin.categories.index')->with('success', trans_db('dashboard.Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path('website/images/category/' . $category->image))) {
            unlink(public_path('website/images/category/' . $category->image));
        }
        
        $category->translations()->delete();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', trans_db('dashboard.Category deleted successfully.'));
    }
}
