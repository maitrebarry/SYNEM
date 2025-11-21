<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topbar extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
    ];
}
