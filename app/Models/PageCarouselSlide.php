<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageCarouselSlide extends Model
{
    protected $fillable = ['page', 'image', 'title', 'caption', 'ordering'];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
