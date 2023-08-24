<?php

namespace App\Modules\Wishlist\Services;

use App\Modules\Wishlist\Models\Wishlist;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class WishlistService
{

    public function all(): Collection
    {
        return Wishlist::with([
            'product' => function($query){
                $query->with([
                    'categories',
                    'sub_categories',
                    'product_specifications',
                    'product_images',
                    'product_prices'=>function($q){
                        $q->orderBy('min_quantity', 'asc');
                    },
                ]);
            },
        ])->where('user_id', auth()->user()->id)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Wishlist::with([
            'product',
        ])->where('user_id', auth()->user()->id)->latest();
        return QueryBuilder::for($query)
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Wishlist|null
    {
        return Wishlist::with([
            'product',
        ])->where('user_id', auth()->user()->id)->findOrFail($id);
    }

    public function create(array $data): Wishlist
    {
        $wishlist = Wishlist::create($data);
        $wishlist->user_id = auth()->user()->id;
        $wishlist->save();
        return $wishlist;
    }

    public function update(array $data, Wishlist $wishlist): Wishlist
    {
        $wishlist->update($data);
        return $wishlist;
    }

    public function delete(Wishlist $wishlist): bool|null
    {
        return $wishlist->delete();
    }

}
