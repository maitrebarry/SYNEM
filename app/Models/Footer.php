<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'copyright_text',
        'organization_name',
        'newsletter_description',
        'gallery_image_1',
        'gallery_image_2',
        'gallery_image_3',
    ];
}
