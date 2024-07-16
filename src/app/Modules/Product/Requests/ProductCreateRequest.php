<?php

namespace App\Modules\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasRole('Super-Admin|Staff|Inventory Manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:500',
            'slug' => 'required|string|max:500|unique:products,slug',
            'brief_description' => 'required|string',
            'description' => 'required|string',
            'description_unfiltered' => 'required|string',
            'image' => 'required|image|min:1|max:5000',
            'is_draft' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'is_new' => 'required|boolean',
            'is_on_sale' => 'required|boolean',
            'cart_quantity_specification' => 'required|string',
            'min_cart_quantity' => 'required|numeric|gt:0',
            'cart_quantity_interval' => 'required|numeric|gt:0',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'category' => 'required|array|min:1',
            'category.*' => 'required|numeric|exists:categories,id',
            'sub_category' => 'nullable|array|min:0',
            'sub_category.*' => 'nullable|numeric|exists:sub_categories,id',
            'specifications' => 'required|array|min:1',
            'specifications.*.title' => 'required|string|max:500',
            'specifications.*.description' => 'required|string',
            'prices' => 'required|array|min:1',
            'prices.*.min_quantity' => 'required|numeric|gt:1',
            'prices.*.price' => 'required|numeric|gt:0',
            'prices.*.discount' => 'required|numeric|gte:0',
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
            'is_draft' => 'Draft',
            'images.*.image_title' => 'Title',
            'images.*.image_alt' => 'Alt',
            'images.*.image' => 'Image',
            'specifications.*.title' => 'Title',
            'specifications.*.description' => 'Description',
            'prices.*.min_quantity' => 'Min Quantity',
            'prices.*.price' => 'Price',
            'prices.*.discount' => 'Discount',
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