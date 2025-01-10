<?php

namespace App\Modules\Product\Resources;

use App\Modules\Category\Resources\UserCategoryMainCollection;
use App\Modules\ProductColor\Resources\UserProductColorCollection;
use App\Modules\ProductImage\Resources\UserProductImageCollection;
use App\Modules\ProductPrice\Resources\UserProductPriceCollection;
use App\Modules\ProductSpecification\Resources\UserProductSpecificationCollection;
use App\Modules\SubCategory\Resources\UserSubCategoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'brief_description' => $this->brief_description,
            'short_description' => str()->limit($this->brief_description, 100),
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'image' => asset($this->image),
            'is_draft' => $this->is_draft,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'is_on_sale' => $this->is_on_sale,
            'cart_quantity_specification' => $this->cart_quantity_specification,
            'min_cart_quantity' => $this->min_cart_quantity,
            'cart_quantity_interval' => $this->cart_quantity_interval,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'product_prices' => UserProductPriceCollection::collection($this->product_prices),
            'product_specifications' => UserProductSpecificationCollection::collection($this->product_specifications),
            'product_colors' => UserProductColorCollection::collection($this->product_colors),
            'product_images' => UserProductImageCollection::collection($this->product_images),
            'categories' => UserCategoryMainCollection::collection($this->categories),
            'sub_categories' => UserSubCategoryCollection::collection($this->sub_categories),
            'created_at' => $this->created_at->format("d M Y h:i A"),
            'updated_at' => $this->updated_at->format("d M Y h:i A"),
        ];
    }
}
