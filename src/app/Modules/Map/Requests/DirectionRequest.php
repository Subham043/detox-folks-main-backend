<?php

namespace App\Modules\Map\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;

class DirectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
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
            'origin_lat' => 'required|decimal:1,15',
            'origin_lng' => 'required|decimal:1,15',
            'destination_lat' => 'required|decimal:1,15',
            'destination_lng' => 'required|decimal:1,15',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'origin_lat' => 'Origin Latitude',
            'origin_lng' => 'Origin Longitude',
            'destination_lat' => 'Destination Latitude',
            'destination_lng' => 'Destination Longitude',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->replace(
            Purify::clean(
                $this->all()
            )
        );
    }

}