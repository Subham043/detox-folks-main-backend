<?php

namespace App\Modules\ProductImage\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProductImageCollection extends JsonResource
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
            'image_title' => $this->image_title,
            'image_alt' => $this->image_alt,
            'image' => asset($this->image),
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
