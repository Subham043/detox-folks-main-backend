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
            'brief_description' => 'required|string',
            'description' => 'required|string',
            'description_unfiltered' => 'required|string',
            'image' => 'nullable|image|min:1|max:5000',
            'is_draft' => 'required|boolean',
            'is_new' => 'required|boolean',
            'is_on_sale' => 'required|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'category' => 'required|array|min:1',
            'category.*' => 'required|numeric|exists:categories,id',
            'sub_category' => 'nullable|array|min:0',
            'sub_category.*' => 'nullable|numeric|exists:sub_categories,id',
        ];
    }

}
