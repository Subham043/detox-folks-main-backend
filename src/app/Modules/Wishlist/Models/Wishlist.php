<?php

namespace App\Modules\Wishlist\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Wishlist extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'wishlists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('wishlists')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Wishlist item has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
