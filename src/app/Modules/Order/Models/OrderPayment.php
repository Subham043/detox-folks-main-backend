<?php

namespace App\Modules\Order\Models;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $table = 'order_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mode',
        'status',
        'payment_data',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'order_id',
    ];

    protected $casts = [
        'mode' => PaymentMode::class,
        'status' => PaymentStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $attributes = [
        'mode' => PaymentMode::COD,
        'status' => PaymentStatus::PENDING,
        'razorpay_order_id' => null,
        'razorpay_payment_id' => null,
        'razorpay_signature' => null,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}
