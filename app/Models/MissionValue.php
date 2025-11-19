<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionValue extends Model
{
    protected $table = 'mission_values';
    protected $guarded = [];

    public function missionPage()
    {
        return $this->belongsTo(MissionPage::class);
    }
}
