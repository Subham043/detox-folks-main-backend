<?php

namespace App\Modules\Cart\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Product\Models\Product;
use App\Modules\ProductPrice\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'quantity',
        'color',
        'product_id',
        'product_price_id',
        'user_id',
    ];

    protected $attributes = [
        'color' => null,
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'amount' => 'float',
        'quantity' => 'int',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function product_price()
    {
        return $this->belongsTo(ProductPrice::class, 'product_price_id')->withDefault();
    }

    public function scopeCommonWith(Builder $query): Builder
    {
        return $query->with([
            'product' => function($query) {
                $query->with([
                    'categories' => function($q){
                        $q->where('is_draft', true);
                    },
                    'sub_categories' => function($q){
                        $q->where('is_draft', true);
                    },
                    'product_specifications',
                    'product_images',
                    'product_colors',
                    'taxes',
                    'product_prices'=>function($q){
                        $q->orderBy('min_quantity', 'asc');
                    },
                ]);
            },
            'product_price',
        ]);
    }

    public function scopeBelongsToUser(Builder $query): Builder
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('carts')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Cart item has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
