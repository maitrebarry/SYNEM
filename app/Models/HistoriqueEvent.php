<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueEvent extends Model
{
    use HasFactory;

    protected $table = 'historique_events';

    protected $fillable = [
        'year', 'title', 'text', 'image', 'icon', 'ordering'
    ];

    // helper to get public image path
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) return null;
        return asset('storage/historique/' . $this->image);
    }
}
