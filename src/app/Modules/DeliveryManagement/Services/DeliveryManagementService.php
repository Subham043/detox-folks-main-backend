<?php

namespace App\Modules\DeliveryManagement\Services;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Modules\Authentication\Models\User;
use App\Modules\DeliveryManagement\Models\DeliveryAssigned;
use App\Modules\Order\Models\Order;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Collection;

class DeliveryManagementService
{

    public function paginateAgent(Int $total = 10): LengthAwarePaginator
    {
        $query = User::with(['roles'])->whereHas('roles', function($q) { $q->where('name', 'Delivery Agent'); })->withCount('order_assigned')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new AgentFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getDeliveryAgentById(Int $id): User|null
    {
        return User::with(['roles'])->whereHas('roles', function($q) { $q->where('name', 'Delivery Agent'); })->findOrFail($id);
    }

    public function getAllOrderIdsOfAgent(Int $id): array
    {
        return DeliveryAssigned::where('user_id', $id)->pluck('order_id')->toArray();
    }

    public function paginateOrderUnassigend(Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
        ])->doesntHave('delivery_agent'))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateOrderAssigend($agent_id, Int $total = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id) {
            $q->where('user_id', $agent_id);
        }))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function exportOrderAssigend($agent_id): Collection
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id) {
            $q->where('user_id', $agent_id);
        }))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->get();
    }

    public function orderCount($agent_id): int
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id) {
            $q->where('user_id', $agent_id);
        }))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->count();
    }

    public function earningCount($agent_id): int
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id) {
            $q->where('user_id', $agent_id);
        })->whereHas('payment', function($q) {
            $q->where('status', PaymentStatus::PAID);
        }))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->sum('total_price');
    }

    public function lossCount($agent_id): int
    {
        return QueryBuilder::for(Order::with([
            'products',
            'current_status',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id) {
            $q->where('user_id', $agent_id);
        })->whereHas('payment', function($q) {
            $q->where('status', PaymentStatus::REFUND);
        }))
        ->allowedIncludes(['products', 'current_status', 'payment'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'total_price', 'delivery_slot', 'pin')
                ->allowedFilters([
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('current_status', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_status', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('status', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_payment_mode', function (Builder $query, $value) {
                        if($value!='all'){
                            $query->whereHas('payment', function($q) use($value) {
                                $q->where('mode', $value);
                            });
                        }
                    }),
                    AllowedFilter::callback('has_date', function (Builder $query, $value) {
                        $date = explode(' - ', $value);
                        $query->whereBetween('created_at', [...$date]);
                    }),
                    AllowedFilter::custom('search', new OrderFilter),
                ])
                ->sum('total_price');
    }

    public function getOrderAssigendById($agent_id, $order_id): Order
    {
        return Order::with([
            'products',
            'current_status',
            'charges',
            'taxes',
            'statuses',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id, $order_id) {
            $q->where('user_id', $agent_id)->where('order_id', $order_id);
        })->findOrFail($order_id);
    }

    public function getOrderPlacedByIdPaymentPendingVia($agent_id, $order_id): Order|null
    {
        return Order::with([
            'products',
            'current_status',
            'charges',
            'taxes',
            'statuses',
            'payment',
            'delivery_agent'
        ])->whereHas('delivery_agent', function($q) use($agent_id, $order_id) {
            $q->where('user_id', $agent_id)->where('order_id', $order_id);
        })->paymentPendingFrom($order_id, PaymentMode::COD)->findOrFail($order_id);
    }

    public function getOrderPlacedById($order_id): Order|null
    {
        return Order::with([
            'products',
            'current_status',
            'charges',
            'taxes',
            'statuses',
            'payment',
            'delivery_agent'
        ])->paymentPendingFrom($order_id, PaymentMode::COD)->findOrFail($order_id);
    }

    public function assign_orders(User $agent, array $data): User
    {
        $agent->order_assigned()->attach($data);
        return $agent;
    }

    public function unassign_orders(User $agent, array $data): User
    {
        $agent->order_assigned()->detach($data);
        return $agent;
    }

}

class AgentFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
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
