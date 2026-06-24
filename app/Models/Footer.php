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
        'instagram_url',
        'copyright_text',
        'organization_name',
        'footer_description',
        'newsletter_description',
        'gallery_image_1',
        'gallery_image_2',
        'gallery_image_3',
        'gallery_image_4',
        'gallery_image_5',
        'gallery_image_6',
    ];
}
