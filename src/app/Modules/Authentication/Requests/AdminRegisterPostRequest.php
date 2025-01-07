<?php

namespace App\Modules\Authentication\Requests;

use App\Http\Services\RateLimitService;
use App\Modules\Promoter\Models\Promoter;
use App\Modules\Promoter\Models\PromoterCode;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Password as PasswordValidation;


class AdminRegisterPostRequest extends FormRequest
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
        $email = $this->email;
        $phone = $this->phone;
        return [
            'name' => ['required', 'string'],
            'email' => ['nullable','string','email:rfc,dns','unique:users'],
            'phone' => ['required','numeric', 'digits:10', 'unique:users'],
            'role' => 'required|string|exists:Spatie\Permission\Models\Role,name',
            'password' => ['required',
                'string',
                PasswordValidation::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'confirm_password' => ['required_with:password','same:password'],
            'code' => ['nullable', 'string', 'max:6', 'exists:app_promoter_codes,code', function ($attribute, $value, $fail) use ($email, $phone){
                if(!empty($value)){
                    $promoter_code = PromoterCode::with(['promoter'])->where('code', $value)->first();
                    if(!$promoter_code){
                        $fail('The '.$attribute.' entered is incorrect.');
                    }else{
                        if($promoter_code->promoter->email == $email || $promoter_code->promoter->phone == $phone){
                            $fail('The '.$attribute.' entered is invalid');
                        }
                        $promoter = Promoter::with('installed_by')->whereHas('installed_by', function($qry) use ($email, $phone){
                            $qry->where(function($q) use ($email, $phone){
                                $q->where('email', $email)->orWhere('phone', $phone);
                            });
                        })->first();
                        if($promoter){
                            $fail('The '.$attribute.' entered is already used by you');
                        }
                    }
                }
            }],
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
