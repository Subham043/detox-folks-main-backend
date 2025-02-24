<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductTax extends Model
{
    use HasFactory;

    protected $table = 'order_product_taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tax_name',
        'tax_slug',
        'tax_value',
        'order_product_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_value' => 'float',
    ];

    protected $attributes = [
        'tax_value' => 0.0,
    ];

    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id')->withDefault();
    }

}
