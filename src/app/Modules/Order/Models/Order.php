<?php

namespace App\Modules\Order\Models;

use App\Enums\OrderMode;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'otp',
        'gst',
        'country',
        'state',
        'city',
        'pin',
        'address',
        'map_information',
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
        'map_information' => null,
    ];

    protected array $orderWith = [
        'products',
        'charges',
        'statuses',
        'current_status',
        'payment',
    ];

    protected function mapInformation(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !empty($value) ? json_decode($value) : null,
            set: fn ($value) => !empty($value) ? json_encode($value) : null,
        );
    }

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

    public function current_status()
    {
        return $this->hasOne(OrderStatus::class, 'order_id')->latestOfMany();
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function delivery_agent()
    {
        return $this->belongsToMany(User::class, 'delivery_assigneds', 'order_id', 'user_id');
    }

    public function scopeCommonWith(Builder $query): Builder
    {
        return $query->with($this->orderWith);
    }

    public function scopePlacedByUser(Builder $query): Builder
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopePaymentCompleted(Builder $query): Builder
    {
        return $query->whereHas('payment', function($qry){
            $qry->where(function($q){
                $q->where('mode', PaymentMode::COD);
            })->orWhere(function($q){
                $q->where(function($qr){
                    $qr->where('mode', PaymentMode::PHONEPE)->orWhere('mode', PaymentMode::RAZORPAY)->orWhere('mode', PaymentMode::PAYU)->orWhere('mode', PaymentMode::CASHFREE);
                })->where('status', '<>', PaymentStatus::PENDING);
            });
        });
    }

    public function scopePaymentPendingFrom(Builder $query, $order_id, $mode): Builder
    {
        return $query->whereHas('payment', function($qry) use($order_id, $mode){
            $qry->where('mode', $mode)->where('status', PaymentStatus::PENDING)->where('order_id', $order_id);
        });
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