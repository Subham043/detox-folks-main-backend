<?php

namespace App\Modules\Coupon\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponUpdateRequest extends CouponCreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:500',
            'code' => 'required|string|alpha_num:ascii|max:500|unique:coupons,code,'.$this->route('id'),
            'description' => 'nullable|string',
            'discount' => 'required|numeric|gt:0',
            'maximum_dicount_in_price' => 'nullable|numeric|gt:0',
            'maximum_number_of_use' => 'nullable|numeric|gt:0',
            'minimum_cart_value' => 'nullable|numeric|gte:0',
            'is_active' => 'required|boolean',
        ];
    }

}
