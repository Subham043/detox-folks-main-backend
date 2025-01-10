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
            'Category',
            'Sub-Category',
            'Minimum Cart Quantity',
            'Cart Quantity Interval',
            'Cart Quantity Specification',
            'Minimum Quantity / Price / Discount(%)',
            'Status',
            'Created At',
        ];
    }
    public function map($data): array
    {
        $product_prices = $data->product_prices->map(function($item){
            return $item->min_quantity."/".$item->price."/".$item->discount;
        });
         return[
            $data->id,
            $data->name,
            $data->categories->pluck('name')->implode(', ') ?? "",
            $data->sub_categories->pluck('name')->implode(', ') ?? "",
            $data->min_cart_quantity,
            $data->cart_quantity_specification,
            $data->cart_quantity_interval,
            $product_prices->implode(', '),
            $data->is_draft ? "Active" : "Inactive",
            $data->created_at->format("d M Y h:i A"),
         ];
    }
    public function collection()
    {
        return Product::with([
            'categories',
            'sub_categories',
            'product_prices'=>function($q){
                $q->orderBy('min_quantity', 'asc');
            },
        ])->get();
    }
}
