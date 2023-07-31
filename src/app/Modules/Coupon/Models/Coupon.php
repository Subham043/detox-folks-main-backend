<?php

namespace App\Modules\Coupon\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Coupon extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'discount',
        'maximum_dicount_in_price',
        'maximum_number_of_use',
        'minimum_cart_value',
        'user_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount' => 'float',
        'maximum_dicount_in_price' => 'float',
        'maximum_number_of_use' => 'int',
        'minimum_cart_value' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('coupons')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Coupon has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
