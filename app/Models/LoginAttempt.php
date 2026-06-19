<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'email_tente',
        'attempt_time',
        'status',
    ];

    protected $casts = [
        'attempt_time' => 'datetime',
    ];
}