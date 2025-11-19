<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionHeaderImage extends Model
{
    protected $table = 'mission_header_images';
    protected $guarded = [];

    public function missionPage()
    {
        return $this->belongsTo(MissionPage::class);
    }
}
