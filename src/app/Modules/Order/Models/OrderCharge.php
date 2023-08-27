<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'include_charges_for_cart_price_below',
        'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'include_charges_for_cart_price_below' => 'float',
        'charges_in_amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}
