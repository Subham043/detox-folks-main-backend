<?php

namespace App\Modules\Enquiry\OrderForm\Services;

use App\Modules\Enquiry\OrderForm\Models\OrderForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class OrderFormService
{

    public function all(): Collection
    {
        return OrderForm::with([
            'order' => function($q) {
                $q->with([
                    'current_status',
                    'payment',
                ]);
            }
        ])->whereHas('order')->all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = OrderForm::with([
            'order' => function($q) {
                $q->with([
                    'current_status',
                    'payment',
                ]);
            }
        ])->whereHas('order')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): OrderForm|null
    {
        return OrderForm::with([
            'order' => function($q) {
                $q->with([
                    'current_status',
                    'payment',
                ]);
            }
        ])->whereHas('order')->findOrFail($id);
    }

    public function create(array $data): OrderForm
    {
        return OrderForm::create($data);
    }

    public function update(array $data, OrderForm $contactForm): OrderForm
    {
        $contactForm->update($data);
        return $contactForm;
    }

    public function delete(OrderForm $contactForm): bool|null
    {
        return $contactForm->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('message', 'LIKE', '%' . $value . '%');
        });
    }
}