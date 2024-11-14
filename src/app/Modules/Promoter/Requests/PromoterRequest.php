<?php

namespace App\Modules\Promoter\Requests;

use App\Modules\Promoter\Models\Promoter;
use App\Modules\Promoter\Models\PromoterCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class InstallerRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:6', 'exists:app_promoter_codes,code', function ($attribute, $value, $fail) {
                $promoter_code = PromoterCode::with(['promoter'])->where('code', $value)->first();
                if(!$promoter_code){
                    $fail('The '.$attribute.' entered is incorrect.');
                }else{
                    $promoter = Promoter::where('installed_by_id', auth()->user()->id)->first();
                    if($promoter){
                        $fail('The '.$attribute.' entered is already used by you');
                    }
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
