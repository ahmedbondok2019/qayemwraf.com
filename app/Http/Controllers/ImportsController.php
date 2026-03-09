<?php

namespace App\Http\Controllers;

use App\Imports\BrandImport;
use App\Imports\CategoryImport;
use App\Imports\ProductImport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    public function categories()
    {
        Excel::import(new CategoryImport, public_path('data/المجموعات.xlsx'));
    }

    public function products()
    {
        Excel::import(new ProductImport, public_path('data/منتجات.xlsx'));
    }

    public function brands()
    {
        Excel::import(new BrandImport, public_path('data/العلامات التجارية.xlsx'));
    }

    public function users()
    {
        Excel::import(new UserImport, public_path('data/customerList1689629583.xls'));
    }
}
