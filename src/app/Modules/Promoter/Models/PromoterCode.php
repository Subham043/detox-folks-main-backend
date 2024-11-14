<?php

namespace App\Modules\Promoter\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoterCode extends Model
{
    use HasFactory;

    protected $table = 'app_promoter_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promoter_id',
        'code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoter_id')->withDefault();
    }
}
