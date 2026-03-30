<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use App\Models\ProductBrandTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\UploadImageTrait;

class ProductBrandController extends Controller
{
    use UploadImageTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductBrand::with('translation')->select('product_brands.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('image', function ($row) {
                     if ($row->image) {
                        // $path = str_contains($row->image, 'uploads/') ? $row->image : 'website/images/brand/' . $row->image;
                        return '<img src="' . asset($row->image) . '" border="0" width="50" class="img-rounded" align="center" />';
                    }
                    return '';
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active 
                        ? '<span class="badge badge-success">' . trans_db('dashboard.active') . '</span>' 
                        : '<span class="badge badge-danger">' . trans_db('dashboard.inactive') . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="' . route('admin.product_brands.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteItem(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.product_brands.index');
    }

    public function create()
    {
        return view('dashboard.admin.product_brands.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["$localeCode.title"] = 'required|string|max:255';
        }

        $validatedData = $request->validate($rules);

        $brand = new ProductBrand();
        $brand->is_active = $request->has('is_active');
        $brand->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $brand->image = $this->uploadImage($request->file('image'), 'brand');
        }

        $brand->save();

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ProductBrandTranslation::create([
                'product_brand_id' => $brand->id,
                'locale' => $localeCode,
                'title' => $validatedData[$localeCode]['title'],
            ]);
        }

        return redirect()->route('admin.product_brands.index')->with('success', trans_db('dashboard.created_successfully'));
    }

    public function edit($id)
    {
        $brand = ProductBrand::with('translations')->findOrFail($id);
        return view('dashboard.admin.product_brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = ProductBrand::findOrFail($id);

        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $rules["$localeCode.title"] = 'required|string|max:255';
        }

        $validatedData = $request->validate($rules);

        $brand->is_active = $request->has('is_active');
        $brand->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($brand->image) {
                $oldPath = str_replace('storage/', '', $brand->image);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($brand->image))) {
                    unlink(public_path($brand->image));
                } elseif (file_exists(public_path('website/images/brand/' . $brand->image))) {
                    unlink(public_path('website/images/brand/' . $brand->image));
                }
            }

            $brand->image = $this->uploadImage($request->file('image'), 'brand');
        }

        $brand->save();

        // Update translations
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            ProductBrandTranslation::updateOrCreate(
                ['product_brand_id' => $brand->id, 'locale' => $localeCode],
                ['title' => $validatedData[$localeCode]['title']]
            );
        }

        return redirect()->route('admin.product_brands.index')->with('success', trans_db('dashboard.updated_successfully'));
    }

    public function destroy($id)
    {
        $brand = ProductBrand::findOrFail($id);
        
        // Optionally delete image file, but usually kept if soft delete, or deleted if force delete.
        // For soft delete, we just delete the record.
        
        $brand->delete();

        return response()->json(['success' => trans_db('dashboard.deleted_successfully')]);
    }
}
