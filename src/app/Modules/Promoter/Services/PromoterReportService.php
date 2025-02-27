<?php

namespace App\Modules\Promoter\Services;

use App\Modules\Promoter\Models\PromoterReport;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PromoterReportService
{

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = PromoterReport::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new AgentFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function reportPaginate(Int $total = 10): LengthAwarePaginator
    {
        $query = PromoterReport::query()
		->selectRaw("
            ROW_NUMBER() OVER () AS `SL_NO`,
            DATE_FORMAT(`created_at`, '%d-%m-%Y') AS `DATE`,
            COUNT(`id`) AS `NO_OF_VISITS`,
            SUM(CASE WHEN `is_app_installed` = 'Yes' THEN 1 ELSE 0 END) AS `APP_INSTALLED`,
            SUM(CASE WHEN `is_app_installed` = 'No' THEN 1 ELSE 0 END) AS `APP_NOT_INSTALLED`
        ")
		->groupBy(DB::raw('DATE'));
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new AgentFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function reportExport(): Collection
    {
        $query = PromoterReport::query()
		->selectRaw("
            ROW_NUMBER() OVER () AS `SL_NO`,
            DATE_FORMAT(`created_at`, '%d-%m-%Y') AS `DATE`,
            COUNT(`id`) AS `NO_OF_VISITS`,
            SUM(CASE WHEN `is_app_installed` = 'Yes' THEN 1 ELSE 0 END) AS `APP_INSTALLED`,
            SUM(CASE WHEN `is_app_installed` = 'No' THEN 1 ELSE 0 END) AS `APP_NOT_INSTALLED`
        ")
		->groupBy(DB::raw('DATE'));
        return QueryBuilder::for($query)
        ->defaultSort('-id')
        ->allowedFilters([
            AllowedFilter::custom('search', new AgentFilter),
        ])
        ->get();
    }

    public function getById(Int $id): PromoterReport|null
    {
        return PromoterReport::findOrFail($id);
    }

    public function update(PromoterReport $promoterReport, array $data): PromoterReport|null
    {
        $promoterReport->update($data);
        $promoterReport->refresh();
        return $promoterReport;
    }

    public function delete(PromoterReport $promoterReport): PromoterReport|null
    {
        $promoterReport->delete();
        return $promoterReport;
    }

    public function create(array $data): PromoterReport|null
    {
        return PromoterReport::create([
            ...$data,
            'user_id' => auth()->user()->id
        ]);
    }

    public function export(): Collection
    {
        return QueryBuilder::for(PromoterReport::latest())
        ->defaultSort('-id')
        ->allowedFilters([
            AllowedFilter::custom('search', new AgentFilter),
        ])
        ->get();
    }

}

class AgentFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('location', 'LIKE', '%' . $value . '%');
        });
    }
}
