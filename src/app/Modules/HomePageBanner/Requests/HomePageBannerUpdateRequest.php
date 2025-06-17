<?php

namespace App\Modules\HomePageBanner\Requests;

use Illuminate\Support\Facades\Auth;

class HomePageBannerUpdateRequest extends HomePageBannerCreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('Super-Admin|Staff|Content Manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image_title' => 'nullable|string|max:250',
            'image_alt' => 'nullable|string|max:500',
            'desktop_image' => 'nullable|image|min:1|max:500',
            'mobile_image' => 'nullable|image|min:1|max:500',
            'is_draft' => 'required|boolean',
        ];
    }

}
