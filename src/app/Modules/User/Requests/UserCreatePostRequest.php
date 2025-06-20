<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Password;


class UserCreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('Super-Admin|Staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'role' => 'required|string|exists:Spatie\Permission\Models\Role,name',
            'password_confirmation' => 'string|min:8|required_with:password|same:password',
            'password' => ['required',
                'string',
                Password::min(6)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
            ],
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
