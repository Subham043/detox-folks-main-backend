<?php

namespace App\Modules\Settings\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class General extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'general_website_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'address',
        'facebook',
        'linkedin',
        'instagram',
        'youtube',
        'website_logo',
        'website_footer_logo',
        'website_logo_alt',
        'website_logo_title',
        'website_favicon',
        'website_name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $logo_path = 'general_website_settings_logo';
    public $footer_logo_path = 'general_website_settings_footer_logo';
    public $favicon_path = 'general_website_settings_favicon';

    protected $appends = ['website_logo_link', 'website_footer_logo_link', 'website_favicon_link'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('general_settings_main_'.$model->id);
        });
        self::updated(function ($model) {
            Cache::forget('general_settings_main_'.$model->id);
        });
        self::deleted(function ($model) {
            Cache::forget('general_settings_main_'.$model->id);
        });
    }

    protected function websiteLogo(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => !empty($value) ? 'storage/'.$this->logo_path.'/'.$value : $this->website_logo,
        );
    }

    protected function websiteFooterLogo(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => !empty($value) ? 'storage/'.$this->footer_logo_path.'/'.$value : $this->website_footer_logo,
        );
    }

    protected function websiteFavicon(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => !empty($value) ? 'storage/'.$this->favicon_path.'/'.$value : $this->website_favicon,
        );
    }

    protected function websiteLogoLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->website_logo),
        );
    }

    protected function websiteFooterLogoLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->website_footer_logo),
        );
    }

    protected function websiteFaviconLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->website_favicon),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('general settings')
        ->setDescriptionForEvent(
            function(string $eventName){
                $desc = "Website general settings has been {$eventName}";
                $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                return $desc;
            }
            )
        ->logFillable()
        ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}
