<?php

namespace App\Modules\Enquiry\OrderForm\Exports;

use App\Modules\Enquiry\OrderForm\Models\OrderForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderFormExport implements FromCollection,WithHeadings,WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'id',
            'name',
            'email',
            'phone',
            'order',
            'total amount',
            'payment mode',
            'payment status',
            'order status',
            'message',
            'created_at',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->order->name,
            $data->order->email,
            $data->order->phone,
            $data->order->id,
            $data->order->total_price,
            $data->order->payment->mode,
            $data->order->payment->status,
            $data->order->current_status->status,
            $data->message,
            $data->created_at,
         ];
    }
    public function collection()
    {
        return OrderForm::with([
            'order' => function($q) {
                $q->with([
                    'current_status',
                    'payment',
                ]);
            }
        ])->whereHas('order')->all();
    }
}