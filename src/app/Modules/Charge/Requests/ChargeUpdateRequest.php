<?php

namespace App\Modules\Charge\Requests;


class ChargeUpdateRequest extends ChargeCreateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'charges_name' => 'required|string|max:250',
            'charges_slug' => 'required|string|max:500|unique:charges,charges_slug,'.$this->route('id'),
            'charges_in_amount' => ['required', 'numeric', 'gte:0'],
            'is_percentage' => 'required|boolean',
            'include_charges_for_cart_price_below' => ['nullable', 'numeric', 'gte:0'],
            'is_active' => 'required|boolean',
        ];
    }
}