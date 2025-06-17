<?php

namespace App\Modules\ProductVideo\Requests;


class ProductVideoUpdateRequest extends ProductVideoCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'video' => 'required|string|max:500',
        ];
    }

}
