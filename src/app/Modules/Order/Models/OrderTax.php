<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderTax extends Model
{
    use HasFactory;

    protected $table = 'order_taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tax_name',
        'tax_slug',
        'tax_value',
        'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_value' => 'float',
    ];

    protected $attributes = [
        'tax_value' => 0.0,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }


    protected function totalTaxInAmount(): Attribute
    {
        return new Attribute(
            get: function(){
                return round($this->order->subtotal * ($this->tax_value/100), 2);
            },
        );
    }
}
