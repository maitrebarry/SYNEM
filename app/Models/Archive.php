<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'image', 'link', 'ordering'];

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) return null;
        return asset('storage/historique/' . $this->image);
    }
}
