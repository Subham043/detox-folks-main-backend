<?php

namespace App\Modules\BillingAddress\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BillingAddress extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'billing_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country',
        'state',
        'city',
        'pin',
        'address',
        'map_information',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'map_information' => null,
    ];

    protected function mapInformation(): Attribute
    {
        return Attribute::make(
            get: fn () => json_decode($this->map_information),
            set: fn ($value) => !empty($value) ? json_encode($value) : null,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('billing_addresses')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Billing address with city ".$this->city." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
