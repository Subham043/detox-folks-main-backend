<?php

namespace App\Modules\Settings\Services;

use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;

class ActivityLogService
{

    public function all(): Collection
    {
        return Activity::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Activity::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Activity|null
    {
        return Activity::findOrFail($id);
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('log_name', 'LIKE', '%' . $value . '%')
        ->orWhere('event', 'LIKE', '%' . $value . '%')
        ->orWhere('description', 'LIKE', '%' . $value . '%');
    }
}
