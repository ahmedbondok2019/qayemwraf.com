<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsDashboardExport implements FromView
{
    public function view(): View
    {
        $user_id = Session::get('user_id');
        $products = Product::whereHas('translations');
        if ($user_id != null) {
            $products = $products->where('vendor_id', $user_id);
        }
        $products = $products->get();

        return view('export_dashboard', [
            'products' => $products,
        ]);
    }
    //    public function query()
    //    {
    // //        return product_model::select('id' , 'title_ar as title' , 'description_ar as description'
    // //            $row['title'] = $product->title_ar,
    // //            $row['description'] = $product->description_ar,
    // //            $row['availability'] = 'in stock',
    // //            $row['condition'] = 'new',
    // //            $row['link'] = 'https://azahir.farm/product/productdetail/' . $product->id . '/' . helperController::make_slug($product->title_ar),
    // //            $row['image_link'] = $product->p_images[0]->image,
    // //            $row['brand'] = 'Azahir Farm',
    // //            $row['google_product_category'] = '',
    // //            $row['fb_product_category'] = $product->category,
    // //            $row['quantity_to_sell_on_facebook'] = '',
    // //            $row['sale_price'] = '',
    // //            $row['sale_price_effective_date'] = '',
    // //            $row['item_group_id'] = '',
    // //            $row['gender'] = 'unisex',
    // //            $row['age_group'] = 'adult',
    // //            $row['price'] = $product->price,
    // //            $row['size'] = $product->product_count_ar,
    // //            $row['material'] = $product->taste_ar,
    // //            $row['shipping'] = $product->product_count_ar,
    // //            $row['shipping_weight'] = $product->weight,
    // //            $row['style[0]'] = $product->season_ar,
    // //            $row['pattern'] = $product->use_ar,
    // //            $row['color'] = $product->color_ar
    // //        );
    //    }

    //    /**
    //     * @var product_model $product_model
    //     */
    //    public function map($product): array
    //    {
    //        return [
    //            $product->id,
    //            $product->title_ar,
    //            $product->description_ar,
    //            'in stock',
    //            'new',
    //            'https://azahir.farm/product/productdetail/' . $product->id . '/' . helperController::make_slug($product->title_ar),
    //            $product->p_images[0]->image,
    //            'Azahir Farm',
    //            '',
    //            $product->category,
    //            '',
    //            '',
    //            '',
    //            '',
    //            'unisex',
    //            'adult',
    //            $product->price,
    //            $product->product_count_ar,
    //            $product->taste_ar,
    //            $product->product_count_ar,
    //            $product->weight,
    //            $product->season_ar,
    //            $product->use_ar,
    //            $product->color_ar
    //
    // //            $row['id'] = $product->id,
    // //            $row['title'] = $product->title_ar,
    // //            $row['description'] = $product->description_ar,
    // //            $row['availability'] = 'in stock',
    // //            $row['condition'] = 'new',
    // //            $row['link'] = 'https://azahir.farm/product/productdetail/' . $product->id . '/' . helperController::make_slug($product->title_ar),
    // //            $row['image_link'] = $product->p_images[0]->image,
    // //            $row['brand'] = 'Azahir Farm',
    // //            $row['google_product_category'] = '',
    // //            $row['fb_product_category'] = $product->category,
    // //            $row['quantity_to_sell_on_facebook'] = '',
    // //            $row['sale_price'] = '',
    // //            $row['sale_price_effective_date'] = '',
    // //            $row['item_group_id'] = '',
    // //            $row['gender'] = 'unisex',
    // //            $row['age_group'] = 'adult',
    // //            $row['price'] = $product->price,
    // //            $row['size'] = $product->product_count_ar,
    // //            $row['material'] = $product->taste_ar,
    // //            $row['shipping'] = $product->product_count_ar,
    // //            $row['shipping_weight'] = $product->weight,
    // //            $row['style[0]'] = $product->season_ar,
    // //            $row['pattern'] = $product->use_ar,
    // //            $row['color'] = $product->color_ar
    //        ];
    //    }
    //
    //    public function headings(): array
    //    {
    //        return [
    //            'id','title','description','availability','condition','link','image_link','brand',
    //            'google_product_category','fb_product_category','quantity_to_sell_on_facebook','sale_price',
    //            'sale_price_effective_date','item_group_id','gender','age_group','price','size','material','shipping',
    //            'shipping_weight','style[0]','pattern','color'
    //        ];
    //    }
}

// class ProductsExport implements FromView,WithStyles,WithColumnWidths
// {
//    public function view(): View
//    {
//        return view('admin.statement.vendorTable', [
// //            'reports' => orders::all()
//            'reports' => Invoice::where('vendor', Session::get('vendor_id'))->get()
//        ]);
//    }
//
//    public function styles(Worksheet $sheet)
//    {
//        return [
//            // Style the first row as bold text.
//            1    => ['font' => ['bold' => true,'size' => 16], 'background(-color)' => ['#17a2b8']],
//            2    => ['font' => ['bold' => true,'size' => 16 ]],
//            3    => ['font' => ['bold' => true,'size' => 16 ]],
//            4    => ['font' => ['bold' => true,'size' => 16 ]],
//            5    => ['font' => ['bold' => true,'size' => 16 ]],
//            6    => ['font' => ['bold' => true,'size' => 16 ]],
//            7    => ['font' => ['bold' => true,'size' => 16 ]],
//            8    => ['font' => ['bold' => true,'size' => 16 ]],
//            9    => ['font' => ['bold' => true,'size' => 16 ]],
//
//            // Styling a specific cell by coordinate.
//            'B' => ['font' => ['italic' => true]],
//
//            // Styling an entire column.
//            'C'  => ['font' => ['size' => 16]],
//        ];
//    }
//
//    public function columnWidths(): array
//    {
//        return [
//            'A' => 20,
//            'B' => 20,
//            'C' => 20,
//            'D' => 20,
//            'E' => 20,
//            'F' => 20,
//            'G' => 20,
//            'H' => 20,
//            'I' => 20,
//        ];
//    }
//
// //    public function export()
// //    {
// //        return Excel::download(new InvoicesExport, 'invoice.xlsx');
// //    }
// }
