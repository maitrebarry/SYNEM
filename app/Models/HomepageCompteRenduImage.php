<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HomepageCompteRenduImage extends Model
{
    protected $table = 'homepage_compte_rendu_images';
    protected $guarded = [];
    public $timestamps = true;

    public function homepageContent()
    {
        return $this->belongsTo(HomepageContent::class);
    }
}
