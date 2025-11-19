<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionItem extends Model
{
    protected $table = 'mission_items';
    protected $guarded = [];

    public function missionPage()
    {
        return $this->belongsTo(MissionPage::class);
    }
}
