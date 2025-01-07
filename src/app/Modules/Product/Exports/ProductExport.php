<?php

namespace App\Modules\Product\Exports;

use App\Modules\Product\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection,WithHeadings,WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'Name',
            'Slug',
            'Heading',
            'Description',
            'Category',
            'Sub-Category',
            'Status',
            'Created At',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->slug,
            $data->heading,
            $data->brief_description,
            $data->categories->pluck('name')->implode(', ') ?? "",
            $data->sub_categories->pluck('name')->implode(', ') ?? "",
            $data->status ? "Active" : "Inactive",
            $data->created_at->diffForHumans(),
         ];
    }
    public function collection()
    {
        return Product::with([
            'categories',
            'sub_categories',
            // 'product_specifications',
            // 'product_images',
            // 'product_colors',
            // 'product_prices'=>function($q){
            //     $q->orderBy('min_quantity', 'asc');
            // },
        ])->get();
    }
}
