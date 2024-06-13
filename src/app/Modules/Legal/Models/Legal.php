<?php

namespace App\Modules\Legal\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Sitemap\Tags\Url;

class Legal extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'legal_contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'heading',
        'description',
        'description_unfiltered',
        'slug',
        'page_name',
        'is_draft',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {});
        self::updated(function ($model) {});
        self::deleted(function ($model) {});
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str()->slug($value),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('legal pages')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = "Legal page with page name ".$this->page_name." has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}