<?php

namespace App\Modules\Authentication\Resources;

use App\Modules\Role\Resources\RoleCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthCollection extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'email_verified' => $this->email_verified_at ? "VERIFIED": "VERIFICATION PENDING",
            'phone_verified' => $this->phone_verified_at ? "VERIFIED": "VERIFICATION PENDING",
            'roles' => RoleCollection::collection($this->roles),
        ];
    }
}