<?php

namespace App\Modules\Promoter\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;

class PromoterReportDataExport implements FromCollection,WithHeadings,WithMapping
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
            'Phone',
            'Location',
            'Is Approved',
            'Remarks',
            'Created On',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->phone,
            $data->location ?? "",
            $data->is_app_installed ? "Yes" : "No",
            $data->remarks ?? "",
            $data->created_at->format("d M Y h:i A"),
         ];
    }
    public function collection()
    {
        return $this->promoters;
    }
}
