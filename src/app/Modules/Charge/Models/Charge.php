<?php

namespace App\Modules\Charge\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Cart\Services\CartAmountService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'is_percentage',
        'include_charges_for_cart_price_below',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_percentage' => 'boolean',
        'charges_in_amount' => 'float',
        'include_charges_for_cart_price_below' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'charges_in_amount' => 0.0,
        'include_charges_for_cart_price_below' => 0.0,
    ];

    protected function totalChargeInAmount(): Attribute
    {
        return new Attribute(
            get: function(){
                if($this->include_charges_for_cart_price_below || $this->include_charges_for_cart_price_below > 0){
                    if((new CartAmountService)->get_subtotal()<=$this->include_charges_for_cart_price_below){
                        if($this->is_percentage){
                            return round((new CartAmountService)->get_subtotal() * ($this->charges_in_amount/100), 2);
                        }else{
                            return $this->charges_in_amount;
                        }
                    }
                    return 0.0;
                }else{
                    if($this->is_percentage){
                        return round((new CartAmountService)->get_subtotal() * ($this->charges_in_amount/100), 2);
                    }else{
                        return $this->charges_in_amount;
                    }
                }
            },
        );
    }

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