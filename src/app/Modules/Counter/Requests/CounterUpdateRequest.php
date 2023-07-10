<?php

namespace App\Modules\Counter\Requests;

use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class CounterUpdateRequest extends CounterCreateRequest
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
            'title' => 'required|string|max:500',
            'counter' => 'required|numeric',
        ];
    }
}
