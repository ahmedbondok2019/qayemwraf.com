<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = ProductBrand::active()->with('translation')->get();

        return view('frontend.brands.index', compact('brands'));
    }
}
