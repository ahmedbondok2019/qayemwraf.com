<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            [
                'name_ar' => 'منتج تجريبي بالعربي',
                'name_en' => 'Test Product English',
                'price' => '100',
                'quantity' => '50',
                'brand' => 'الماركة التجريبية',
                'image_folder' => 'product_1',
                'shipping_section' => 'شحن القاهرة',
                'sku' => 'SKU-001',
                'category' => 'الكتب,الأكثر مبيعا',
                'weight' => '1.5',
                'max_order_qty' => '5',
                'ignore_quantity' => '0',
                'special_price' => '90',
                'special_price_start' => '2026-01-01',
                'special_price_end' => '2026-12-31',
                'is_best_seller' => '1',
                'best_seller_start' => '2026-01-01',
                'best_seller_end' => '2026-12-31',
                'is_gift' => '0',
                'description_ar' => 'وصف المنتج هنا',
                'description_en' => 'Product description in English',
                'meta_title_ar' => 'عنوان الميتا',
                'meta_title_en' => 'Meta Title',
                'meta_description_ar' => 'وصف الميتا',
                'meta_description_en' => 'Meta Description',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'name_ar',
            'name_en',
            'price',
            'quantity',
            'brand',
            'image_folder',
            'shipping_section',
            'sku',
            'category',
            'weight',
            'max_order_qty',
            'ignore_quantity',
            'special_price',
            'special_price_start',
            'special_price_end',
            'is_best_seller',
            'best_seller_start',
            'best_seller_end',
            'is_gift',
            'description_ar',
            'description_en',
            'meta_title_ar',
            'meta_title_en',
            'meta_description_ar',
            'meta_description_en',
        ];
    }
}
