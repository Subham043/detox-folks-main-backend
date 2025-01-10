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
            'Product/Price/Quantity/Amount',
            'Sub-Total',
            'Charges',
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
        $products = $data->products->map(function($product) {
            return $product->name.'/'.$product->discount_in_price.'/'.$product->quantity.'/'.$product->amount;
        });
        $charges = $data->charges->map(function($charge) {
            return $charge->charges_name.'/'.$charge->total_charge_in_amount;
        });
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->phone,
            // $data->products->pluck('name')->implode(', '),
            $products->implode(', '),
            $data->subtotal,
            $charges->implode(', '),
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
