<?php

namespace App\Modules\SubCategory\Exports;

use App\Modules\SubCategory\Models\SubCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubCategoryExport implements FromCollection,WithHeadings,WithMapping
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
            $data->description,
            $data->categories->pluck('name')->implode(', ') ?? "",
            $data->is_draft ? "Active" : "Inactive",
            $data->created_at->format("d M Y h:i A"),
         ];
    }
    public function collection()
    {
        return SubCategory::with('categories')->get();
    }
}
