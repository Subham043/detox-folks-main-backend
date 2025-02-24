<?php

namespace App\Modules\ProductPrice\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductPrice extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'product_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'min_quantity',
        'price',
        'discount',
        'product_id',
    ];

    protected $casts = [
        'min_quantity' => 'int',
        'price' => 'float',
        'discount' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $appends = ['discounted_price', 'tax_in_price', 'discount_in_price'];

    protected function discountedPrice(): Attribute
    {
        return new Attribute(
            get: fn () => round($this->price - ($this->price * ($this->discount/100)), 2),
        );
    }

    protected function taxInPrice(): Attribute
    {
        return new Attribute(
            get: fn () => $this->product->taxes->sum(fn($tax) => $this->discounted_price * ($tax->tax_value / 100)),
        );
    }

    protected function discountInPrice(): Attribute
    {
        return new Attribute(
            get: fn () => round(($this->discounted_price + $this->tax_in_price), 2),
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('product_prices')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Product with price ".$this->price." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
