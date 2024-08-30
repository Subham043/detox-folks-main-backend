<?php

namespace App\Modules\Product\Models;

use App\Modules\Authentication\Models\User;
use App\Modules\Category\Models\Category;
use App\Modules\ProductColor\Models\ProductColor;
use App\Modules\ProductImage\Models\ProductImage;
use App\Modules\ProductPrice\Models\ProductPrice;
use App\Modules\ProductSpecification\Models\ProductSpecification;
use App\Modules\SubCategory\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'brief_description',
        'description',
        'description_unfiltered',
        'image',
        'is_draft',
        'is_new',
        'is_on_sale',
        'is_featured',
        'min_cart_quantity',
        'cart_quantity_specification',
        'cart_quantity_interval',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
        'is_new' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'min_cart_quantity' => 'int',
        'cart_quantity_interval' => 'int',
    ];

    public $image_path = 'products';

    protected $appends = ['image_link', 'search_type'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {});
        self::updated(function ($model) {});
        self::deleted(function ($model) {});
    }

    protected function searchType(): Attribute
    {
        return new Attribute(
            get: fn () => 'PRODUCT',
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function imageLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->image),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str()->slug($value),
        );
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class, 'product_sub_categories', 'product_id', 'sub_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function product_specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id');
    }

    public function product_colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function product_prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('products')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Product with name ".$this->name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
    }
}
