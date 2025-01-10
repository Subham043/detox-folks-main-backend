<?php

namespace App\Modules\Blog\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBlogCollection extends JsonResource
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
            'heading' => $this->heading,
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'image' => asset($this->image),
            'is_draft' => $this->is_draft,
            'is_popular' => $this->is_popular,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
