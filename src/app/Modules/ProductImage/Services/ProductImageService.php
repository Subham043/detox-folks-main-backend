<?php

namespace App\Modules\ProductImage\Services;

use App\Http\Services\FileService;
use App\Modules\ProductImage\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductImageService
{

    public function all(Int $product_id): Collection
    {
        return ProductImage::with('product')->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductImage::with('product')->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductImage|null
    {
        return ProductImage::with('product')->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductImage|null
    {
        return ProductImage::with('product')->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductImage
    {
        $product_image = ProductImage::create($data);
        return $product_image;
    }

    public function update(array $data, ProductImage $product_image): ProductImage
    {
        $product_image->update($data);
        return $product_image;
    }

    public function saveImage(ProductImage $product_image): ProductImage
    {
        $this->deleteImage($product_image);
        $image = (new FileService)->save_file('image', (new ProductImage)->image_path);
        return $this->update([
            'image' => $image,
        ], $product_image);
    }

    public function delete(ProductImage $product_image): bool|null
    {
        $this->deleteImage($product_image);
        return $product_image->delete();
    }

    public function deleteImage(ProductImage $product_image): void
    {
        if($product_image->image){
            $path = str_replace("storage","app/public",$product_image->image);
            (new FileService)->delete_file($path);
        }
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('image_title', 'LIKE', '%' . $value . '%')
        ->orWhere('image_alt', 'LIKE', '%' . $value . '%');
    }
}
