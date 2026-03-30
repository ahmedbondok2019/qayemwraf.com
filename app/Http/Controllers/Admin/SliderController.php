<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use App\Models\SliderTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::with('translations', 'category')->orderBy('sort_order')->get();
        return view('dashboard.admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get categories that have translations
        $categories = Category::with('translation')->whereHas('translations')->get();
        return view('dashboard.admin.sliders.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'nullable|string|max:255';
            $rules["subtitle_$localeCode"] = 'nullable|string|max:255';
            $rules["button_text_$localeCode"] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $slider = new Slider();
        $slider->category_id = $request->category_id;
        $slider->link = $request->link;
        $slider->sort_order = $request->sort_order ?? 0;
        $slider->is_active = $request->has('is_active') ? true : false; // Handle checkbox

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->extension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'sliders';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $imageName);
            $slider->image = 'storage/website/images/sliders/' . $imageName;
        }

        $slider->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            SliderTranslation::create([
                'slider_id' => $slider->id,
                'locale' => $localeCode,
                'title' => $request->input("title_$localeCode"),
                'subtitle' => $request->input("subtitle_$localeCode"),
                'button_text' => $request->input("button_text_$localeCode"),
            ]);
        }

        return redirect()->route('admin.sliders.index')->with('success', trans_db('dashboard.saved'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $categories = Category::with('translation')->whereHas('translations')->get();
        return view('dashboard.admin.sliders.edit', compact('slider', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["title_$localeCode"] = 'nullable|string|max:255';
            $rules["subtitle_$localeCode"] = 'nullable|string|max:255';
            $rules["button_text_$localeCode"] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $slider->category_id = $request->category_id;
        $slider->link = $request->link;
        $slider->sort_order = $request->sort_order ?? $slider->sort_order;
        $slider->is_active = $request->has('is_active') ? true : false;
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image) {
                $oldPath = str_replace('storage/', '', $slider->image);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                } elseif (file_exists(public_path('website/images/sliders/' . $slider->image))) {
                    unlink(public_path('website/images/sliders/' . $slider->image));
                }
            }
            
            $file = $request->file('image');
            $imageName = time() . '.' . $file->extension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'sliders';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $imageName);
            $slider->image = 'storage/website/images/sliders/' . $imageName;
        }

        $slider->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $translation = SliderTranslation::where('slider_id', $slider->id)->where('locale', $localeCode)->first();
            $data = [
                'title' => $request->input("title_$localeCode"),
                'subtitle' => $request->input("subtitle_$localeCode"),
                'button_text' => $request->input("button_text_$localeCode"),
            ];

            if ($translation) {
                $translation->update($data);
            } else {
                $data['slider_id'] = $slider->id;
                $data['locale'] = $localeCode;
                SliderTranslation::create($data);
            }
        }

        return redirect()->route('admin.sliders.index')->with('success', trans_db('dashboard.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            $oldPath = str_replace('storage/', '', $slider->image);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            } elseif (file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            } elseif (file_exists(public_path('website/images/sliders/' . $slider->image))) {
                unlink(public_path('website/images/sliders/' . $slider->image));
            }
        }
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', trans_db('dashboard.deleted'));
    }
}
