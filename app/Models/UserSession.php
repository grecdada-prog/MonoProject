<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'is_active',
        'last_activity_at',
    ];

    protected $dates = ['last_activity_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
