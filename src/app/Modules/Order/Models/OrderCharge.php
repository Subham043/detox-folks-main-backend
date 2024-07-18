<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderCharge extends Model
{
    use HasFactory;

    protected $table = 'order_charges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'charges_name',
        'charges_slug',
        'charges_in_amount',
        'is_percentage',
        'include_charges_for_cart_price_below',
        'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'include_charges_for_cart_price_below' => 'float',
        'charges_in_amount' => 'float',
        'is_percentage' => 'boolean',
    ];

    protected $attributes = [
        'charges_in_amount' => 0.0,
        'include_charges_for_cart_price_below' => 0.0,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }


    protected function totalChargeInAmount(): Attribute
    {
        return new Attribute(
            get: function(){
                if($this->include_charges_for_cart_price_below || $this->include_charges_for_cart_price_below > 0){
                    if($this->order->subtotal<=$this->include_charges_for_cart_price_below){
                        if($this->is_percentage){
                            return round($this->order->subtotal * ($this->charges_in_amount/100), 2);
                        }else{
                            return $this->charges_in_amount;
                        }
                    }
                    return 0.0;
                }else{
                    if($this->is_percentage){
                        return round($this->order->subtotal * ($this->charges_in_amount/100), 2);
                    }else{
                        return $this->charges_in_amount;
                    }
                }
            },
        );
    }
}