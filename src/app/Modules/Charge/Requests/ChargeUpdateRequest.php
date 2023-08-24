<?php

namespace App\Modules\Charge\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


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
            'exclude_charges_for_cart_price_above' => ['required', 'numeric', 'gte:0'],
            'is_active' => 'required|boolean',
        ];
    }
}
