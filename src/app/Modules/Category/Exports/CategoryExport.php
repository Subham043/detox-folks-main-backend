<?php

namespace App\Modules\Category\Exports;

use App\Modules\Category\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection,WithHeadings,WithMapping
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
            $data->status ? "Active" : "Inactive",
            $data->created_at->diffForHumans(),
         ];
    }
    public function collection()
    {
        return Category::all();
    }
}
