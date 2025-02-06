<?php

namespace App\Modules\Tax\Services;

use App\Modules\Tax\Models\Tax;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class TaxService
{

    public function all(): Collection
    {
        return Tax::all();
    }

    public function main_all(): Collection
    {
        return Tax::where('is_active', true)->get();
    }

    public function main_exclude_all(): Collection
    {
        return Tax::where('is_active', true)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Tax::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Tax|null
    {
        return Tax::findOrFail($id);
    }

    public function getBySlug(String $slug): Tax|null
    {
        return Tax::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Tax
    {
        $charge = Tax::create($data);
        $charge->user_id = auth()->user()->id;
        $charge->save();
        return $charge;
    }

    public function update(array $data, Tax $charge): Tax
    {
        $charge->update($data);
        return $charge;
    }

    public function delete(Tax $charge): bool|null
    {
        return $charge->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('tax_name', 'LIKE', '%' . $value . '%')
            ->orWhere('tax_slug', 'LIKE', '%' . $value . '%')
            ->orWhere('tax_value', 'LIKE', '%' . $value . '%');
        });
    }
}
