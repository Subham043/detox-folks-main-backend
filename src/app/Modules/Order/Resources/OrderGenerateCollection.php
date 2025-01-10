<?php

namespace App\Modules\Order\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderGenerateCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'pin' => $this->pin,
            'address' => $this->address,
            'subtotal' => $this->subtotal,
            'total_charges' => $this->total_charges,
            'total_price' => $this->total_price,
            'order_mode' => $this->order_mode,
            'products' => OrderProductCollection::collection($this->products),
            'charges' => OrderChargeCollection::collection($this->charges),
            'statuses' => OrderStatusCollection::collection($this->statuses),
            'payment' => OrderPaymentGenerateCollection::make($this->payment),
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
