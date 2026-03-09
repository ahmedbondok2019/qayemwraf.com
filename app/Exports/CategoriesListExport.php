<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesListExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Category::with('translations')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name AR',
            'Name EN',
        ];
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->translations->where('locale', 'ar')->first()->title ?? '',
            $category->translations->where('locale', 'en')->first()->title ?? '',
        ];
    }
}
