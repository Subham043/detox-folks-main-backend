<?php

namespace App\Modules\Promoter\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;

class PromoterExport implements FromCollection,WithHeadings,WithMapping
{

    protected $promoters;

    public function __construct(Collection $promoters)
    {
        $this->promoters = $promoters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'ID',
            'Name',
            'Email',
            'Phone',
            'Role',
            'Is Approved',
            'Has Placed Order',
            'No. of Orders',
            'Installed On',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->phone,
            $data->current_role,
            (count($data->app_promoter)>0 && $data->app_promoter[0]->pivot->is_approved) ? "Yes" : "No",
            ($data->orders_count>0) ? "Yes" : "No",
            $data->orders_count ?? 0,
            $data->created_at->format("d M Y h:i A"),
         ];
    }
    public function collection()
    {
        return $this->promoters;
    }
}
