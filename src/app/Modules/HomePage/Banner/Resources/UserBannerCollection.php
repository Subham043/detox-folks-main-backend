<?php

namespace App\Modules\HomePage\Banner\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBannerCollection extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'button_link' => $this->button_link,
            'button_text' => $this->button_text,
            'banner_image_alt' => $this->banner_image_alt,
            'banner_image_title' => $this->banner_image_title,
            'banner_image' => asset($this->banner_image),
            'is_draft' => $this->is_draft,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
