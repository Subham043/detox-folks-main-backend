<?php

namespace App\Modules\GlobalSearch\Services;

use App\Modules\Category\Models\Category;
use App\Modules\Product\Models\Product;
use App\Modules\SubCategory\Models\SubCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class GlobalSearchService
{
    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $search = request()->query('filter')['search'] ?? '';
        $query1 = Category::query()->select('id', 'name', 'slug', 'image', 'search_type')->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query2 = SubCategory::query()->select('id', 'name', 'slug', 'image', 'search_type')->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query3 = Product::query()->select('id', 'name', 'slug', 'image', 'search_type')->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query4 = $query3->union($query2);
        $query = $query4->union($query1);
        return QueryBuilder::for($query)
                ->allowedFields(['id', 'name', 'slug', 'image', 'search_type'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
