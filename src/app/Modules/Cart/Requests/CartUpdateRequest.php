<?php

namespace App\Modules\Cart\Requests;

use App\Modules\ProductColor\Models\ProductColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class CartUpdateRequest extends FormRequest
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
        $color = ProductColor::where('product_id', $this->product_id)->count();
        return [
            'product_id' => [
                'required',
                'numeric',
                'exists:products,id',
                // 'unique:carts,product_id,'.$this->route('id')
            ],
            'product_price_id' => [
                'required',
                'numeric',
                'exists:product_prices,id',
                // 'unique:carts,product_price_id,'.$this->route('id')
            ],
            'color' => $color > 0 ? [
                'required',
                'string',
            ] : [
                'nullable',
                'string',
            ],
            'amount' => [
                'required',
                'numeric',
                'gte:0'
            ],
            'quantity' => [
                'required',
                'numeric',
                'gte:0'
            ],
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
