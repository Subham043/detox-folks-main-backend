<?php

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartAmountService
{
    public function get_subtotal() {
        $amount =  Cart::with([
            'product' => function($query) {
                $query->with([
                    'categories' => function($q){
                        $q->where('is_draft', true);
                    },
                    'sub_categories' => function($q){
                        $q->where('is_draft', true);
                    },
                    'product_specifications',
                    'product_images',
                    'product_prices'=>function($q){
                        $q->orderBy('min_quantity', 'asc');
                    },
                ]);
            },
            'product_price',
        ])->where('user_id', auth()->id())->sum('amount');
        return round($amount, 2);
    }
}
