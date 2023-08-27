<?php

namespace App\Modules\Order\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'pin',
        'address',
        'coupon_name',
        'coupon_code',
        'coupon_description',
        'coupon_discount',
        'coupon_maximum_dicount_in_price',
        'coupon_maximum_number_of_use',
        'coupon_minimum_cart_value',
        'tax_slug',
        'tax_name',
        'tax_in_percentage',
        'subtotal',
        'total_tax',
        'total_charges',
        'discount_price',
        'total_price',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_in_percentage' => 'float',
        'subtotal' => 'float',
        'total_tax' => 'float',
        'total_charges' => 'float',
        'discount_price' => 'float',
        'total_price' => 'float',
        'coupon_maximum_dicount_in_price' => 'float',
        'coupon_minimum_cart_value' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function charges()
    {
        return $this->hasMany(OrderCharge::class, 'order_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('orders')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Order has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
