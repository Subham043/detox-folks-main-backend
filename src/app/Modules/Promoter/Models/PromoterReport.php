<?php

namespace App\Modules\Promoter\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoterReport extends Model
{
    use HasFactory;

    protected $table = 'promoter_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'location',
        'is_app_installed',
        'remarks',
        'user_id',
    ];

    protected $casts = [
        'is_app_installed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promoter()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
