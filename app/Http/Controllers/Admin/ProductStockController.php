<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductStockUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductStockImport;
use App\Exports\StockUpdateTemplateExport;
use Illuminate\Support\Facades\Auth;

class ProductStockController extends Controller
{
    public function index()
    {
        $history = ProductStockUpdate::with('admin')->latest()->paginate(10);
        return view('dashboard.admin.products.stock_update', compact('history'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/stock_updates'), $filename);

        $import = new ProductStockImport();
        
        try {
            Excel::import($import, public_path('uploads/stock_updates/' . $filename));

            ProductStockUpdate::create([
                'filename' => $filename,
                'admin_id' => auth('admin')->id(),
                'total_rows' => $import->total,
                'successful_updates' => $import->successful,
                'failed_updates' => $import->failed,
                'details' => $import->details,
            ]);

            return redirect()->back()->with('success', trans_db('dashboard.Stock updated successfully.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error during import: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $update = ProductStockUpdate::findOrFail($id);
        return response()->json($update);
    }

    public function downloadTemplate()
    {
        return Excel::download(new StockUpdateTemplateExport, 'stock_update_template.xlsx');
    }
}
