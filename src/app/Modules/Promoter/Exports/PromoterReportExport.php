<?php

namespace App\Modules\Promoter\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;

class PromoterReportExport implements FromCollection,WithHeadings,WithMapping
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
            'SL NO',
            'DATE',
            'NO OF VISITS',
            'APP INSTALLED',
            'APP NOT INSTALLED',
        ];
    }
    public function map($data): array
    {
         return[
            $data->SL_NO,
            $data->DATE,
            $data->NO_OF_VISITS,
            $data->APP_INSTALLED,
            $data->APP_NOT_INSTALLED,
         ];
    }
    public function collection()
    {
        return $this->promoters;
    }
}
