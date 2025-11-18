<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HomepageCarouselImage extends Model
{
    protected $table = 'homepage_carousel_images';
    protected $guarded = [];
    public $timestamps = true;

    public function homepageContent()
    {
        return $this->belongsTo(HomepageContent::class);
    }
}
