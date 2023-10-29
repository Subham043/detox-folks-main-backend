<?php

namespace App\Modules\GlobalSearch\Services;

use App\Modules\Category\Models\Category;
use App\Modules\Product\Models\Product;
use App\Modules\SubCategory\Models\SubCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;

class GlobalSearchService
{
    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $search = request()->query('filter')['search'] ?? '';
        $queryOrder = 'CASE WHEN `type` = "PRODUCT" THEN 3 ';
        $queryOrder .= 'WHEN `type` = "SUBCATEGORY" THEN 2 ';
        $queryOrder .= 'ELSE 1 END';
        $query1 = Category::query()->select('id', 'name', 'slug', 'image', DB::raw('"CATEGORY" as type'))->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query2 = SubCategory::query()->select('id', 'name', 'slug', 'image', DB::raw('"SUBCATEGORY" as type'))->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query3 = Product::query()->select('id', 'name', 'slug', 'image', DB::raw('"PRODUCT" as type'))->where('is_draft', true)->where('name', 'LIKE', '%'.$search.'%');
        $query4 = $query3->union($query2);
        $query = $query4->union($query1);
        return QueryBuilder::for($query->orderByRaw($queryOrder))
                ->allowedFields(['id', 'name', 'slug', 'image'])
                ->defaultSort('id')
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
