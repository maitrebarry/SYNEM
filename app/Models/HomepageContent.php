<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
    protected $table = 'homepage_contents';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Cast JSON stored filenames to array for easy use in views/controllers
     */
    protected $casts = [
        'compte_rendu_images' => 'array',
    ];

    public function documents()
    {
        return $this->hasMany(HomepageDocument::class);
    }
    public function carouselImages()
    {
        return $this->hasMany(HomepageCarouselImage::class);
    }
}
