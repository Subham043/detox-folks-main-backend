<?php

namespace App\Modules\Charge\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Charge extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'charges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'charges_name',
        'charges_slug',
        'charges_in_amount',
        'include_charges_for_cart_price_below',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'charges_in_amount' => 'float',
        'include_charges_for_cart_price_below' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'charges_in_amount' => 0.0,
        'include_charges_for_cart_price_below' => 0.0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('testimonial')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Charge has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}