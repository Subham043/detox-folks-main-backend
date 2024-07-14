<?php

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use App\Modules\Charge\Services\ChargeService;

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

    public function get_all_charges() {
        $charges = (new ChargeService)->main_exclude_all();
        return $charges->map(function($item, $key) {
            if($this->get_subtotal()<=$item->include_charges_for_cart_price_below){
                return $item;
            }
        })->filter();
    }

    public function get_charge_price() {
        return round(($this->get_all_charges()->sum('charges_in_amount')),2);
    }

    public function get_total_price() {
        return round(($this->get_subtotal() + $this->get_charge_price()), 2);
    }
}