<?php

namespace App\Modules\ProductVideo\Services;

use App\Modules\ProductVideo\Models\ProductVideo;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductVideoService
{

    public function all(Int $product_id): Collection
    {
        return ProductVideo::with('product')->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductVideo::with('product')->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductVideo|null
    {
        return ProductVideo::with('product')->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductVideo|null
    {
        return ProductVideo::with('product')->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductVideo
    {
        $product_video = ProductVideo::create($data);
        return $product_video;
    }

    public function update(array $data, ProductVideo $product_video): ProductVideo
    {
        $product_video->update($data);
        return $product_video;
    }

    public function delete(ProductVideo $product_video): bool|null
    {
        return $product_video->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('video', 'LIKE', '%' . $value . '%');
        });
    }
}
