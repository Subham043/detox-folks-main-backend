<?php

namespace App\Modules\Settings\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserGeneralCollection extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'linkedin' => $this->linkedin,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'website_logo_alt' => $this->website_logo_alt,
            'website_logo_title' => $this->website_logo_title,
            'website_name' => $this->website_name,
            'website_logo' => asset($this->website_logo),
            'website_footer_logo' => asset($this->website_footer_logo),
            'website_favicon' => asset($this->website_favicon),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
