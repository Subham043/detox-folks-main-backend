<?php

namespace App\Modules\DeliverySlot\Requests;

use Illuminate\Support\Facades\Auth;

class DeliverySlotUpdateRequest extends DeliverySlotCreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('Super-Admin');
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
            'is_cod_allowed' => 'required|boolean',
            'is_draft' => 'required|boolean',
        ];
    }

}
