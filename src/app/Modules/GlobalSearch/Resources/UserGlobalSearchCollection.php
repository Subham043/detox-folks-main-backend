<?php

namespace App\Modules\GlobalSearch\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGlobalSearchCollection extends JsonResource
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
            'search_type' => $this->type,
            'image' => asset($this->image),
        ];
    }
}
