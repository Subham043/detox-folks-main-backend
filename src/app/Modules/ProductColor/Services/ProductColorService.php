<?php

namespace App\Modules\ProductColor\Services;

use App\Modules\ProductColor\Models\ProductColor;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductColorService
{

    public function all(Int $product_id): Collection
    {
        return ProductColor::with('product')->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductColor::with('product')->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductColor|null
    {
        return ProductColor::with('product')->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductColor|null
    {
        return ProductColor::with('product')->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductColor
    {
        $product_color = ProductColor::create($data);
        return $product_color;
    }

    public function update(array $data, ProductColor $product_color): ProductColor
    {
        $product_color->update($data);
        return $product_color;
    }

    public function delete(ProductColor $product_color): bool|null
    {
        return $product_color->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('title', 'LIKE', '%' . $value . '%')
            ->orWhere('description', 'LIKE', '%' . $value . '%');
        });
    }
}
