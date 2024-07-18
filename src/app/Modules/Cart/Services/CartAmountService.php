<?php

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Cart;
use App\Modules\Charge\Services\ChargeService;

class CartAmountService
{
    public function get_subtotal() {
        $amount =  (new CartService)->get_total_amount();
        return round($amount, 2);
    }

    public function get_all_charges() {
        return (new ChargeService)->main_exclude_all();
    }

    public function get_charge_price() {
        return round(array_sum($this->get_all_charges()->pluck('total_charge_in_amount')->toArray()), 2);
    }

    public function get_total_price() {
        return round(($this->get_subtotal() + $this->get_charge_price()), 2);
    }
}