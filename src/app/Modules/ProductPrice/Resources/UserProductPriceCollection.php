<?php

namespace App\Modules\ProductPrice\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProductPriceCollection extends JsonResource
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
            'min_quantity' => $this->min_quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
