<?php

namespace App\Modules\DeliverySlot\Services;

use App\Modules\DeliverySlot\Models\DeliverySlot;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class DeliverySlotService
{

    public function all(): Collection
    {
        return DeliverySlot::all();
    }

    public function main_all(): Collection
    {
        return DeliverySlot::where('is_draft', true)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = DeliverySlot::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): DeliverySlot|null
    {
        return DeliverySlot::findOrFail($id);
    }

    public function create(array $data): DeliverySlot
    {
        $delivery_slot = DeliverySlot::create($data);
        return $delivery_slot;
    }

    public function update(array $data, DeliverySlot $delivery_slot): DeliverySlot
    {
        $delivery_slot->update($data);
        return $delivery_slot;
    }

    public function delete(DeliverySlot $delivery_slot): bool|null
    {
        return $delivery_slot->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%');
        });
    }
}
