<?php

namespace App\Modules\Order\Resources;

use App\Modules\Order\Services\OrderService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPaymentGenerateCollection extends JsonResource
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
            'mode' => $this->mode,
            'status' => $this->status,
            'phone_pe_payment_link' => (new OrderService)->get_phone_pe_link($this->order),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
