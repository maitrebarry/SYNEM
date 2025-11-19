<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionDocument extends Model
{
    protected $table = 'mission_documents';
    protected $guarded = [];

    public function missionPage()
    {
        return $this->belongsTo(MissionPage::class);
    }
}
