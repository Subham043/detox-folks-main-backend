<?php

namespace App\Modules\ProductPrice\Services;

use App\Modules\ProductPrice\Models\ProductPrice;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductPriceService
{

    public function all(Int $product_id): Collection
    {
        return ProductPrice::with('product')->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductPrice::with('product')->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductPrice|null
    {
        return ProductPrice::with('product')->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductPrice|null
    {
        return ProductPrice::with('product')->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductPrice
    {
        $product_price = ProductPrice::create($data);
        return $product_price;
    }

    public function update(array $data, ProductPrice $product_price): ProductPrice
    {
        $product_price->update($data);
        return $product_price;
    }

    public function delete(ProductPrice $product_price): bool|null
    {
        return $product_price->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('min_quantity', 'LIKE', '%' . $value . '%')
            ->orWhere('discount', 'LIKE', '%' . $value . '%')
            ->orWhere('price', 'LIKE', '%' . $value . '%');
        });
    }
}
