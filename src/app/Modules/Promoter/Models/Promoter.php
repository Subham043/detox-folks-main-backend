<?php

namespace App\Modules\Promoter\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    use HasFactory;

    protected $table = 'promoters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promoted_by_id',
        'installed_by_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promoted_by()
    {
        return $this->belongsTo(User::class, 'promoted_by_id')->withDefault();
    }

    public function installed_by()
    {
        return $this->belongsTo(User::class, 'installed_by_id')->withDefault();
    }
}
