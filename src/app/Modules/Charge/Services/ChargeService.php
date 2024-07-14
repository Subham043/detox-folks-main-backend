<?php

namespace App\Modules\Charge\Services;

use App\Modules\Charge\Models\Charge;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ChargeService
{

    public function all(): Collection
    {
        return Charge::all();
    }

    public function main_all(): Collection
    {
        return Charge::where('is_active', true)->get();
    }

    public function main_exclude_all(): Collection
    {
        return Charge::where('is_active', true)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Charge::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Charge|null
    {
        return Charge::findOrFail($id);
    }

    public function getBySlug(String $slug): Charge|null
    {
        return Charge::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Charge
    {
        $charge = Charge::create($data);
        $charge->user_id = auth()->user()->id;
        $charge->save();
        return $charge;
    }

    public function update(array $data, Charge $charge): Charge
    {
        $charge->update($data);
        return $charge;
    }

    public function delete(Charge $charge): bool|null
    {
        return $charge->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('charges_name', 'LIKE', '%' . $value . '%')
            ->orWhere('charges_slug', 'LIKE', '%' . $value . '%')
            ->orWhere('charges_in_amount', 'LIKE', '%' . $value . '%')
            ->orWhere('exclude_charges_for_cart_price_above', 'LIKE', '%' . $value . '%');
        });
    }
}