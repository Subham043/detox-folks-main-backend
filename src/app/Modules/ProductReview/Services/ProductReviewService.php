<?php

namespace App\Modules\ProductReview\Services;

use App\Modules\ProductReview\Models\ProductReview;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ProductReviewService
{

    public function all(Int $product_id): Collection
    {
        return ProductReview::with(['product', 'user'])->where('product_id', $product_id)->get();
    }

    public function paginate(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductReview::with(['product', 'user'])->where('product_id', $product_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10, Int $product_id): LengthAwarePaginator
    {
        $query = ProductReview::with(['product', 'user'])->where('product_id', $product_id)->where('is_draft', false)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ProductReview|null
    {
        return ProductReview::with(['product', 'user'])->findOrFail($id);
    }

    public function getByProductIdAndId(Int $product_id, Int $id): ProductReview|null
    {
        return ProductReview::with(['product', 'user'])->where('product_id', $product_id)->findOrFail($id);
    }

    public function create(array $data): ProductReview
    {
        $product_review = ProductReview::create($data);
        return $product_review;
    }

    public function update(array $data, ProductReview $product_review): ProductReview
    {
        $product_review->update($data);
        return $product_review;
    }

    public function delete(ProductReview $product_review): bool|null
    {
        return $product_review->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('rating', 'LIKE', '%' . $value . '%')
            ->orWhere('comment', 'LIKE', '%' . $value . '%');
        });
    }
}
