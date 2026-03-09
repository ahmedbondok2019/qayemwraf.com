<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleTranslation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\DataTables\Facades\DataTables;

class FlashSaleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FlashSale::with('translation')->select('flash_sales.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('duration', function ($row) {
                    return $row->start_at->format('Y-m-d H:i') . ' - ' . $row->end_at->format('Y-m-d H:i');
                })
                ->addColumn('status', function ($row) {
                     return $row->is_active 
                        ? '<span class="badge badge-success">' . trans_db('dashboard.active') . '</span>' 
                        : '<span class="badge badge-danger">' . trans_db('dashboard.inactive') . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="' . route('admin.flash_sales.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" onclick="deleteItem(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.flash_sales.index');
    }

    public function create()
    {
        return view('dashboard.admin.flash_sales.create');
    }

    public function searchProducts(Request $request)
    {
        $term = $request->term;
        $products = Product::whereHas('translations', function($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%');
        })->active()->take(20)->get();

        $results = [];
        foreach($products as $product) {
            $results[] = [
                'id' => $product->id,
                'text' => $product->translation->name ?? $product->translations->first()->name ?? 'Product #' . $product->id,
                'price' => $product->price
            ];
        }
        
        return response()->json(['results' => $results]);
    }

    public function store(Request $request)
    {
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'prices' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Handle Image Upload if implemented (placeholder for now)
            $imagePath = null;
            if ($request->hasFile('image')) {
                 $file = $request->file('image');
                 $filename = time() . '.' . $file->getClientOriginalExtension();
                 $file->move(public_path('uploads/flash_sales'), $filename);
                 $imagePath = 'uploads/flash_sales/' . $filename;
            }

            $flashSale = FlashSale::create([
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_active' => $request->has('is_active'),
                'image' => $imagePath,
            ]);

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                FlashSaleTranslation::create([
                    'flash_sale_id' => $flashSale->id,
                    'locale' => $localeCode,
                    'name' => $request->input("name_$localeCode"),
                ]);
            }

            if ($request->has('products')) {
                foreach ($request->products as $key => $productId) {
                    $price = $request->prices[$productId] ?? 0;
                     $flashSale->products()->attach($productId, ['price' => $price]);
                }
            }

            DB::commit();
            return redirect()->route('admin.flash_sales.index')->with('success', trans_db('dashboard.created_successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $flashSale = FlashSale::with(['translations', 'products.translation'])->findOrFail($id);
        return view('dashboard.admin.flash_sales.edit', compact('flashSale'));
    }

    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

         foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $request->validate(["name_$localeCode" => 'required|string|max:255']);
        }
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        DB::beginTransaction();
        try {
            
             if ($request->hasFile('image')) {
                 $file = $request->file('image');
                 $filename = time() . '.' . $file->getClientOriginalExtension();
                 $file->move(public_path('uploads/flash_sales'), $filename);
                 $imagePath = 'uploads/flash_sales/' . $filename;
                  $flashSale->image = $imagePath;
            }

            $flashSale->update([
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'is_active' => $request->has('is_active'),
            ]);

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                FlashSaleTranslation::updateOrCreate(
                    ['flash_sale_id' => $flashSale->id, 'locale' => $localeCode],
                    ['name' => $request->input("name_$localeCode")]
                );
            }
            
            // Sync products
            // Detach all first or sync with values
            $syncData = [];
             if ($request->has('products')) {
                foreach ($request->products as $key => $productId) {
                    $price = $request->prices[$productId] ?? 0;
                    $syncData[$productId] = ['price' => $price];
                }
            }
            $flashSale->products()->sync($syncData);

            DB::commit();
            return redirect()->route('admin.flash_sales.index')->with('success', trans_db('dashboard.updated_successfully'));

        } catch (\Exception $e) {
             DB::rollback();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();
        return response()->json(['success' => trans_db('dashboard.deleted_successfully')]);
    }
}
