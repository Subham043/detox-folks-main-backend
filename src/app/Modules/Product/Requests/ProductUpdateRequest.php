<?php

namespace App\Modules\Product\Requests;

class ProductUpdateRequest extends ProductCreateRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:500',
            'slug' => 'required|string|max:500|unique:products,slug,'.$this->route('id'),
            'hsn' => 'nullable|string|max:500',
            'brief_description' => 'required|string',
            'description' => 'required|string',
            'description_unfiltered' => 'required|string',
            'image' => 'nullable|image|min:1|max:5000',
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
            'tax' => 'required|array|min:1',
            'tax.*' => 'required|numeric|exists:taxes,id',
            'category' => 'required|array|min:1',
            'category.*' => 'required|numeric|exists:categories,id',
            'sub_category' => 'nullable|array|min:0',
            'sub_category.*' => 'nullable|numeric|exists:sub_categories,id',
            'specifications' => 'required|array|min:1',
            'specifications.*.id' => 'nullable|numeric|exists:product_specifications,id',
            'specifications.*.title' => 'required|string|max:500',
            'specifications.*.description' => 'required|string',
            'prices' => 'required|array|min:1',
            'prices.*.id' => 'nullable|numeric|exists:product_prices,id',
            'prices.*.min_quantity' => 'required|numeric|gt:1',
            'prices.*.price' => 'required|numeric|gt:0',
            'prices.*.discount' => 'required|numeric|gte:0',
        ];
    }

}
