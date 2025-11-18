<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HomepageDocument extends Model
{
    protected $table = 'homepage_documents';
    protected $guarded = [];
    public $timestamps = true;

    public function homepageContent()
    {
        return $this->belongsTo(HomepageContent::class);
    }
}
