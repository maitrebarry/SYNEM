<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactCarousel extends Model
{
    use HasFactory;

    protected $table = 'contact_carousels';
    protected $fillable = ['image', 'title', 'caption', 'ordering'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        return asset('storage/contact/carousel/' . $this->image);
    }
}
