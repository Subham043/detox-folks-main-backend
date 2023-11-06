<?php

namespace App\Modules\BillingInformation\Services;

use App\Modules\BillingInformation\Models\BillingInformation;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class BillingInformationService
{

    public function all(): Collection
    {
        return BillingInformation::where('user_id', auth()->user()->id)->latest()->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = BillingInformation::where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): BillingInformation|null
    {
        return BillingInformation::where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function create(array $data): BillingInformation
    {
        $billing_information = BillingInformation::create($data);
        $billing_information->user_id = auth()->user()->id;
        $billing_information->save();
        return $billing_information;
    }

    public function update(array $data, BillingInformation $billing_information): BillingInformation
    {
        $billing_information->update($data);
        return $billing_information;
    }

    public function delete(BillingInformation $billing_information): bool|null
    {
        return $billing_information->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%')
        ->orWhere('email', 'LIKE', '%' . $value . '%')
        ->orWhere('gst', 'LIKE', '%' . $value . '%')
        ->orWhere('phone', 'LIKE', '%' . $value . '%');
    }
}
