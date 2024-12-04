<?php

namespace App\Modules\Promoter\Models;

use App\Modules\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    use HasFactory;

    protected $table = 'bank_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bank_name',
        'branch_name',
        'ifsc_code',
        'account_no',
        'account_type',
        'upi_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function promoter()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
