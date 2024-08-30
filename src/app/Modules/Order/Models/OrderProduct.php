<?php

namespace App\Modules\Order\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'color',
        'unit',
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

    protected $appends = ['image_link', 'short_description'];

    protected function imageLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->image),
        );
    }

    protected function shortDescription(): Attribute
    {
        return new Attribute(
            get: fn () => str()->limit($this->brief_description, 100),
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'slug', 'slug')->withDefault();
    }
}
