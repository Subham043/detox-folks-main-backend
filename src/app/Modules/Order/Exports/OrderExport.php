<?php

namespace App\Modules\Order\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;

class OrderExport implements FromCollection,WithHeadings,WithMapping
{

    protected $orders;

    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
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
            'Products',
            'Total Amount',
            'Delivery Slot',
            'Mode Of Payment',
            'Payment Status',
            'Order Status',
            'Placed On',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->phone,
            $data->products->pluck('name')->implode(', '),
            $data->total_price,
            $data->delivery_slot ?? "N/A",
            $data->payment->mode->value ?? "",
            $data->payment->status->value ?? "",
            $data->current_status->status->value ?? "",
            !empty($data->current_status->created_at) ? $data->current_status->created_at->diffForHumans() : "",
         ];
    }
    public function collection()
    {
        return $this->orders;
    }
}
