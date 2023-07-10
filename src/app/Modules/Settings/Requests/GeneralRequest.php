<?php

namespace App\Modules\Settings\Requests;

use App\Modules\Settings\Services\GeneralService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rule;


class GeneralRequest extends FormRequest
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
        $general = (new GeneralService)->getById(1);

        return [
            'facebook' => 'nullable|url|max:250',
            'instagram' => 'nullable|url|max:250',
            'linkedin' => 'nullable|url|max:250',
            'youtube' => 'nullable|url|max:250',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|max:500',
            'address' => 'required|string|max:500',
            'website_logo_alt' => 'nullable|string|max:500',
            'website_logo_title' => 'nullable|string|max:500',
            'website_name' => 'required|string|max:500',
            'website_logo' => ['image','min:10','max:500', Rule::requiredIf(function () use($general){
                return empty($general->website_logo);
            })],
            'website_footer_logo' => ['image','min:10','max:500', Rule::requiredIf(function () use($general){
                return empty($general->website_footer_logo);
            })],
            'website_favicon' => ['image','min:10','max:500', Rule::requiredIf(function () use($general){
                return empty($general->website_favicon);
            })],
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
