<?php

namespace App\Modules\Order\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductCollection extends JsonResource
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
            'slug' => $this->slug,
            'brief_description' => $this->brief_description,
            'image' => asset($this->image),
            'min_quantity' => $this->min_quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'discounted_price' => $this->discounted_price,
            'tax_in_price' => $this->tax_in_price,
            'discount_in_price' => $this->discount_in_price,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'amount' => $this->amount,
            'unit' => $this->unit,
            'taxes' => OrderTaxCollection::collection($this->taxes),
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
