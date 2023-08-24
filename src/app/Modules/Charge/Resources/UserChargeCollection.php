<?php

namespace App\Modules\Charge\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserChargeCollection extends JsonResource
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
            'charges_name' => $this->charges_name,
            'charges_slug' => $this->charges_slug,
            'charges_in_amount' => round($this->charges_in_amount, 2),
            'include_charges_for_cart_price_below' => round($this->include_charges_for_cart_price_below, 2),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
