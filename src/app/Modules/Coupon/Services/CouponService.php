<?php

namespace App\Modules\Coupon\Services;

use App\Http\Services\FileService;
use App\Modules\Coupon\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;

class CouponService
{

    public function all(): Collection
    {
        return Coupon::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Coupon::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Coupon|null
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $data): Coupon
    {
        $coupon = Coupon::create($data);
        $coupon->user_id = auth()->user()->id;
        $coupon->save();
        return $coupon;
    }

    public function update(array $data, Coupon $coupon): Coupon
    {
        $coupon->update($data);
        return $coupon;
    }

    public function delete(Coupon $coupon): bool|null
    {
        return $coupon->delete();
    }

    public function main_all(): Collection
    {
        return Coupon::where('is_draft', true)->latest()->get();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('code', 'LIKE', '%' . $value . '%')
            ->orWhere('description', 'LIKE', '%' . $value . '%')
            ->orWhere('discount', 'LIKE', '%' . $value . '%')
            ->orWhere('maximum_dicount_in_price', 'LIKE', '%' . $value . '%')
            ->orWhere('maximum_number_of_use', 'LIKE', '%' . $value . '%')
            ->orWhere('minimum_cart_value', 'LIKE', '%' . $value . '%');
        });
    }
}
