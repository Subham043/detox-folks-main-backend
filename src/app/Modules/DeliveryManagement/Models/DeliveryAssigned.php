<?php

namespace App\Modules\DeliveryManagement\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAssigned extends Model
{
    use HasFactory;

    protected $table = 'delivery_assigneds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}