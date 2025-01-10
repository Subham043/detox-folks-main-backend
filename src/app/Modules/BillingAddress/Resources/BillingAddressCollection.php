<?php

namespace App\Modules\BillingAddress\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingAddressCollection extends JsonResource
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
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'pin' => $this->pin,
            'address' => $this->address,
            'map_information' => $this->map_information,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
