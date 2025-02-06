<?php

namespace App\Modules\Tax\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTaxCollection extends JsonResource
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
            'tax_name' => $this->tax_name,
            'tax_slug' => $this->tax_slug,
            'tax_value' => round($this->tax_value, 2),
            'is_active' => $this->is_active,
            'total_tax_in_amount' => $this->total_tax_in_amount,
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
