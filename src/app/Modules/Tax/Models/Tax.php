<?php

namespace App\Modules\Tax\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Cart\Services\CartAmountService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tax extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tax_name',
        'tax_slug',
        'tax_value',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tax_value' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'tax_value' => 0.0,
    ];

    protected function totalTaxInAmount(): Attribute
    {
        return new Attribute(
            get: function(){
                return round((new CartAmountService)->get_subtotal() * ($this->tax_value/100), 2);
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
        ->useLogName('taxes')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Tax has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
