<?php

namespace App\Modules\ProductSpecification\Services;

use App\Modules\ProductSpecification\Models\ProductSpecification;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductSpecificationService
{

    public function all(Int $product_id): Collection
    {
        return ProductSpecification::with('product')->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductSpecification::with('product')->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductSpecification|null
    {
        return ProductSpecification::with('product')->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductSpecification|null
    {
        return ProductSpecification::with('product')->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductSpecification
    {
        $product_specification = ProductSpecification::create($data);
        return $product_specification;
    }

    public function update(array $data, ProductSpecification $product_specification): ProductSpecification
    {
        $product_specification->update($data);
        return $product_specification;
    }

    public function delete(ProductSpecification $product_specification): bool|null
    {
        return $product_specification->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('description', 'LIKE', '%' . $value . '%');
    }
}
