<?php

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class CartService
{

    public function all(): Collection
    {
        return Cart::with([
            'product',
            'product_price',
        ])->where('user_id', auth()->user()->id)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Cart::with([
            'product',
            'product_price',
        ])->where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Cart|null
    {
        return Cart::with([
            'product',
            'product_price',
        ])->where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function create(array $data): Cart
    {
        $cart = Cart::create($data);
        $cart->user_id = auth()->user()->id;
        $cart->save();
        return $cart;
    }

    public function update(array $data, Cart $cart): Cart
    {
        $cart->update($data);
        return $cart;
    }

    public function delete(Cart $cart): bool|null
    {
        return $cart->delete();
    }

}
