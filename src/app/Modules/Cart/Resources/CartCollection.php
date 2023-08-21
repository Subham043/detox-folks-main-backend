<?php

namespace App\Modules\Cart\Resources;

use App\Modules\Product\Resources\UserProductCollection;
use App\Modules\ProductPrice\Resources\UserProductPriceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CartCollection extends JsonResource
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
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'product' => UserProductCollection::make($this->product),
            'product_price' => UserProductPriceCollection::make($this->product_price),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
