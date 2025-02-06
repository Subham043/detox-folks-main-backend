<?php

namespace App\Modules\Tax\Requests;


class TaxUpdateRequest extends TaxCreateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tax_name' => 'required|string|max:250',
            'tax_slug' => 'required|string|max:500|unique:taxes,tax_slug,'.$this->route('id'),
            'tax_value' => ['required', 'numeric', 'gte:0'],
            'is_active' => 'required|boolean',
        ];
    }
}
