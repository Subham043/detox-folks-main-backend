<?php

namespace App\Modules\Order\Models;

use App\Enums\OrderMode;
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
        'gst',
        'country',
        'state',
        'city',
        'pin',
        'address',
        'subtotal',
        'total_charges',
        'total_price',
        'accept_terms',
        'include_gst',
        'order_mode',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'subtotal' => 'float',
        'total_charges' => 'float',
        'total_price' => 'float',
        'accept_terms' => 'boolean',
        'include_gst' => 'boolean',
        'order_mode' => OrderMode::class,
    ];

    protected $attributes = [
        'order_mode' => OrderMode::WEBSITE,
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