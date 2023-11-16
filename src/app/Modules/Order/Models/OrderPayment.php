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
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}
