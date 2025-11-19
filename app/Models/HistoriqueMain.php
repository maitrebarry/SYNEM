<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueMain extends Model
{
    use HasFactory;

    protected $table = 'historique_main';

    protected $fillable = [
        'text',
        'image',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        return asset('storage/historique/' . $this->image);
    }
}
