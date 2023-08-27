<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'brief_description',
        'image',
        'min_quantity',
        'price',
        'discount',
        'discount_in_price',
        'quantity',
        'amount',
        'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'min_quantity' => 'float',
        'price' => 'float',
        'discount' => 'float',
        'discount_in_price' => 'float',
        'quantity' => 'float',
        'amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}
