<?php

namespace App\Modules\Authentication\Requests;

use App\Http\Services\RateLimitService;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Password as PasswordValidation;


class UserRegisterPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        (new RateLimitService($this))->ensureIsNotRateLimited(3);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['nullable','string','email:rfc,dns','unique:users'],
            'phone' => ['required','numeric', 'digits:10', 'unique:users'],
            'password' => ['required',
                'string',
                PasswordValidation::min(6)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
            ],
            'confirm_password' => ['required_with:password','same:password'],
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
