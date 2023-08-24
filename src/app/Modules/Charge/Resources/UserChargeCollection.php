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
            'charges_in_amount' => $this->charges_in_amount,
            'exclude_charges_for_cart_price_above' => $this->exclude_charges_for_cart_price_above,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
