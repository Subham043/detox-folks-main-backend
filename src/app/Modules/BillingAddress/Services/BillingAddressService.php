<?php

namespace App\Modules\BillingAddress\Services;

use App\Http\Services\FileService;
use App\Modules\BillingAddress\Models\BillingAddress;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class BillingAddressService
{

    public function all(): Collection
    {
        return BillingAddress::where('user_id', auth()->user()->id)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = BillingAddress::where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): BillingAddress|null
    {
        return BillingAddress::where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function create(array $data): BillingAddress
    {
        $billing_address = BillingAddress::create($data);
        $billing_address->user_id = auth()->user()->id;
        $billing_address->save();
        return $billing_address;
    }

    public function update(array $data, BillingAddress $billing_address): BillingAddress
    {
        $billing_address->update($data);
        return $billing_address;
    }

    public function delete(BillingAddress $billing_address): bool|null
    {
        return $billing_address->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('country', 'LIKE', '%' . $value . '%')
        ->orWhere('state', 'LIKE', '%' . $value . '%')
        ->orWhere('city', 'LIKE', '%' . $value . '%')
        ->orWhere('pin', 'LIKE', '%' . $value . '%')
        ->orWhere('address', 'LIKE', '%' . $value . '%');
    }
}
