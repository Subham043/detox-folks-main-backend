<?php

namespace App\Modules\Authentication\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Modules\Order\Models\Order;
use App\Modules\Promoter\Models\Promoter;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'otp',
        'phone_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $append = [
        'current_role',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($user) {
            // event(new Registered($user));
            // $user->sendEmailVerificationNotification();
        });
        self::updated(function ($user) {});
        self::deleted(function ($user) {});
    }

    //only the `deleted` event will get logged automatically
    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected function currentRole(): Attribute
    {
        $roles_array = $this->getRoleNames();
        $currentRole = count($roles_array) > 0 ? $roles_array[0] : null;
        return Attribute::make(
            get: fn () => $currentRole,
        );
    }


    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Modules\Authentication\Notifications\VerifyEmailQueued);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Modules\Authentication\Notifications\ResetPasswordQueued($token));
    }

    public function order_assigned()
    {
        return $this->belongsToMany(Order::class, 'delivery_assigneds', 'user_id', 'order_id');
    }

    public function app_installer()
    {
        return $this->belongsToMany(User::class, 'promoters', 'promoted_by_id', 'installed_by_id');
    }

    public function app_promoter()
    {
        return $this->belongsToMany(User::class, 'promoters', 'installed_by_id', 'promoted_by_id');
    }

    /**
     * User Factory.
     *
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('user')
        ->setDescriptionForEvent(
                function(string $eventName){
                    $desc = $this->name."<".$this->email."> has been {$eventName}";
                    $desc .= auth()->user() ? " by ".auth()->user()->name."<".auth()->user()->email.">" : "";
                    return $desc;
                }
            )
        ->logOnly(['name', 'email'])
        ->logOnlyDirty();
        // ->logFillable();
    }

}
