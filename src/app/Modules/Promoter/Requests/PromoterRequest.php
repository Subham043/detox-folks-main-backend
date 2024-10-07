<?php

namespace App\Modules\Promoter\Requests;

use App\Modules\Authentication\Models\User;
use App\Modules\Promoter\Models\Promoter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class PromoterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('App Promoter');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email', function ($attribute, $value, $fail) {
                $user = User::with(['roles'])->whereHas('roles', function($q) { $q->where('name', 'User'); })->where('email', $value)->first();
                if($user){
                    $promoter = Promoter::where('installed_by_id', $user->id)->first();
                    if($promoter){
                        if($promoter->promoted_by_id == Auth::user()->id){
                            $fail('The '.$attribute.' entered is already promoted by you');
                        }else{
                            $fail('The '.$attribute.' entered is already promoted by another agent');
                        }
                    }
                }else{
                    $fail('The '.$attribute.' entered is incorrect.');
                }
            }],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'orders.*.unique' => 'Delivery agent already assigned to this order',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = Purify::clean(
            $this->validated()
        );
        $this->replace(
            [...$request]
        );
    }
}
