<?php

namespace App\Modules\WarehouseManagement\Services;

use App\Enums\OrderEnumStatus;
use App\Modules\Order\Models\Order;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class WarehouseManagementService
{

    public function paginateOrder(Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'statuses',
            'payment',
        ])->whereHas('current_status', function($q) {
            $q->where('status', OrderEnumStatus::CONFIRMED);
        }))
        ->allowedIncludes(['products', 'current_status', 'statuses', 'payment'])
        ->defaultSort('-id')
        ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
        ->allowedFilters([
            AllowedFilter::custom('search', new OrderFilter),
        ])
        ->paginate($total)
        ->appends(request()->query());
    }

    public function getOrderById($order_id): Order
    {
        return Order::with([
            'products',
            'current_status',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('current_status', function($q) {
            $q->where('status', OrderEnumStatus::CONFIRMED);
        })->findOrFail($order_id);
    }

}

class OrderFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($qr) use($value){
            $qr->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('id', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('total_price', 'LIKE', '%' . $value . '%')
            ->orWhereHas('products', function($q) use($value) {
                $q->where('name', 'LIKE', '%' . $value . '%');
            });
        });
    }
}
