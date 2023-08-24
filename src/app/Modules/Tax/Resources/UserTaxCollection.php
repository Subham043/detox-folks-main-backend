<?php

namespace App\Modules\Tax\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxCollection extends JsonResource
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
            'tax_slug' => $this->tax_slug,
            'heading' => $this->heading,
            'tax_name' => $this->tax_name,
            'tax_in_percentage' => $this->tax_in_percentage,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
