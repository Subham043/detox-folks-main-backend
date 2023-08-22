<?php

namespace App\Modules\ProductImage\Requests;


class ProductImageUpdateRequest extends ProductImageCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image_title' => 'nullable|string|max:500',
            'image_alt' => 'nullable|string|max:500',
            'image' => 'nullable|image|min:1|max:5000',
        ];
    }

}
