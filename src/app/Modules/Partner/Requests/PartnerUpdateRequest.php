<?php

namespace App\Modules\Partner\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PartnerUpdateRequest extends PartnerCreateRequest
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
            'is_draft' => 'required|boolean',
            'image' => ['nullable','image', 'min:1', 'max:500'],
            'image_alt' => 'nullable|string|max:500',
            'image_title' => 'nullable|string|max:500',
        ];
    }

}
